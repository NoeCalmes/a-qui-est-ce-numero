<?php

namespace App\Controllers;

use App\Models\NumeroTelephone;
use App\Models\View_model;
use App\Models\faq_model;
use App\Models\Commentaire;

class Home extends BaseController
{
  public function index()
  {
    /* COMMENTAIRES LES PLUS RECENTS DEBUT*/
    $recentComments = Commentaire::join('numeros_telephones', 'commentaires.numero', '=', 'numeros_telephones.numero')
      ->orderByDesc('commentaires.date_commentaire')
      ->select('commentaires.*', 'numeros_telephones.average_note')
      ->take(10)
      ->get();

    // Utiliser une collection pour stocker les numéros déjà affichés
    $displayedNumbers = collect();

    // Filtrer les commentaires pour afficher uniquement une fois chaque numéro
    $uniqueRecentComments = $recentComments->filter(function ($comment) use ($displayedNumbers) {
      if (!$displayedNumbers->contains($comment->numero)) {
        $displayedNumbers->add($comment->numero);
        return true;
      }
      return false;
    });

    // Charger les relations pour chaque commentaire
    $uniqueRecentComments->load('numeroTelephone');

    // Deuxième bloc : récupérer les 10 commentaires les plus récents après ceux du premier bloc
    $additionalRecentComments = Commentaire::join('numeros_telephones', 'commentaires.numero', '=', 'numeros_telephones.numero')
      ->orderByDesc('commentaires.date_commentaire')
      ->select('commentaires.*', 'numeros_telephones.average_note')
      ->whereNotIn('commentaires.numero', $displayedNumbers->toArray())
      ->take(10)
      ->get();

    // Charger les relations pour chaque commentaire
    $additionalRecentComments->load('numeroTelephone');

    /* COMMENTAIRES LES PLUS RECENTS FIN*/

    /* AVERAGE BAR DEBUT */
    $uniqueRecentComments->each(function ($comment) {
      $comment->classification = $this->getClassification($comment->average_note);
    });

    $additionalRecentComments->each(function ($comment) {
      $comment->classification = $this->getClassification($comment->average_note);
    });
    /* AVERAGE BAR FIN */

    // Récupère les 10 numéros avec le plus de commentaires, ordonnés par le nombre de commentaires décroissant
    $numerosCommentaires = Commentaire::select('numero')
      ->selectRaw('COUNT(id) as total_commentaires')
      ->groupBy('numero')
      ->orderByDesc('total_commentaires')
      ->take(7)
      ->get();

    // Filtre les numéros existants
    $numerosExistant = NumeroTelephone::whereIn('numero', $numerosCommentaires->pluck('numero'))->pluck('numero');

    // Initialise la variable numerosCommentaires
    $numerosCommentaires = NumeroTelephone::whereIn('numero', $numerosExistant)->get()->map(function ($numero) {
      return [
        'numero' => $numero->numero,
        'total_commentaires' => Commentaire::where('numero', $numero->numero)->count(),
      ];
    });




    // Utilise le modèle View_model pour récupérer les 10 numéros avec le plus de vues
    $numerosAvecVues = View_model::select('id_numero')
      ->selectRaw('COUNT(id_numero) as total_vues')
      ->groupBy('id_numero')
      ->orderByDesc('total_vues')
      ->limit(7)
      ->get();

    // Initialise la variable numerosDetails
    $numerosDetails = collect($numerosAvecVues)->map(function ($numero) {
      $details = NumeroTelephone::where('numero', $numero['id_numero'])->first();
      return [
        'numero' => $numero['id_numero'],
        'total_vues' => $numero['total_vues'],
        'last_comment' => $details ? optional($details->commentaires->last())->commentaire : null,
      ];
    });

    /* FAQ RANDOM */
    // Initialise un tableau pour stocker les questions aléatoires
    $randomFaqs = [];

    // Boucle jusqu'à ce que nous ayons exactement 3 questions
    while (count($randomFaqs) < 3) {
      // Sélectionne une nouvelle question aléatoire
      $newRandomFaq = Faq_model::inRandomOrder()->first();

      // Vérifie si la question ou la réponse contient [numero]
      if (strpos($newRandomFaq->question, '[numero]') === false && strpos($newRandomFaq->reponse, '[numero]') === false) {
        // Ajoute la nouvelle question à la liste
        $randomFaqs[] = $newRandomFaq;
      }
    }
    /* FAQ RANDOM */

    // Données à passer à la vue
    $data = [
      'recentComments' => $uniqueRecentComments,
      'additionalRecentComments' => $additionalRecentComments,
      'numeros' => $numerosDetails,
      'randomFaqs' => $randomFaqs,
      'numerosCommentaires' => $numerosCommentaires,
    ];

    return view('menu')
      . view('navbar')
      . view('home-page', $data)
      . view('footer/footer');
  }



  protected function getClassification($averageNote)
  {
    if ($averageNote >= 80) {
      return 'Dangereux';
    } elseif ($averageNote >= 60 && $averageNote < 80) {
      return 'Gênant';
    } elseif ($averageNote >= 40 && $averageNote < 60) {
      return 'Neutre';
    } elseif ($averageNote >= 20 && $averageNote < 40) {
      return 'Fiable';
    } else {
      return 'Utile';
    }
  }


  public function getFaq()
  {
    /* FAQ RANDOM */
    // Initialise un tableau pour stocker les questions aléatoires
    $randomFaqs = [];

    // Boucle jusqu'à ce que nous ayons exactement 3 questions
    while (count($randomFaqs) < 20) {
      // Sélectionne une nouvelle question aléatoire
      $newRandomFaq = Faq_model::inRandomOrder()->first();

      // Vérifie si la question ou la réponse contient [numero]
      if (strpos($newRandomFaq->question, '[numero]') === false && strpos($newRandomFaq->reponse, '[numero]') === false) {
        // Ajoute la nouvelle question à la liste
        $randomFaqs[] = $newRandomFaq;
      }
    }
    /* FAQ RANDOM */
    $data = [
      'randomFaqs' => $randomFaqs,
    ];

    return view('menu')
      . view('navbar')
      . view('footer/faqpage', $data)
      . view('footer/footer');
  }

  public function getCg()
  {
    return view('menu')
      . view('navbar')
      . view('footer/cgpage')
      . view('footer/footer');
  }

  public function getPc()
  {
    return view('menu')
      . view('navbar')
      . view('footer/pcpage')
      . view('footer/footer');
  }
  public function getContactc()
  {
    return view('menu')
      . view('navbar')
      . view('footer/contactpage')
      . view('footer/footer');
  }

}