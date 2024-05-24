<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class View_model extends Model
{
    protected $table = 'vues';

    protected $fillable = ['id_numero', 'date_visite', 'heure_visite'];

    public function numeroTelephone()
    {
        return $this->belongsTo(NumeroTelephone::class, 'id_numero', 'numero');
    }
    public function insertView($numero)
    {
        $data = [
            'id_numero' => $numero,
            'date_visite' => Carbon::now()->format('Y-m-d'),  // Retour au format 'Y-m-d'
            'heure_visite' => Carbon::now()->toTimeString()
        ];


        $this->create($data);
    }



    public function getViews($numero)
    {
        $date = Carbon::now()->subDays(30)->toDateString();

        // Utilise les méthodes Eloquent pour construire la requête
        return $this->where('date_visite', '>=', $date)
            ->where('id_numero', $numero)
            ->get();
    }
    public function getNombreVisites($numero)
    {
        return $this->where('id_numero', $numero)->count();
    }

    public function getVisitesParJour($numero, $days)
    {
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays($days);

        return $this->selectRaw('DATE_FORMAT(date_visite, "%Y-%m-%d") as date_visite, COUNT(*) as nombre_visites')
            ->where('id_numero', $numero)
            ->whereBetween('date_visite', [$startDate, $endDate])
            ->groupBy('date_visite')
            ->orderBy('date_visite')
            ->get();
    }




    public function getViewsParHeureAujourdhui($numero)
    {
        $today = Carbon::now()->toDateString(); // Obtenez la date actuelle au format 'Y-m-d'

        $vuesParHeure = $this->selectRaw('DATE_FORMAT(heure_visite, "%H:%i") as heure, COUNT(*) as nombre_vues')
            ->where('id_numero', $numero)
            ->whereDate('date_visite', $today) // Ajoutez cette condition pour filtrer par la date actuelle
            ->groupBy('heure')
            ->orderBy('heure')
            ->get();



        return $vuesParHeure;
    }

    public function getViewsParTrancheHeureAujourdhui($numero)
    {
        // Définir le fuseau horaire sur Paris
        $today = Carbon::now('Europe/Paris');

        // Obtenez les tranches horaires de 00:00 à 24:00
        $tranchesHoraires = [];
        for ($i = 0; $i < 24; $i += 2) {
            $heureDebut = ($i < 10) ? '0' . $i : '' . $i;
            $heureFin = ($i + 2 < 10) ? '0' . ($i + 2) : '' . ($i + 2);
            $tranchesHoraires[] = ["$heureDebut:00", "$heureFin:00"];
        }

        // Ajoutez la tranche horaire 22:00 - 24:00 pour inclure minuit
        $tranchesHoraires[] = ['22:00', '24:00'];

        // Récupérez les donnéesde la base de données
        // Récupérez les données de la base de données
        $vuesParTrancheHeure = $this->selectRaw('DATE_FORMAT(heure_visite, "%H") as heure, COUNT(*) as nombre_vues')
            ->where('id_numero', $numero)
            ->whereDate('date_visite', $today->toDateString()) // Filtrez par la date actuelle
            ->groupBy('heure')
            ->orderBy('heure')
            ->get();

        // Initialisez le tableau avec des valeurs par défaut à 0
        $donneesParTranche = array_fill_keys(array_map(function ($tranche) {
            return $tranche[0];
        }, $tranchesHoraires), 0);

        // Remplacez les valeurs existantes par celles de la base de données
        foreach ($vuesParTrancheHeure as $donnees) {
            foreach ($tranchesHoraires as $tranche) {
                if ($donnees->heure == '00' && $tranche[0] == '00:00') {
                    $donneesParTranche['00:00'] += $donnees->nombre_vues;
                } elseif ($donnees->heure >= $tranche[0] && $donnees->heure < $tranche[1]) {
                    $donneesParTranche[$tranche[0]] += $donnees->nombre_vues;
                    break;
                }
            }
        }

        // Calcul du nombre total de visites
        $totalVisites = array_sum($donneesParTranche);

        // Calcul des pourcentages
        $pourcentagesParTranche = [];
        foreach ($donneesParTranche as $heure => $nombreVues) {
            $pourcentage = ($totalVisites > 0) ? round(($nombreVues / $totalVisites) * 100) : 0;
            $pourcentagesParTranche[$heure] = $pourcentage;
        }


        // Retournez le tableau final des pourcentages
        return $pourcentagesParTranche;
    }


}
