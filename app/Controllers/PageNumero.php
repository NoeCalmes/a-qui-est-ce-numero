<?php

namespace App\Controllers;

use App\Models\NumeroTelephone;
use App\Models\Commentaire;
use App\Models\View;
use App\Models\View_model;
use App\Models\SousCommentaires;
use App\Models\faq_model;
use Illuminate\Support\Facades\Date;


class PageNumero extends BaseController
{

    public function getnumero($numero)
    {
        $unNumero = NumeroTelephone::find($numero);

        /* Vues */
        $viewModel = new View_model();
        $viewModel->insertView($numero);
        $nombreVisites = $viewModel->getNombreVisites($numero);
        /* Vues */

        $randomFaqs = faq_model::inRandomOrder()->take(3)->get();


        $allCommentaires = Commentaire::where('numero', $numero)->get();
        $totalPoints = 0;
        $totalCommentaires = count($allCommentaires);

        if ($totalCommentaires > 0) {
            foreach ($allCommentaires as $commentaire) {
                switch ($commentaire->choix_commentaire) {
                    case 'Dangereux':
                        $totalPoints += 5;
                        break;
                    case 'Gênant':
                        $totalPoints += 4;
                        break;
                    case 'Neutre':
                        $totalPoints += 3;
                        break;
                    case 'Fiable':
                        $totalPoints += 1;
                        break;
                    case 'Utile':
                        $totalPoints += 0;
                        break;
                    default:
                    // Gérer d'autres cas si nécessaire
                }
            }

            // Calculer la note moyenne sur 5
            $averageNote = ($totalPoints / $totalCommentaires);

            // Transformer la note sur 5 en note sur 100
            $averageNoteSur100 = $averageNote * 20;
        } else {
            // Si aucun commentaire, la note est 0 sur 100
            $averageNoteSur100 = 0;
        }
        $unNumero->average_note = $averageNoteSur100;
        $unNumero->save();


        /* POURCENTAGE BARRE PROGRESSION DEBUT */


        // Récupérez les 8 numéros aléatoires
        $randomNumbers = $this->generateRandomNumbers(11);


        // Récupérer les 7 derniers commentaires associés à ce numéro
        $commentaires = Commentaire::where('numero', $numero)
            ->orderBy('date_commentaire', 'desc')
            ->take(7)
            ->get();
        // Récupérer la date du dernier commentaire
        $dernierCommentaire = $commentaires->first();

        $derniersCommentairesGeneraux = Commentaire::orderBy('id', 'desc')
            ->take(7)
            ->get();

        /* INDICATIF NUMERO POUR CARTE Fin  */
        $indicatif = substr($numero, 0, 2);
        $region = $this->getRegionFromIndicatif($indicatif);
        /* INDICATIF NUMERO POUR CARTE Debut  */

        // Récupérer la date du dernier commentaire
        $dernierCommentaire = Commentaire::where('numero', $numero)
            ->orderBy('date_commentaire', 'desc')
            ->first();
        /* Sous Commentaire FIN */

        // Retourner la navbar et la vue avec les données
        $menu = view('menu');
        $navbar = view('navbar');
        $footer = view('footer/footer');
        $numeroDetails = view('numero_details', ['unNumero' => $unNumero, 'commentaires' => $commentaires, 'dernierCommentaire' => $dernierCommentaire, 'randomNumbers' => $randomNumbers, 'derniersCommentairesGeneraux' => $derniersCommentairesGeneraux, 'region' => $region, 'indicatif' => $indicatif, 'nombreVisites' => $nombreVisites, 'viewModel' => $viewModel, 'averageNote' => $averageNoteSur100, 'randomFaqs' => $randomFaqs,]);


        return $menu . $navbar . $numeroDetails . $footer;
    }



    public function postEnvoyerReponse()
    {
        // Récupérer les données du formulaire
        $commentaireParentId = $this->request->getPost('commentaire_parent_id');
        $reponseTexte = $this->request->getPost('reponse_texte');
        $numeroCommentaireParent = $this->request->getPost('numero_commentaire_parent');


        $reponseTexte = htmlspecialchars($reponseTexte, ENT_QUOTES, 'UTF-8');
        // Enregistrez le sous-commentaire dans la base de données
        $sousCommentaire = new SousCommentaires();
        $sousCommentaire->commentaire_id = $commentaireParentId;
        $sousCommentaire->sous_commentaire = $reponseTexte;
        $sousCommentaire->date_sous_commentaire = date('Y-m-d H:i:s');

        // Assurez-vous que toutes les propriétés requises sont définies avant d'appeler save
        $sousCommentaire->save();
        return redirect()->to("/numero/{$numeroCommentaireParent}");
        // Redirigez l'utilisateur vers la page d'origine ou toute autre page souhaitée

    }

    public function postrecherche()
    {
        // Récupérer le numéro de téléphone à partir du formulaire
        $numero = $this->request->getPost('numero');

        // Vérifier si le numéro commence par "+33" et a une longueur de 12 caractères
        if (strlen($numero) == 12 && substr($numero, 0, 3) == '+33') {
            // Reconstruction du numéro en ajoutant "0" après "+33"
            $numero = '0' . substr($numero, 3);
        } elseif (strlen($numero) > 4 && substr($numero, 0, 4) == '0033') {
            // Reconstruction du numéro en enlevant les deux premiers caractères ("00") et ajoutant "0"
            $numero = '0' . substr($numero, 4);
        }

        // Créer une instance du modèle NumeroTelephone
        $numeroTelephone = NumeroTelephone::where('numero', $numero)->first();

        if ($numeroTelephone) {
            return redirect()->to("/numero/$numero");
        } else {
            // Rediriger vers la page précédente avec le paramètre showPopup
            session()->setFlashdata('showPopup', true);
            // Rediriger vers la page précédente
            return redirect()->back();
        }
    }




    public function postajoutcom()
    {
        // Récupère les données du formulaire
        $numero = $this->request->getPost('numero');
        $commentaireTexte = $this->request->getPost('comment');
        $niveauDanger = $this->request->getPost('rating');

        // Récupérer la date actuelle
        $datePublication = Date::now();

        $commentaireTexte = htmlspecialchars($commentaireTexte, ENT_QUOTES, 'UTF-8');

        // Enregistrement dans la base de données
        $commentaire = new Commentaire([
            'numero' => $numero,
            'date_commentaire' => $datePublication,
            'choix_commentaire' => $niveauDanger,
            'commentaire' => $commentaireTexte,
        ]);

        $commentaire->save();

        // Afficher les données récupérées
        return redirect()->to("/numero/$numero");
    }


    /* SIDEBAR 8 NUMEROS ALEATOIRE */
    public function generateRandomNumbers($count = 11)
    {
        // Récupérez 8 numéros aléatoires de la base de données ou de toute autre source
        $randomNumbers = NumeroTelephone::inRandomOrder()->limit($count)->pluck('numero');

        // Retournez les numéros aléatoires
        return $randomNumbers;
    }


    /* CARTE NUM DEBUT */
    private function getRegionFromIndicatif($indicatif)
    {
        switch ($indicatif) {
            case '01':
                return [
                    'name' => "Ile de France (Paris)",
                    'class' => 'ile-de-france'

                ];
            case '02':
                return [
                    'name' => "Région Nord-Ouest (Bretagne, Centre Val de Loire, Normandie, Pays de la Loire)",
                    'class' => 'ile-de-france'
                ];

            case '03':
                return [
                    'name' => "Région Nord-Est (Bourgogne-Franche-Comté, Hauts-de-France)",
                    'class' => 'nord-est'
                ];

            case '04':
                return [
                    'name' => "Région Sud-Est (Auvergne Rhône-Alpes, Provence-Alpes-Côte d'Azur)",
                    'class' => 'sud-est'
                ];

            case '05':
                return [
                    'name' => "Région Sud-Ouest (Nouvelle Aquitaine et Occitanie (Midi-Pyrénées))",
                    'class' => 'sud-ouest'
                ];

            default:
                return [
                    'name' => "Inconnu pour le moment.",
                ];
        }
    }
    /* CARTE NUM FIN*/



    public function recordView($id_numero)
    {
        $view = new View();
        $view->insertView($id_numero);
    }




}


