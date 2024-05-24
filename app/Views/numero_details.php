<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no" />
    <title>
        <?php echo $unNumero->numero; ?>
    </title>

    <!-- BOOTSTRAP DEBUT -->

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <!-- BOOTSTRAP FIN -->

    <!-- GRAPHIQUE JS DEBUT -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <!-- GRAPHIQUE JS FIN -->

</head>

<body>
    <h1 class="title-num">Numero de téléphone :
        <span class="num-page">
            <?php echo $unNumero->numero; ?>
        </span>
    </h1>

    <?php if (isset($unNumero) && strlen($unNumero->numero) === 10): ?>
        <p class="num-similaire">(
            <?php
            $numeroSansPremierCaractere = substr($unNumero->numero, 1);
            $numeroAvecPrefixe = '+33' . $numeroSansPremierCaractere;
            $numeroAvecEspaces = substr_replace($numeroAvecPrefixe, '', 4, 0);
            for ($i = 6; $i < strlen($numeroAvecEspaces); $i += 3) {
                $numeroAvecEspaces = substr_replace($numeroAvecEspaces, '', $i, 0);
            }

            echo $numeroAvecEspaces;
            ?>
            ,
            <?php
            $numeroAvecPointApresPremier = ' ' . substr($unNumero->numero, 1);
            $numeroAvecDeuxPointsApresPremier = substr_replace($numeroAvecPointApresPremier, ' ', 2, 0);
            $numeroAvecPointApresDeuxPoints = substr_replace($numeroAvecDeuxPointsApresPremier, ' ', 5, 0);
            $numeroAvecPointApresTroisPoints = substr_replace($numeroAvecPointApresDeuxPoints, ' ', 8, 0);
            $numeroAvecPointApresQuatrePoints = substr_replace($numeroAvecPointApresTroisPoints, ' ', 11, 0);
            $numeroFormate = preg_replace("/ /", " ", $numeroAvecPointApresQuatrePoints);
            $numeroFormateAvecPrefixe = '00 33' . $numeroFormate;
            echo $numeroFormateAvecPrefixe;
            ?>)
        </p>


    <?php endif; ?>



    <section class="data-array">

        <div class="section-left">
            <h2 class="stat">A Propos du
                <?php echo $unNumero->numero; ?>
            </h2>
            <?php
            if ($averageNote !== 0) {
                function getCommentCategory($averageNote)
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

                $commentCategory = getCommentCategory($averageNote);
                ?>

                <div class="numero-suspect indice-danger-mod">
                    <p class="indice <?php echo strtolower($commentCategory); ?>">
                        <?php echo ucfirst($commentCategory); ?>
                    </p>
                    <p>
                        <?php if ($averageNote >= 80): ?>
                            Ce numéro est considéré comme dangereux
                        <?php elseif ($averageNote >= 60): ?>
                            Ce numéro est considéré comme gênant
                        <?php elseif ($averageNote >= 40): ?>
                            Ce numéro est considéré comme neutre
                        <?php elseif ($averageNote >= 20): ?>
                            Ce numéro est considéré comme fiable
                        <?php else: ?>
                            Ce numéro est considéré comme utile
                        <?php endif; ?>
                    </p>
                </div>

            <?php } // Fin de la condition ?>


            <!-- TABLEAU DEBUT -->
            <table class="info-num">
                <tr class="title-array eval">
                    <td colspan="3">Statistiques</td>
                </tr>
                <tr class="border-td">
                    <td>Niveau de Danger :</td>
                    <td class="twotab first-tab">

                        <div class="d-flex align-items-center">
                            <div class="progress flex-grow-1 mr-2">
                                <div id="progress-bar" class="progress-bar progress-bar-striped"
                                    style="width: <?php echo $averageNote ?>%; background-color: <?php echo getColorClass($averageNote); ?>"
                                    aria-valuenow="<?php echo $averageNote ?>" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <span id="progress-label" class="progress-label">
                                <?php echo round($averageNote) ?>%
                            </span>
                        </div>
                    </td>
                    <?php
                    function getColorClass($averageNote)
                    {
                        if ($averageNote >= 80) {
                            return '#c73320'; // Rouge Dangereux pour plus de 80%
                        } elseif ($averageNote >= 60 && $averageNote < 80) {
                            return '#f17e0c'; // Orange Genant pour 60-80%
                    
                        } elseif ($averageNote >= 40 && $averageNote < 60) {
                            return '#3ab5d8'; // Bleu Neutre pour 60-80%
                        } elseif ($averageNote >= 20 && $averageNote < 40) {
                            return '#4d9981'; // Orange pour 60-80%
                        } else {
                            return '#68c119'; // Vert pour 0% (et Par défaut au cas où $averageNote est en dehors de la plage 0-100)
                        }
                    }
                    ?>
                </tr>
                <tr class="border-td">
                    <td>Nombre d'avis :</td>
                    <td class="twotab">
                        <?php echo count($unNumero->commentaires); ?>
                    </td>
                </tr>
                <tr>
                    <td>Dernier Commentaire :</td>
                    <td class="twotab">
                        <?php echo isset($dernierCommentaire) ? date('d/m/Y', strtotime($dernierCommentaire->date_commentaire)) : 'Aucun commentaire'; ?>
                    </td>
                    <td class="ajoutcom-tab"><a class="ajout-com" href="#ajoutcom-btn">Ajouter un commentaire</a>
                    </td>
                </tr>
                <tr class="title-array">
                    <td colspan="3">Visite</td>
                </tr>
                <tr class="border-td">
                    <td>Nombre de visites :</td>
                    <td class="twotab">
                        <?php echo $nombreVisites; ?>
                    </td>


                </tr>
                <tr>
                    <td>Dernière visite :</td>
                    <td class="twotab progressbar">
                        <?php
                        $derniereVisite = $viewModel->getViews($unNumero->numero)->max('created_at');
                        echo $derniereVisite ? Carbon\Carbon::parse($derniereVisite)->format('d/m/Y') : 'Aucune visite enregistrée';
                        ?>
                    </td>
                </tr>
                <tr class="title-array">
                    <td colspan="3">Nombre de Visite des 30 dernier jours</td>
                </tr>
                <td colspan="3" class="graph-container">
                    <canvas id="visitsChartContainer" style="height: 225px; width: 100%;"></canvas>
                </td>

                <?php
                $viewsForLast30Days = $viewModel->getVisitesParJour($unNumero->numero, 30);
                ?>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var viewsData = <?php echo json_encode($viewsForLast30Days); ?>;
                        var last30DaysDates = generateLast30DaysDates();
                        var filledViewsData = fillMissingDates(last30DaysDates, viewsData);

                        var labels = filledViewsData.map(function (visit) {
                            return visit.date_visite;
                        });

                        var data = filledViewsData.map(function (visit) {
                            return visit.nombre_visites;
                        });

                        // Créer un deuxième jeu de données pour la ligne inférieure
                        var baselineData = filledViewsData.map(function () {
                            return 0; // Toujours à zéro pour créer la ligne inférieure
                        });

                        var ctx = document.getElementById('visitsChartContainer').getContext('2d');

                        var maxDataValue = Math.max(...data);
                        var yAxisMax = maxDataValue + 1.5;

                        var visitsChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Nombre de visites ',
                                    data: data,
                                    pointStyle: 'circle',
                                    radius: 5,
                                    backgroundColor: 'rgba(80, 37, 209, 0.6)',
                                    borderColor: 'rgba(80, 37, 209)',
                                    borderWidth: 1,
                                    fill: false
                                },
                                {
                                    label: 'Baseline',
                                    data: baselineData,
                                    pointRadius: 0,
                                    borderColor: 'rgba(255, 0, 0, 0,)',
                                    borderWidth: 0,
                                    backgroundColor: 'rgba(219, 214, 244,0.9)',
                                    fill: 0
                                }]
                            },
                            options: {
                                scales: {
                                    x: {
                                        type: 'time',
                                        time: {
                                            unit: 'day',
                                            tooltipFormat: 'dd/MM/Y',
                                            displayFormats: {
                                                day: 'dd'
                                            }
                                        }
                                    },
                                    y: {
                                        suggestedMin: 0,
                                        beginAtZero: true,
                                        suggestedMax: yAxisMax,
                                        stepSize: 1,
                                        ticks: {
                                            callback: function (value) {
                                                return Math.round(value);
                                            }
                                        }
                                    },
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                locale: 'fr-FR'
                            }
                        });
                    });


                    // Fonction pour générer les dates des 30 derniers jours
                    function generateLast30DaysDates() {
                        var dates = [];
                        var currentDate = new Date();

                        for (var i = 29; i >= 0; i--) {
                            var date = new Date();
                            date.setDate(currentDate.getDate() - i);
                            dates.push(date.toISOString().split('T')[0]);
                        }

                        return dates;
                    }

                    // Fonction pour remplir les dates manquantes avec des entrées par défaut
                    function fillMissingDates(allDates, existingData) {
                        var filledData = [];

                        allDates.forEach(function (date) {
                            var existingEntry = existingData.find(function (entry) {
                                return entry.date_visite === date;
                            });

                            if (existingEntry) {
                                filledData.push(existingEntry);
                            } else {
                                filledData.push({
                                    date_visite: date,
                                    nombre_visites: 0
                                });
                            }
                        });

                        return filledData;
                    }



                </script>


            </table>


            <div class="ajoutcom-bloc" id="ajoutcom-btn">
                <h2 class="title">Ajouter un commentaire</h1>
                    <form action="<?php echo base_url("PageNumero/ajoutcom"); ?>" method="post" id="comment-form">
                        <div class="bloc-ajout">
                            <div class="bloc-left">
                                <textarea id="comment" name="comment" rows="4" cols="50" required maxlength="3000"
                                    placeholder="Votre expérience avec le numéro <?php echo $unNumero->numero; ?>"
                                    onpaste="return false;"></textarea>

                                <div class="conditons-bloc">
                                    <input type="checkbox" id="accept-conditions" name="accept_conditions" required
                                        title="Veuillez cocher cette case si vous souhaitez continuer">
                                    <label for="accept-conditions" class="conditions">
                                        J'accepte les conditions générales
                                        <span class="check-icon"></span>
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="numero" value="<?= $unNumero->numero; ?>">
                            <div class="bloc-right">
                                <div class="radio-unique">
                                    <div class="form-check utile" onclick="cocherRadio('utile')">
                                        <label class="form-check-label" for="utile">Utile</label>
                                        <input class="radio " type="radio" id="utile" name="rating" value="Utile"
                                            required>
                                    </div>
                                    <div class="form-check fiable" onclick="cocherRadio('fiable')">
                                        <label class="form-check-label" for="fiable">Fiable</label>
                                        <input class="radio" type="radio" id="fiable" name="rating" value="Fiable"
                                            required>
                                    </div>
                                    <div class="form-check neutre" onclick="cocherRadio('neutre')">
                                        <label class="form-check-label" for="neutre">Neutre</label>
                                        <input class="radio" type="radio" id="neutre" name="rating" value="Neutre"
                                            required checked>
                                    </div>
                                    <div class="form-check genant" onclick="cocherRadio('genant')">
                                        <label class="form-check-label" for="genant">Gênant</label>
                                        <input class="radio" type="radio" id="genant" name="rating" value="Gênant"
                                            required>
                                    </div>
                                    <div class="form-check dangereux" onclick="cocherRadio('dangereux')">
                                        <label class="form-check-label" for="dangereux">Dangereux</label>
                                        <input class="radio" type="radio" id="dangereux" name="rating" value="Dangereux"
                                            required>
                                    </div>
                                </div>
                                <button class="btn-com" type="submit">Envoyer</button>
                            </div>
                        </div>
                    </form>
            </div>

            <h2 class="title-com">Commentaires a propos du
                <?php echo $unNumero->numero; ?>
            </h2>

            <!-- Filtre Debut -->
            <div class="filtres-container" style="overflow-x: auto;">
                <?php
                $filtres = [];

                // Compte le nombre de commentaires pour chaque niveau de danger
                foreach ($commentaires as $commentaire) {
                    $choixCommentaire = strtolower($commentaire->choix_commentaire);
                    $filtres[$choixCommentaire] = isset($filtres[$choixCommentaire]) ? $filtres[$choixCommentaire] + 1 : 1;
                }

                // Afficher les filtres
                foreach ($filtres as $choixCommentaire => $nombreCommentaires):
                    ?>
                    <a class="filtre choix-filtre" data-choix="<?php echo strtolower($choixCommentaire); ?>">
                        <span class="croix reset-filter">&#10006;</span>
                        <p class="text-bloc">
                            <?php echo ucfirst($choixCommentaire); ?>
                        </p>
                        <p class="number-filtre <?php echo strtolower($choixCommentaire); ?>">
                            <?php echo $nombreCommentaires; ?>
                        </p>
                    </a>
                <?php endforeach; ?>
            </div>
            <!-- Filtre Fin -->


            <!-- AFFICHAGE COMMENTAIRE ET SOUS COMMENTAIRE -->
            <div class="bloc-affiche">
                <?php foreach ($commentaires as $commentaire): ?>
                    <div class="blocseparation">
                        <div class="first-bloccom">
                            <div class="blocleft-com">
                                <p class="niveaudanger <?php echo strtolower($commentaire->choix_commentaire) ?>-color">
                                    <?php echo $commentaire->choix_commentaire; ?>
                                </p>
                            </div>

                            <div class="blocright-com">
                                <p class="commentaire">
                                    <?php echo $commentaire->commentaire; ?>
                                </p>
                                <div class="bloc-bottom-com">
                                    <div class="bottom-left">
                                        <p class="date">
                                            <i class="fa-regular fa-clock"></i>
                                            <?php echo date('d/m/Y H:i', strtotime($commentaire->date_commentaire)); ?>

                                        </p>
                                    </div>
                                    <div class="bottom-right">
                                        <a class="btn-com"
                                            onclick="toggleReplyForm('replyForm_<?php echo $commentaire->id; ?>')">Répondre</a>
                                        <a class="btn-com" title="Supprimer le commentaire" data-toggle="modal"
                                            data-target="#<?php echo $commentaire->id; ?>">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </a>

                                        <!-- Modal de demande de suppression -->
                                        <div class="modal fade" id="<?php echo $commentaire->id; ?>" tabindex="-1"
                                            role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="confirmDeleteModalLabel">Demande de
                                                            suppression de commentaire concernant le numéro
                                                            <?php echo $commentaire->numero; ?>
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="numero-suspect modal-com">
                                                            <div class="left-modal">
                                                                <p
                                                                    class="indice-dang niveaudanger <?php echo strtolower($commentaire->choix_commentaire) ?>-color">
                                                                    <?php echo $commentaire->choix_commentaire; ?>
                                                                </p>
                                                            </div>
                                                            <div class="right-modal">
                                                                <p class="indice">
                                                                    <?php echo $commentaire->commentaire; ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <p class="p-modal">Dans le formulaire suivant, veuillez fournir une
                                                            brève
                                                            explication de pourquoi ce commentaire devrait être supprimé.
                                                            Après l'envoi du formulaire, nous vous enverrons un lien de
                                                            confirmation à votre adresse e-mail.</p>
                                                        <div class="top-modal">
                                                            <div class="left-top-modal">
                                                                <p class="text-modal">Nom :</p>
                                                                <input class="input-modal" type="text" name="" id="">
                                                            </div>
                                                            <div class="right-top-modal">
                                                                <p class="text-modal">Email :</p>
                                                                <input class="input-modal" type="email" name="" id="">
                                                            </div>
                                                        </div>
                                                        <p class="text-modal p-motif">Motif de la demande de suppression :
                                                        </p>
                                                        <textarea class="textarea-modal" name="" id="" cols=""
                                                            rows="10"></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class=" btn-retour"
                                                            data-dismiss="modal">Retour au numéro
                                                            <?php echo $unNumero->numero; ?>
                                                        </button>
                                                        <button type="button" class=" btn-footer-modal"
                                                            onclick="submitDeleteRequest(<?php echo $commentaire->id; ?>)">Envoyer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Fin du modal de demande de suppression -->
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Formulaire de réponse -->
                        <div
                            class="container-reponse <?php echo (count($commentaire->sousCommentaires) > 0) ? 'has-sous-commentaires' : ''; ?>">
                            <div class="left-container"></div>
                            <div class="right-container">
                                <form class="reponse-form" id="replyForm_<?php echo $commentaire->id; ?>"
                                    action="<?php echo base_url('PageNumero/EnvoyerReponse') ?>" method="post"
                                    style="display: none;">
                                    <p class="reponse-com">Réponse au commentaire précédent</p>
                                    <textarea class="reponse-textarea" name="reponse_texte" pattern=".{1,}"
                                        title="Veuillez entrer au moins un caractère." required maxlength="2000"
                                        onpaste="return false;"></textarea>
                                    <br>
                                    <input type="hidden" name="commentaire_parent_id"
                                        value="<?php echo $commentaire->id; ?>">
                                    <input type="hidden" name="numero_commentaire_parent"
                                        value="<?php echo $commentaire->numero; ?>">

                                    <div class="btn-bottom">
                                        <button class="btn-reponse" type="button"
                                            onclick="cancelReply('replyForm_<?php echo $commentaire->id; ?>')">Annuler</button>
                                        <button class="btn-reponse" type="submit">Envoyer</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Afficher les sous-commentaires -->
                        <div class="sous-com<?php echo count($commentaire->sousCommentaires) > 0 ? ' with-border' : ''; ?>">
                            <?php foreach ($commentaire->sousCommentaires as $sousCommentaire): ?>
                                <div class="sous-commentaire">
                                    <div class="left-reponse">
                                        <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M6 4V12C6 12.663 6.26339 13.2989 6.73223 13.7678C7.20107 14.2366 7.83696 14.5 8.5 14.5H15V12C15 11.5956 15.2436 11.2309 15.6173 11.0761C15.991 10.9214 16.4211 11.0069 16.7071 11.2929L20.7071 15.2929C21.0976 15.6834 21.0976 16.3166 20.7071 16.7071L16.7071 20.7071C16.4211 20.9931 15.991 21.0787 15.6173 20.9239C15.2436 20.7691 15 20.4045 15 20V17.5H8.5C7.04131 17.5 5.64236 16.9205 4.61091 15.8891C3.57946 14.8576 3 13.4587 3 12V4C3 3.44772 3.44772 3 4 3H5C5.55228 3 6 3.44772 6 4Z" />
                                        </svg>
                                    </div>
                                    <div class="right-reponse">
                                        <p class="sous-commentaire-texte">
                                            <?php echo $sousCommentaire->sous_commentaire; ?>
                                        </p>
                                        <div class="bottom-reponse">
                                            <p class="sous-commentaire-date">
                                                <i class="fa-regular fa-clock"></i>

                                                <?php echo date('d/m/Y H:i', strtotime($commentaire->date_commentaire)); ?>

                                            </p>
                                            <a class="btn-com-reponse" title="Supprimer le commentaire" data-toggle="modal"
                                                data-target="#<?php echo $sousCommentaire->id; ?>">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>

                                            <!-- Modal de demande de suppression sous reponse -->
                                            <div class="modal fade" id="<?php echo $sousCommentaire->id; ?>" tabindex="-1"
                                                role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="confirmDeleteModalLabel">Demande de
                                                                suppression de commentaire concernant le numéro
                                                                <?php echo $commentaire->numero; ?>
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="numero-suspect modal-com">
                                                                <div class="left-modal">
                                                                    <p
                                                                        class="indice-dang niveaudanger <?php echo strtolower($commentaire->choix_commentaire) ?>-color">
                                                                        <?php echo $commentaire->choix_commentaire; ?>
                                                                    </p>
                                                                </div>
                                                                <div class="right-modal">
                                                                    <p class="indice">
                                                                        <?php echo $sousCommentaire->sous_commentaire; ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <p class="p-modal">Veuillez fournir une
                                                                brève
                                                                explication de pourquoi ce commentaire devrait être supprimé.
                                                            </p>
                                                            <div class="top-modal">
                                                                <div class="left-top-modal">
                                                                    <p class="text-modal">Nom :</p>
                                                                    <input class="input-modal" type="text" name="" id="">
                                                                </div>
                                                                <div class="right-top-modal">
                                                                    <p class="text-modal">Email :</p>
                                                                    <input class="input-modal" type="email" name="" id="">
                                                                </div>
                                                            </div>
                                                            <p class="text-modal p-motif">Motif de la demande de suppression :
                                                            </p>
                                                            <textarea class="textarea-modal" name="" id="" cols=""
                                                                rows="10"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class=" btn-retour"
                                                                data-dismiss="modal">Retour au numéro
                                                                <?php echo $unNumero->numero; ?>
                                                            </button>
                                                            <button type="button" class=" btn-footer-modal"
                                                                onclick="submitDeleteRequest(<?php echo $commentaire->id; ?>)">Envoyer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Fin du modal de demande de suppression sous reponse -->
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>


                    </div>
                <?php endforeach; ?>

                <?php if ($commentaires->count() < 1): ?>
                    <div class="aucun-com">
                        <i class="fa-regular fa-clock "></i>
                        <p>Aucun commentaire n'a été publié concernant ce numéro jusqu'à présent</p>
                    </div>
                <?php endif; ?>

                <?php if ($commentaires->count() > 0): ?>
                    <div class="ajoutcom-bottom">
                        <a href="#ajoutcom-btn"><i class="fas fa-pencil-alt"></i>Ajouter un Commentaire</a>
                    </div>
                <?php endif; ?>
            </div>
            <!-- AFFICHAGE COMMENTAIRE ET SOUS COMMENTAIRE -->


            <!-- LOCALISATION NUMERO DEBUT -->
            <h2 class="title-map"> Indicatif :
                <span>
                    <?php echo $region['name'] ?>
                </span>
            </h2>
            <div class="container-map">

                <div class="left-map">


                    <div class="map" id="map">

                        <div class="map__image">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:amcharts="http://amcharts.com/ammap"
                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 560 530">
                                <defs>
                                </defs>
                                <g>
                                    <?php

                                    $regionClass = '';

                                    if ($indicatif === '01') {
                                        $regionClass = 'ile-de-france';
                                    } elseif ($indicatif === '02') {
                                        $regionClass = 'nord-ouest';
                                    } elseif ($indicatif === '03') {
                                        $regionClass = 'nord-est';
                                    } elseif ($indicatif === '04') {
                                        $regionClass = 'sud-est';
                                    } elseif ($indicatif === '05') {
                                        $regionClass = 'sud-ouest';
                                    }

                                    ?>
                                    <path id="REGION-GES" title="Grand Est" class="<?php echo $regionClass; ?>"
                                        d="M555.544,136.717l-4.446,-1.406l-1.715,-1.533l-3.117,-0.846l-1.773,-1.913l-0.585,1.023l-1.3,-0.442l-0.917,0.959l-2.997,-2.034l-2.445,1.402l-0.121,-0.814l-2.44,0.758l-1.673,-0.632l-0.071,-1.156l-4.297,-1.53l-1.415,-4.511l-2.425,0.272l0.378,-1.209l-3.317,0.779l-0.1,1.778l-1.507,-0.019l-1.341,1.81l-1.993,-0.949l-2.009,0.93l-0.564,-0.955l-1.112,0.62l-1.313,-1.366l-0.889,0.177l-0.199,-1.051l-0.768,0.468l0.282,1.177l-1.49,0.987l-0.723,-4.861l-0.909,0.203l-1.606,-1.413l-0.548,0.444l-0.889,-1.274l-1.885,0.862l-1.357,-0.862l-0.922,0.64l0.996,2.021l-1.104,1.753l-2.309,-0.981l-1.706,0.278l-1.125,-1.462l0.506,-1.964l-1.179,0.152l-0.262,-2.137l-1.191,-0.583l0.382,-1.339l-2.324,-1.371l-1.951,-2.883l1.398,-1.188l-2.536,-2.328l0.718,-1.126l-0.61,-0.776l-4.795,-2.834l-1.395,0.796l-1.079,-0.414l-0.108,0.701l-1.254,-0.478l-3.91,-2.97l-3.504,0.631l0.179,0.746l-1.37,-0.044l-1.121,2.522l-1.781,-0.84l-0.644,1.216l-2.562,-0.255l-0.568,-2.669l-4.048,-0.344l-1.387,-1.441l0.083,-1.358l-0.822,0.351l-1.847,-1.659l-1.121,1.544l-4.301,-0.714l-1.287,2.729l-2.275,-1.447l-3.482,2.046l-1.794,-6.259l-3.384,-2.229l-1.411,1.259l-0.319,-1.169l1.046,-1.566l-2.582,-2.719l-1.097,0.717l-3.184,-0.512l-0.17,-1.434l-1.449,0.147l-1.378,-3.165l-3.554,-1.237l-0.549,-1.154l-3.715,0.917l-2.259,-0.462l0.959,-1.713l-1.15,-3.023l1.707,-2.75l-1.698,-2.489l-2.342,-0.637l-0.058,-0.682l2.142,-4.464l-0.876,-1.734l0.748,-0.142l0.539,-2.219l0.868,0.877l-0.179,-2.046l1.188,-1.098l-2.886,-2.048l-5.525,5.379l-0.037,5.75l-3.928,0.567l-3.043,2.324l-3.246,0.849l-5.663,-2.046l-3.233,0.676l0,0l-0.599,2.895l1.578,0.636l-0.096,2.288l-1.959,5.667l1.818,1.474l-2.687,3.714l-2.445,1.344l-0.465,2.878l-3.076,-0.301l-0.727,1.01l2.259,3.251l-1.167,1.679l1.088,0.191l0.137,1.11l-1.573,1.128l0.033,2.498l1.092,1.414l-1.271,0.458l-0.058,4.975l-3.205,-1.093l-1.482,-1.864l-2.835,1.686l-0.183,2.25l-3.048,-0.73l-5.505,2.719l0.852,2.837l-0.569,0.945l1.08,1.217l-1.005,1.395l1.175,1.001l0.689,-0.627l0.668,1.907l1.42,-0.272l-0.029,1.405l-1.806,1.051l-0.78,-0.747l-2.661,0.234l-0.889,1.949l1.549,2.681l-2.126,1.068l-0.074,1.472l2.719,-0.392l1.125,1.824l-1.511,0.631l-0.852,2.391l-1.282,0.385l0.544,1.084l-1.221,0.227l-0.142,1.556l-1.76,0.164l-1.773,3.764l0,0l0.071,2.402l-3.471,0.327l1.577,0.352l0.083,0.798l-1.437,0.402l-0.602,1.602l3.067,1.268l0.35,2.491l-1.528,2.163l0.81,0.696l-0.349,1.09l3.458,-0.702l-0.589,0.846l1.631,1.021l-2.407,0.732l0.515,0.933l-2.043,1.208l0.669,1.807l-3.093,0.856l1.308,2.337l-2.267,0.674l0.938,1.654l-0.585,1.785l1.271,0.574l-0.312,1.596l0,0l0.577,1.975l1.594,-1.109l1.549,0.61l1.665,2.927l1.802,1.182l-0.403,1.033l1.723,0.952l-0.755,2.25l0.854,0.435l-1.752,2.546l2.135,-0.329l1.531,3.097l2.309,-0.999l-0.349,-1.124l1.411,0.528l-0.361,2.066l2.143,0.911l1.287,4.566l2.059,1.807l-0.05,0.773l-1.308,-0.093l0.523,1.293l1.175,0.266l0.606,-1.41l0.78,1.349l-0.776,3.115l3.794,-0.068l0.76,-0.754l1.669,1.075l0.644,-1.273l1.221,0.049l0.855,1.174l1.852,-1.798l0,0l0.519,-0.278l0,0l1.461,1.119l0.433,-1.261l-0.743,-0.346l1.308,-0.284l-0.175,1.409l0.938,1.18l1.993,0.315l0.9,-2.249l9.976,-0.414l-0.776,-2.387l1.773,-1.398l3.799,0.94l1.241,-0.619l1.557,1.182l2.308,-0.068l0.669,1.07l-1.018,1.62l2.528,0.111l0.818,1.248l-1.403,1.952l1.204,0.766l0.365,-1.321l1.403,-0.204l1.553,3.364l0,0h0.543l0,0l1.607,3.626l-3.181,2.519l1.794,0.314l0.406,4.683l2.5,-1.5l0.028,1.119l1.32,-0.178l-0.303,1.66l1.083,-0.19l1.565,1.53l2.528,-2.077l-0.203,1.727l2.689,2.199l0.864,-0.356l-0.872,1.584l0.66,1.221l2.814,-2.209l1.366,1.313l2.689,-5.294l1.757,0.301l0.854,-0.738l1.773,0.67l1.743,-2.121l1.217,2.17l3.897,-0.774l-0.257,-2.313l1.009,-1.501l-0.133,-1.293l-1.229,-0.702l0.618,-2.563l2.101,0.05l0.797,-2.436l2.782,0.45l0.834,-3.221l1.507,0.271l-0.013,-1.543l2.043,-3.226l1.129,0.575l-1.332,1.86l0.9,0.136l0.889,-1.316l1.315,0.043l1.541,-2.906l3.96,-0.984l0,0l0.1,0.074l0,0l1.113,2.53l-0.656,0.674l2.441,1.18l-0.142,0.624l0,0v0.321l0,0l3.454,-1.464l4.227,-0.303l1.918,1.168l1.78,3.464l2.707,-1.081l0.835,-1.828l1.806,-0.76l1.615,2.545l5.799,3.301l1.549,2.195l0.734,-0.308l1.03,2.298l6.202,2.438l1.365,3.746l-1.78,4.896l0.635,0.829l0.863,-0.724l1.856,0.467l2.366,4.183l-0.437,1.33l0,0l2.877,0.545l-1.319,3.073l2.586,0.282l0.452,1.101l3.546,-1.224l2.399,0.557l2.869,-2.375l-1.437,-0.576l0.432,-0.906l2.379,0.79l0.938,-0.962l-0.564,-1.372l1.038,0.361l0.336,-0.809l-1.308,-0.711l3.496,-2.214l0.345,-1.768l-2.836,-3.482l-0.481,-2.225l1.511,-2.233l-0.755,-2.808l1.345,-3.821l-0.229,-2.332l2.728,-5.744l-2.191,-3.854l0.303,-5.353l3.724,-6.281l1.104,-4.986l2.143,-1.581l-0.511,-4.186l1.49,-5.978l1.561,-1.531l-0.245,-4.339l1.619,-3.569l5.182,-5.078l0.328,-2.209l1.818,-0.201l0.581,-1.602l2.479,-1.037l2.474,-6.417l3.259,-4.418L555.544,136.717z" />
                                    <path id="REGION-NAQ" class="<?php echo $regionClass; ?>" title="Nouvelle-Aquitaine"
                                        d="M162.747,319.131l0.988,0.399l0.07,3.279l2.026,2.617l0.046,1.492l-0.893,0.576l0.527,1.259l-1.486,1.74l-1.578,-4.829l-4.891,-4.336l-1.1,-5.57l1.777,0.483l2.279,2.675L162.747,319.131zM151.446,306.504l2.981,-0.006l5.787,3.382l1.818,0.096l1.133,-1.123l-0.914,0.191l-0.793,-1.679l-3.047,-1.273l-2.487,0.449l-0.589,-0.735l1.104,-0.993l-1.872,0.132l-1.693,0.932l-0.893,-1.021l1.947,-0.204l-0.996,-1.448l-2.599,0.736l0.183,0.778L151.446,306.504zM309.788,293.444l0.291,2.298l1.935,0.552l-1.316,1.739l2.604,1.966l0.946,-1.264l1.407,2.899l0.419,-0.779l2.105,0.952l1.81,5.552l1.661,1.906l-0.652,4.137l0.893,2.314l1.25,0.733l-0.361,2.61l0.768,1.144l-1.951,0.911l-0.834,1.452l0.507,1.106l-2.346,1.611l-0.315,1.343l-1.313,-0.178l0,0l-0.187,0.042l0,0l-1.084,1.883l-1.153,-0.244l-0.586,0.79l2.283,3.935l1.723,0.611l1.607,2.288l-0.079,4.027l-1.479,0.083l-1.033,2.645l1.162,2.081l1.18,0.396l-1.254,7.974l1.689,1.597l-1.988,1.302l-3.891,-2.457l-1.59,-0.012l0.839,1.45l-0.369,2.985l-1.811,0.889l-1.121,1.959l-0.83,-0.171l-1.184,2.505l-1.942,1.598l0.286,2.366l1.304,0.933l-2.188,1.667l-0.274,3.225l-1.241,-0.252l-1.847,1.553l1.843,3.425l-1.383,1.153l0,0l-0.344,-0.088l0,0l-1.657,0.427l0,0l-3.122,0.099l-1.578,1.281l-0.307,-1.216l-1.341,-0.263l-4.396,3.209l-2.138,-0.847l-0.029,-1.14l-1.797,-0.737l-0.972,-2.042l-2.15,-1.668l-2.329,-0.509l-1.229,0.679l-0.423,-1.007l-5.21,2.464l0,0l0.174,0.69l0,0l1.167,4.49l-1.195,0.351l1.158,1.863l-3.247,2.083l0.174,1.896l-2.811,0.88l-0.033,1.172l1.038,0.653l-0.278,1.421l-0.693,-0.198l-0.498,1.596l-0.714,-0.361l-1.918,2.253l-3.13,0.797l0.245,1.803l-2.454,2.639l0.398,1.167l-2.462,0.668l-1.233,1.44l-1.395,-0.406l1.47,2.158l0.021,3.549l1.569,1.043l0.237,3.532l-4.546,0.231l-0.436,0.954l-0.872,-2.245l-1.005,0.168l-1.121,4.102l1,0.821l0.938,-0.376l1.437,1.612l-0.926,0.439l-0.901,4.382l-2.213,0.375l0.257,0.756l1.071,-0.236l0.361,2.14l-1.329,0.651l-3.026,-0.98l0.365,1.873l-1.723,0.213l-0.731,2.633l-3.167,2.146l-2.939,-3.224l-1.536,1.451l-3.94,-0.052l-0.776,1.571l-2.557,1.3l-2.752,-0.172l-0.59,1.081l-2.964,-1.145l0.075,-0.656l-1.627,0.403l-1.461,2.427l-1.233,-1.656l-2.956,2.322l0.851,2.568l-0.71,1.183l-3.321,-1.889l1.154,-1.431l-1.785,-1.742l-0.386,1.334l-1.997,0.753l-0.087,1.12l-1.266,-0.851l-1.378,0.885l-0.83,-0.654l-2.491,2.395l2.212,1.676l-0.921,0.608l0.627,2.735l-1.375,0.104l0.328,3.312l0.997,0.75l-2.292,1.724l0.32,3.003l-0.88,0.138l0.017,0.914l-0.789,-0.377l0.091,1.406l1.337,0.148l0.361,1.891l2.553,-0.782l0.689,0.908l2.657,-0.092l0.116,2.204l1.134,-0.269l1.083,2.031l-0.407,1.181l1.312,1.123l-1.972,0.513l-0.22,1.59l0.847,0.929l-0.685,0.455l1.013,0.035l1.748,-2l-0.12,4.157l1.382,1.484l-0.81,1.189l-1.528,-0.217l-0.813,1.581l1.2,1.756l-1.329,2.953l-0.988,-0.244l0.22,2.61l-1.59,0.59l-0.465,-0.76l-1.191,2.897l-1.951,0.833l-0.245,2.679l0.785,0.855l-3.354,0.826l0.054,1.284l-1.188,0.516l0.278,4.03l-1.922,0.943l0.585,3.833l0,0l-3.383,2.849l-1.997,0.197l-2.636,-1.799l-1.901,2.785l-5.248,-6.035l-2.229,-0.667l0.087,-2.756l-1.004,-1.283l-2.259,0.955l-4.035,-0.712l-1.565,0.588l-7.095,-4.004l-1.158,0.905l-0.888,-1.545l-2.699,-1.132l-1.399,0.662l-1.93,-1.409l1.585,-2.827l-3.043,1.354l-0.402,3.742l-3.575,-1.002l-1.374,-2.384l2.441,-2.227l1.345,-3.487l-0.27,-3.9l-6.078,-2.04l-1.146,0.318l-0.564,2.193l-1.329,-0.131l-0.664,-3.125l-1.868,-0.472l-2.491,1.074l-0.341,-1.938l-2.051,-1.161l0.689,-0.819l-0.764,-0.506l4.6,-1.355l0.432,0.507l2.794,-2.551l6.381,-12.241l6.21,-32.324l1.657,-19.24l2.615,-6.665l1.781,-0.244l0.423,1.227l4.338,-0.331l1.328,0.681l-0.568,-2.49l-2.143,-1.013l1.482,-0.023l-5.538,-4.619l-0.262,1.771l-2.449,3.034l-0.585,4.548l-0.631,-1.035l4.126,-38.941l0.216,-10.452l2.59,-4.771l1.391,-1.022l0.876,2.21l-0.557,0.348l-0.556,1.099l5.588,4.219l5.306,5.539l4.791,15.184l3.392,4.281l1.017,-0.07l-3.466,-6.386l-2.039,-11.926l-2.798,-7.825l-5.467,-5.23l-2.3,-0.656l-2.221,-3.678l-3.147,-1.03l-4.409,-3.345l-0.836,0.176l0.807,1.245l-0.618,0.029l-0.615,-1.202l-0.062,-5.543l4.301,-1.003l-1.876,-2.993l2.64,-0.338l1.657,-2.901l-0.091,-1.731l-0.05,-0.744l-0.22,-1.768l-0.473,-0.815l1.785,-0.59l-2.034,-5.503l-1.731,-0.687l0.585,-1.224l-1.872,-0.645l0.984,-1.153l-2.358,0.705l-1.295,-1.1l1.378,-1.303l0.17,-1.566l3.741,-2.889l-0.955,-2.545l0.751,-0.851l0,0l1.702,-0.042l0.884,-1.954l3.28,-0.102l1.864,-1.169l-1.312,2.907l1.233,0.743l1.855,-0.995l1.515,0.563l0.785,-1.48l0,0l0.183,0.258l0,0l1.154,-0.264l-0.116,1.031l3.342,1.354l1,-1.396l2.088,0.509l0.365,-1.282l1.395,-0.42l0.179,-0.881l1.739,0.018l0.813,-1.523l-2.765,-1.74l-0.614,1.344l-0.868,-0.378l0.153,-2.065l1.208,-1.381l-1.627,-3.937l1.814,-0.716l-0.972,-2.588l0.54,-2.782l-1.777,-0.88l0.896,-1.634l-1.772,-1.381l0.971,-0.838l-2.645,-3.333l0.096,-2.248l0,0l-0.038,-0.248l0,0l0.831,-0.768l-1.092,-0.707l0,0h-0.295l0,0l-1.648,-1.107l0,0h-0.174l0,0l-2.309,-2.717l0.959,-2.187l-2.146,-0.812l0.477,-0.661l-1.258,-0.036l0.61,-0.982l-0.556,0.346l-0.793,-1.109l1.806,0.285l0.382,-1.213l1.44,0.151l0.876,-1.098l3.018,1.298l1.482,-0.224l0.353,-0.947l2.96,0.382l2.292,-2.161l-0.527,-1.919l2.558,-1.179l1.457,0.115l-0.901,1.713l0.951,-0.942l2.105,0.134l0.457,-1.489l2.337,0.261l3.097,-1.143l2.536,0.699l0.847,-0.857l1.719,0.298l-1.516,2.024l2.068,0.978l1.125,-0.62l0.66,-2.212l2.08,0.863l-0.17,-1.666l1.382,-2.817l1.1,-0.913l1.482,0.669l0,0l1.046,1.102l0.042,1.625l2.487,-0.359l-0.22,1.083l1.133,0.383l0.818,-0.863l0.76,1.435l-0.896,1.981l1.44,0.31l1.333,-1.063l0.909,0.243l0.046,1.512l1.444,-0.522l0.395,3.211l-0.884,0.485l1.337,3.632l1.727,-1.14l3.039,1.212l2.786,-1.782l3.844,0.103l-1.262,-2.972l2.067,-0.085l0.677,1.304l2.391,0.746l0.531,4.273l1.989,2.64l1.818,0.605l0.785,3.659l4.052,3.763l0.602,1.979l-0.972,0.875l0.519,1.755l-1.004,1.271l0.751,1.699l2.201,1.8l2.104,0.253l0.229,1.854l3.031,-0.024l2.138,1.762l0.266,3.521l1.544,0.457l-0.199,0.763l1.2,-0.324l-0.644,1.915l0,0l-0.76,1.014l0,0l0.507,0.498l0.785,-0.81l0.386,1.458l1.669,-0.744l1.86,0.402l0.403,-1.404l1.694,-0.294l2.545,3.221l4.596,-4.835l0.785,2.046l2.682,-1.729l0.793,1.999l2.366,-1.824l1.802,1.692l1.287,-2.107l-0.519,-1.495l1.474,-0.372l2.325,1.85l1.901,-0.961l1.955,0.63l1.947,-0.708l4.55,1.981l4.484,-1.104L309.788,293.444z" />
                                    <path id="REGION-ARA" class="<?php echo $regionClass; ?>"
                                        title="Auvergne-Rhône-Alpes"
                                        d="M510.476,352.168l-0.61,-2.147l-2.101,-0.154l0.224,-1.322l-2.258,-0.614l-0.191,-4.1l-0.768,-0.804l0.946,-3.07l-1.403,-0.853l-2.109,0.148l-4.491,-4.383l0.548,-6.609l5.011,-0.6l2.304,-1.491l0.258,-1.665l1.727,-1.398l-0.273,-1.851l-1.162,-0.928l0.639,-0.482l-3.653,-5.089l-1.931,1.229l-0.714,-0.537l1.055,-4.344l-4.205,-0.776l0.286,-3.95l2.52,-4.583l-3.897,-4.464l1.453,-1.458l0.602,-2.844l-5.729,-1.651l-6.774,-0.144l-11.072,5.815l-1.333,2.889l1.138,0.503l-0.428,1.569l0.959,1.55l2.026,-0.281l-0.59,1.849l-2.624,1.154l-4.309,3.95l-3.172,-0.723l-0.652,1.009l-1.76,-0.585l-1.511,0.974l1.54,-3.172l-1.246,-0.902l0.644,-1.202l5.991,-2.058l-0.926,-2.042l2.814,-4.908l-4.372,-2.952l0,0l-8.107,9.063l-5.986,0.233l-0.478,-2.898l-2.794,-0.893l-0.149,-1.229l-1.96,2.924l-1.241,0.09l-1.116,1.545l-2.707,0.251l-0.697,-0.605l0.402,-2.958l-1.232,0.503l-0.527,-1.948l-0.847,2.242l-0.038,-1.684l-1.727,-1.9l0.655,-0.72l-3.233,-1.848l1.025,-0.918l-0.382,-1.075l-3.264,-0.697l-1.398,-3.047l-1.412,-0.625l-0.05,0.908l-1.299,-0.277l-3.264,1.473l-3.014,-1.846l-1.395,0.842l-0.361,-1.077l-6.729,20.527l-2.246,-0.221l0.39,-1.937l-0.659,-0.903l0.697,-0.347l-2.35,-1.532l1.295,-1.179l-1.278,-1.647l-1.769,0.305l-0.789,2.126l-1.444,-0.228l-0.627,-1.473l-1.237,1.396l-1.437,0.179l-1.881,-1.772l-2.204,0.083l-0.739,4.943l-1.066,0.825l0.436,0.807l-1.864,0.048l-1.938,1.673l-1.3,-0.09l0.191,-1.733l-1.184,0.585l-0.751,-0.998l-1.225,1.231l-1.881,-0.203l-1.245,-1.285l-3.052,1.757l-1.656,0.006l-0.693,-1.997l-3.417,-0.7l0.789,-1.92l-0.756,-2.317l2.2,-0.922l0.092,-1.264l1.702,0.413l0.714,-0.761l-0.826,-0.084l-0.357,-4.18l0.977,-3.801l-1.943,-0.943l-0.116,-0.926l-3.358,0.294l-1.25,-2.604l-1.395,0.758l-2.632,-1.191l-0.232,-3.823l-0.955,-0.403l0.345,-1.097l-1.005,-1.929l-2.471,-2.908l-0.56,-2.886l-1.503,-0.417l-0.536,0.761l0.876,1.491l-2.051,0.097l0.548,2.04l-0.631,0.634l-0.631,-0.676l-1.827,2.255l-1.229,0.048l-0.179,-2.316l-1.328,-1.454l-1.719,0.072l-1.341,1.738l-1.387,-0.332l-0.531,-1.599l-1.304,-0.061l-2.881,2.45l-2.943,-3.078l-2.943,-1.431l-1.104,-2.641l0,0l-2.811,-0.568l-1.777,0.689l-2.955,2.852l-0.138,1.201l-1.984,-0.543l-1.561,1.074l-1.138,-1.835l-0.743,0.127l-0.585,1.606l-3.209,1.714l0.153,1.906l-0.951,-0.766l-1.453,0.754l1.071,1.188l-1.221,1.844l1.545,0.855l0.456,2.48l-3.246,2.063l-2.06,-0.812l-5.234,0.957l-1.562,2.771l-1.029,0.006l-0.743,3.039l0,0l0.291,2.298l1.935,0.552l-1.316,1.739l2.604,1.966l0.946,-1.264l1.407,2.899l0.419,-0.779l2.105,0.952l1.81,5.552l1.661,1.906l-0.652,4.137l0.893,2.314l1.25,0.733l-0.361,2.61l0.768,1.144l-1.951,0.911l-0.834,1.452l0.507,1.106l-2.346,1.611l-0.315,1.343l-1.313,-0.178l0,0l-0.187,0.042l0,0l-1.084,1.883l-1.153,-0.244l-0.586,0.79l2.283,3.935l1.723,0.611l1.607,2.288l-0.079,4.027l-1.479,0.083l-1.033,2.645l1.162,2.081l1.18,0.396l-1.254,7.974l1.689,1.597l-1.988,1.302l-3.891,-2.457l-1.59,-0.012l0.839,1.45l-0.369,2.985l-1.811,0.889l-1.121,1.959l-0.83,-0.171l-1.184,2.505l-1.942,1.598l0.286,2.366l1.304,0.933l-2.188,1.667l-0.274,3.225l-1.241,-0.252l-1.847,1.553l1.843,3.425l-1.383,1.153l0,0l-0.344,-0.088l0,0l-1.657,0.427l0,0l0.64,2.42l1.083,0.812l-0.748,0.976l0.258,1.764l3.342,4.941l-1.744,5.359l1.216,0.052l0.531,3.42l1.499,1.163l0.706,-0.384l-0.395,-1.494l3.313,-1.117l1.316,-0.117l1.063,1.739l5.463,-0.593l0.648,-2.223l2.52,-1.811l-0.424,-1.939l2.097,-2.255l0.175,-3.132l5.496,-5.583l1.553,1.707L330.242,386l1.325,-1.086l2.271,0.006l1.191,4.965l1.337,-0.256l0.693,1.143l-1.063,0.74l0.977,0.997l0.07,3.744l1.864,2.065l1.474,-4.021l0.904,-0.122l-0.519,-0.74l0.813,-4.184l1.092,-2.193l1.101,0.233l0.19,-1.874l0,0h0.237l0,0l-0.245,-1.185l1.166,-1.022l2.504,2.4l1.839,-1.471l-0.527,-1.262l1.084,-0.415l-0.32,-1.116l1.042,-0.409l0.781,0.918l3.545,-2.824l0.021,0.889l1.811,1.058l0.07,2.548l2.886,5.357l0.81,-1.038l2.669,-0.677l0.769,0.578l0.203,-2.9l2.512,-0.012l0.855,1.272l-0.328,1.482l3.188,-0.542l2.744,4.286l1.033,-0.694l0.059,1.672l1.652,0.443l-0.606,1.683l0.959,0.844l-0.606,1.071l1.191,1.931l0.208,2.953l1.083,1.452l0.976,-0.087l1.479,5.716l3.351,3.87l-1.184,0.811l0.727,1.604l-0.889,1.944l0.478,0.636l3.396,-1.018l0.536,1.354l1.478,-0.278l3.271,3.063l1.304,-1.577l-0.033,-1.318l1.599,-1.342l2.728,-0.475l0.149,3.238l1.756,0.416l0.631,-3.191l2.163,-0.307l0.278,0.874l1.527,0.19l0.403,1.336l3.77,1.832l0,0l0.05,-3.439l5.729,0.966l1.262,4.957l2.528,-1.929l1.757,0.058l5.716,-2.763l0.686,1.37l1.332,0.37l1.761,-1.85l0,0l0.664,-0.313l0,0l-0.606,4.796l3.218,1.201l0.806,-1.155l2.03,1.403l2.37,-0.416l1.233,0.809l-0.075,2.602l2.176,0.201l0.813,1.874l2.009,0.207l1.582,-0.974l1.715,-1.436l-0.764,-0.762l0.423,-0.911l1.125,-0.277l1.569,1.356l-0.349,0.997l1.964,0.236l0.17,-0.985l-1.367,-0.629l0.089,-0.865l1.437,-0.393l0.008,-4.088h-1.636l-0.436,-1.948l-1.191,-0.323l0.884,-1.579l-3.383,0.186l-1.101,-1.186l-1.166,0.758l-2.607,-2.147l0.531,-0.949l-1.001,-1.963l0.798,-0.47l1.598,0.806l0.872,-1.031l-1.395,-0.608l-0.271,-2.98l6.477,1.606l0.603,-1.658l1.469,-0.128l-2.777,-2.414l2.113,-3.938l-0.203,-2.319l3.574,0.744l0.843,-1.338l1.665,0.501l1.702,-2.153l-1.308,-0.931l1.166,-3.093l2.316,0.757l2.836,-0.815l1.212,-1.23l-1.278,-1.358l2.831,-1.796l1.611,1.143l3.217,-2.818l4.708,0.724l1.831,-1.284l1.855,1.506l0.813,-0.397l0.104,-4.936l-1.475,-0.848l0.046,-2.626l-3.001,0.135l-1.96,-1.153l0.644,-2.829l1.017,-0.363l-0.572,-1.834l0.622,-1.096l0.731,-0.352l1.278,1.079l1.632,-0.886l1.282,1.208l0.025,1.898l3.578,1.066l1.479,-0.182l-0.262,-2.221l1.249,-0.961l1.3,0.563l1.507,-1.413l2.188,0.868l0,0l2.042,-1.795l2.57,0.147l1.063,-1.261l3.371,1.9l1.835,-0.563l0.008,-1.86l2.18,-0.082l2.329,-2.965l3.334,0.2l2.212,-2.309l-1.033,-4.205l2.196,-1.955l0.494,-2.887L510.476,352.168z" />
                                    <path id="REGION-BFC" class="<?php echo $regionClass; ?>"
                                        title="Bourgogne-Franche-Comté"
                                        d="M472.705,201.039L472.705,201.039l0.142,-0.624l-2.441,-1.18l0.656,-0.674l-1.113,-2.53l0,0l-0.1,-0.074l0,0l-3.96,0.984l-1.541,2.906l-1.315,-0.043l-0.889,1.316l-0.9,-0.136l1.332,-1.86l-1.129,-0.575l-2.043,3.226l0.013,1.543l-1.507,-0.271l-0.834,3.221l-2.782,-0.45l-0.797,2.436l-2.101,-0.05l-0.618,2.563l1.229,0.702l0.133,1.293l-1.009,1.501l0.257,2.313l-3.897,0.774l-1.217,-2.17l-1.743,2.121l-1.773,-0.67l-0.854,0.738l-1.757,-0.301l-2.689,5.294l-1.366,-1.313l-2.814,2.209l-0.66,-1.221l0.872,-1.584l-0.864,0.356l-2.689,-2.199l0.203,-1.727l-2.528,2.077l-1.565,-1.53l-1.083,0.19l0.303,-1.66l-1.32,0.178l-0.028,-1.119l-2.5,1.5l-0.406,-4.683l-1.794,-0.314l3.181,-2.519l-1.607,-3.626l0,0h-0.543l0,0l-1.553,-3.364l-1.403,0.204l-0.365,1.321l-1.204,-0.766l1.403,-1.952l-0.818,-1.248l-2.528,-0.111l1.018,-1.62l-0.669,-1.07l-2.308,0.068l-1.557,-1.182l-1.241,0.619l-3.799,-0.94l-1.773,1.398l0.776,2.387l-9.976,0.414l-0.9,2.249l-1.993,-0.315l-0.938,-1.18l0.175,-1.409l-1.308,0.284l0.743,0.346l-0.433,1.261l-1.461,-1.119l0,0l-0.519,0.278l0,0l-1.852,1.798l-0.855,-1.174l-1.221,-0.049l-0.644,1.273l-1.669,-1.075l-0.76,0.754l-3.794,0.068l0.776,-3.115l-0.78,-1.349l-0.606,1.41l-1.175,-0.266l-0.523,-1.293l1.308,0.093l0.05,-0.773l-2.059,-1.807l-1.287,-4.566l-2.143,-0.911l0.361,-2.066l-1.411,-0.528l0.349,1.124l-2.309,0.999l-1.531,-3.097l-2.135,0.329l1.752,-2.546l-0.854,-0.435l0.755,-2.25l-1.723,-0.952l0.403,-1.033l-1.802,-1.182l-1.665,-2.927l-1.549,-0.61l-1.594,1.109l-0.577,-1.975l0,0l-1.603,-0.611l-0.452,1.721l-1.2,0.162l-2.221,-0.735l-1.163,1.06L345.487,174l-1.541,1.477l-2.328,-0.648l-1.329,3.381l1.333,3.445l-1.781,2.66l-2.781,1.453l-0.013,1.266l0,0l3.84,1.849l-0.552,1.066l0.813,-0.056l0.577,2.708l3.118,2.688l-1.055,0.637l1.075,0.792l0.112,2.103l-1.379,1.613l0,0l-0.249,0.204l0,0l-1.603,2.007l-1.697,0.296l0.149,2.012l-0.71,0.389l1.527,1.073l-0.801,1.005l0.506,2.878l-7.207,1.817l-0.166,2.499l1.274,-0.209l0.017,1.027l1.964,1.341l-0.303,0.817l1.432,1.438l-0.876,1.142l0.175,1.701l1.656,1.81l-4.803,1.374l0,0v-0.221l0,0l-0.52,0.767l3.425,6.118l-2.619,6.095l0.49,1.325l4.238,3.356l-0.141,2.024l2.175,6.527l-0.531,3.465l2.486,2.459l-0.581,2.974l0.656,1.158l-1.25,2.921l0.814,3.379l-1.565,3.441l0,0l1.104,2.641l2.943,1.431l2.943,3.078l2.881,-2.45l1.304,0.061l0.531,1.599l1.387,0.332l1.341,-1.738l1.719,-0.072l1.328,1.454l0.179,2.316l1.229,-0.048l1.827,-2.255l0.631,0.676l0.631,-0.634l-0.548,-2.04l2.051,-0.097l-0.876,-1.491l0.536,-0.761l1.503,0.417l0.56,2.886l2.471,2.908l1.005,1.929l-0.345,1.097l0.955,0.403l0.232,3.823l2.632,1.191l1.395,-0.758l1.25,2.604l3.358,-0.294l0.116,0.926l1.943,0.943l-0.977,3.801l0.357,4.18l0.826,0.084l-0.714,0.761l-1.702,-0.413l-0.092,1.264l-2.2,0.922l0.756,2.317l-0.789,1.92l3.417,0.7l0.693,1.997l1.656,-0.006l3.052,-1.757l1.245,1.285l1.881,0.203l1.225,-1.231l0.751,0.998l1.184,-0.585l-0.191,1.733l1.3,0.09l1.938,-1.673l1.864,-0.048l-0.436,-0.807l1.066,-0.825l0.739,-4.943l2.204,-0.083l1.881,1.772l1.437,-0.179l1.237,-1.396l0.627,1.473l1.444,0.228l0.789,-2.126l1.769,-0.305l1.278,1.647l-1.295,1.179l2.35,1.532l-0.697,0.347l0.659,0.903l-0.39,1.937l2.246,0.221l6.729,-20.527l0.361,1.077l1.395,-0.842l3.014,1.846l3.264,-1.473l1.299,0.277l0.05,-0.908l1.412,0.625l1.398,3.047l3.264,0.697l0.382,1.075l-1.025,0.918l3.233,1.848l-0.655,0.72l1.727,1.9l0.038,1.684l0.847,-2.242l0.527,1.948l1.232,-0.503l-0.402,2.958l0.697,0.605l2.707,-0.251l1.116,-1.545l1.241,-0.09l1.96,-2.924l0.149,1.229l2.794,0.893l0.478,2.898l5.986,-0.233l8.107,-9.063l0,0l0.876,-1.657l-0.548,-1.142l3.491,-4.96l-1.926,-1.89l6.601,-6.4l7.589,-5.567l-0.884,-2.243l1.382,-4.647l-1.341,-2.363l2.699,-2.801l5.172,-1.134l4.064,-3.515l-1.137,-0.99l0.456,-0.905l5.65,-4.068l0.83,-0.962l-0.73,-0.426l4.732,-4.319l-0.506,-2.72l2.217,-0.463l0.568,-1.832l1.885,-0.556l-0.282,-1.747l-1.35,-0.642l-5.704,1.222l1.44,-3.142l0.992,-0.098l0.104,-1.658l2.569,-1.273l-0.784,-2.474l1.693,-0.637l2.167,0.999l2.35,-0.913l0,0l0.437,-1.33l-2.366,-4.183l-1.856,-0.467l-0.863,0.724l-0.635,-0.829l1.78,-4.896l-1.365,-3.746l-6.202,-2.438l-1.03,-2.298l-0.734,0.308l-1.549,-2.195l-5.799,-3.301l-1.615,-2.545l-1.806,0.76l-0.835,1.828l-2.707,1.081l-1.78,-3.464l-1.918,-1.168l-4.227,0.303l-3.454,1.464V201.039z" />
                                    <path id="REGION-BRE" class="<?php echo $regionClass; ?>" title="Bretagne"
                                        d="M80.29,234.826l1.229,0.563l0.129,0.306l2.396,0.562l0.73,2.132l3.242,0.922l-0.556,1.703l-0.731,0.519l-3.151,-1.44l-2.076,0.531l-0.818,-0.61l0.083,-1.526l-1.117,-1.496L80.29,234.826zM81.253,143.01l0.776,1.347l-0.564,0.887l5.571,-2.258l-0.585,2.377l1.212,-0.182l-0.626,0.842l3.055,-0.188l0.32,1.471l-1.64,1.226l0.573,0.276l1.673,0.816l1.594,-0.559l0.934,1.011l-0.685,2.184l5.318,4.521l-0.199,3.35l4.492,2.471l-1.108,1.951l1.171,-0.494l1.61,2.799l-0.361,-2.799l2.292,0.656l-0.257,-0.95l3.28,-3.916l3.358,-1.434l-0.619,-1.409l2.13,-0.476l0.718,1.466l4.209,-3.716l0.295,1.047l1.154,0.22l-2.221,3.026l0.955,0.626l2.927,-2.148l-0.1,1.804l1.461,1.784l0.598,-1.49l0.698,2.166l1.054,-0.625l-0.751,-0.639l0.889,-1.352l1.075,1.089l-1.142,-2.054l1.648,-0.72l0.656,0.751l2.039,-0.37l-0.315,0.802l1.154,0.495l-0.394,1.152l0.73,-0.281l0.926,1.358l-0.747,0.682l1.752,1.739l-0.967,1.356l0.444,1.687l0.847,-1.924l0.407,0.25l0.544,-0.9l-1.138,0.063l0.407,-0.906l-1.129,-2.127l1.627,0.87l-0.561,-1.333l-1.622,-0.593l0.102,-0.916l-1.478,-1.208l0.104,-1.008l2.051,-1.454l-0.423,-0.602l2.304,0.006l-0.967,-0.345l1.013,-0.822l1.233,0.778l2.566,-1.424l0.324,2.057l-1.104,0.771l-0.257,1.817l1.08,1.44l2.673,0.689l8.544,-1.904l0,0l3.462,9.094l1.582,0.125l1.208,1.636l2.798,-0.5l1.05,-1.874l2.051,-0.662l1.054,-2.15l7.635,2.231l0,0l0,0l0,0l-0.465,5.849l1.49,5.346l-2.325,3.895l0.934,3.909l0,0l0.174,0.155l0,0l0.988,6.836l1.221,1.357l-0.498,2.285l0.697,1.782l-1.382,1.169l-3.081,-0.136l-0.066,0.946l-1.22,0.39l-0.889,4.12l-0.818,0.476l0.374,1.401l-1.428,0.993l-1.038,4.628l-4.836,-1.392l-1.03,-1.788l-3.761,-0.444l0.241,1.991l-6.186,2.427l-1.573,3.323l-4.571,0.744l-3.741,-0.689l-3.936,2.293l-0.755,-1.377l-1.632,1.715l-1.15,-0.166l-0.498,1.216l-1.229,-0.067l-0.685,1.148l0.689,1.216l-0.797,1.056l0.112,3.76l-2.462,0.693l-0.262,1.954l-1.063,-0.318l0.17,-1.084l-2.486,1.109l-0.594,-1.195l-1.632,-0.135l-0.785,3.381l-3.5,0.294l-0.901,-1.267l-1.428,1.769l0,0l-1.561,-0.123l-0.257,-2.578l2.52,-0.38l-2.848,-1.593l-4.667,1.232l-0.357,-0.944l-1.096,0.08l-1.017,1.507l-1.852,-0.759l-3.707,1.213l-1.433,-0.729l-0.992,-2.133l-1.287,-0.104l-0.27,-1.134l-1.922,-0.711l-0.225,0.705l-1.042,-0.772l-1.32,-0.08l-0.843,-0.7l-3.446,0.571l-0.191,3.421l2.001,2.756l-2.138,-0.27l-1.304,-3.437l1.142,-0.951l-0.598,-3.116l-5.671,-5.522l-2.217,-0.627l-0.876,0.59l-0.22,-1.531l-3.641,0.923l-3.056,-4.185l-6.302,-0.763l-2.022,-1.781l-1.432,0.9l-3.853,-0.019l-1.956,-2.7l0.847,-1.486l-0.764,-0.104l-1.27,-0.685l-0.652,-1.913l-1.781,1.179l0.602,1.777l-2.769,0.715l-2.669,-1.764l-1.694,0.913l-1.864,3.724l-7.315,0.012l-0.66,-1.078l1.536,-1.202l-0.481,-3.368l-2.611,-4.608l-3.724,-2.646l-1.582,-0.396l-0.834,0.73l-2.628,-1.782l-2.694,0.167l-1.644,-0.811l1.246,-0.285l-0.32,-1.3l6.729,-0.725l0.685,-0.868l2.063,0.211l2.889,-1.252l2.242,-0.155l2.383,1.252l1.573,-2.523l-2.009,-4.599l-2.383,-0.118l-0.212,-0.801l-3.545,-1.261l-1.457,0.422l-0.785,2.472l-1.706,1.372l0.274,-2.453l-0.826,-1.534l1.195,-0.908l-0.693,-0.64l-2.557,0.311l-0.278,-1.573l2.433,-0.156l-0.066,-3.024l1.627,-0.642l-0.984,2.39l0.851,1.164l0.701,-0.722l0.665,0.921l2.113,-0.983l1.366,0.155l0.855,1.207l3.778,-1.437l1.482,0.105l0.444,0.996l0.544,-1.188l-3.715,-0.983l1.432,-0.971l-1.196,-0.573l0.561,-1.414l-2.039,1.09l-0.245,1.158l-1.831,0.106l0.818,-1.096l-2.528,0.978l2.412,-3.532l-0.979,-0.779l-0.532,0.885l-1.603,-0.206l-1.947,1.24l-3.55,1.657l-3.055,-1.065l-1.104,1.489l-2.711,0.13l-0.73,-1.993l1.191,-1.315l-1.387,-1.926l1.416,-3.363l-0.66,-3.01l1.947,-2.544l1.067,0.325l0.021,-1.188l3.869,-0.407l0.191,-1.733l1.752,0.388l-0.224,-1.409l1.142,-0.226l-0.025,-0.808l1.789,0.989l2.437,-1.265l1.624,0.25l-1.466,-1.078l3.761,-1.422l2.076,0.79l-0.66,1.441l0.672,0.501l0.901,-0.983l3.275,-0.157l-1.129,-0.426l1.499,-1.774l3.591,-0.533l1.694,1.198l0.249,-1.856l1.624,-0.458l0.266,-0.891l0.262,0.985l1.283,-0.979l-0.257,1.819l0.768,0.621l-0.582,0.896l1.669,0.714l0.324,-0.708h2.835l0.008,-0.965l0.976,-1.574l0.333,-0.301l1.585,1.18l2.13,-0.445l2.242,1.348l1.495,-0.608l-0.61,2.332l1.474,-1.717l0.543,1.034l1.167,-0.038l0.61,-0.865l-0.71,-0.426l0.033,-2.114l1.453,-1.299l-1.486,-0.76l-0.004,-2.066l-0.1,-0.283l0.004,-0.735l0.859,-0.095l0.482,1.006l0.81,-0.654l-0.25,-1.307l0.847,0.188l0.685,-1.232l0.544,1.194l0.452,-1.081l0.884,1.377l1.291,-0.333l-0.531,1.433l1.769,-0.125l0.37,-0.974l2.869,-1.421l2.358,0.251L81.253,143.01z" />
                                    <path id="REGION-CVL" class="<?php echo $regionClass; ?>"
                                        title="Centre-Val de Loire"
                                        d="M277.46,138.463L280.03,141.612L279.308,142.878L280.919,143.532L280.599,144.488L281.487,144.815L280.699,145.362L280.786,149.749L282.671,150.646L280.599,153.407L282.064,154.292L281.637,155.783L283.306,156.729L284.29,158.966L286.324,158.947L286.075,161.294L288.068,161.463L289.309,162.757L288.835,165.283L289.907,168.193L291.331,168.162L291.654,169.435L292.738,169.828L294.291,169.853L295.246,168.786L295.15,171.974L297.205,172.248L296.719,173.557L297.653,174.616L296.832,175.98L297.213,177.755L296.392,177.923L297.001,179.279L299.841,179.509L302.49,178.109L304.927,178.626L304.441,177.543L305.666,177.83L306.571,175.793L308.34,176.547L308.318,178.632L309.224,177.593L310.54,177.767L310.54,177.767L310.756,177.356L310.756,177.356L311.752,176.479L313.052,178.047L314.928,177.556L315.741,181.039L317.676,181.356L319.615,183.14L319.636,186.785L319.183,187.442L318.212,186.928L316.567,189.458L319.802,189.44L321.367,188.404L327.437,189.489L329.462,188.131L328.719,186.803L329.819,187.629L331.317,186.679L331.413,188.981L332.165,189.093L334.111,187.461L337.047,187.033L337.047,187.033L340.887,188.882L340.335,189.948L341.148,189.893L341.726,192.601L344.844,195.288L343.789,195.925L344.864,196.717L344.977,198.82L343.598,200.433L343.598,200.433L343.349,200.637L343.349,200.637L341.746,202.645L340.049,202.941L340.198,204.953L339.488,205.342L341.016,206.415L340.215,207.42L340.721,210.298L333.514,212.115L333.348,214.614L334.622,214.405L334.639,215.432L336.603,216.772L336.3,217.59L337.731,219.028L336.855,220.17L337.03,221.871L338.687,223.681L333.884,225.055L333.884,225.055L333.884,224.834L333.884,224.834L333.364,225.601L336.789,231.719L334.17,237.813L334.66,239.139L338.898,242.495L338.758,244.519L340.933,251.045L340.401,254.51L342.888,256.97L342.307,259.943L342.963,261.102L341.713,264.022L342.527,267.401L340.962,270.842L340.962,270.842L340.962,270.842L340.962,270.842L338.151,270.274L336.374,270.963L333.419,273.815L333.281,275.017L331.297,274.474L329.736,275.548L328.599,273.712L327.855,273.839L327.271,275.445L324.062,277.159L324.215,279.065L323.264,278.299L321.811,279.053L322.882,280.241L321.661,282.084L323.206,282.94L323.662,285.42L320.416,287.483L318.356,286.671L313.122,287.628L311.561,290.399L310.531,290.405L309.788,293.444L309.788,293.444L309.788,293.444L309.788,293.444L306.305,292.922L301.821,294.026L297.271,292.045L295.324,292.753L293.369,292.123L291.468,293.084L289.143,291.234L287.669,291.606L288.188,293.102L286.901,295.208L285.099,293.516L282.733,295.34L281.94,293.342L279.258,295.07L278.474,293.024L273.878,297.859L271.333,294.638L269.639,294.932L269.236,296.336L267.376,295.934L265.708,296.678L265.322,295.22L264.537,296.03L264.03,295.532L264.03,295.532L264.79,294.518L264.79,294.518L265.434,292.604L264.217,292.802L264.217,292.802L264.217,292.802L264.217,292.802L264.259,292.64L264.259,292.64L264.259,292.64L264.259,292.64L262.233,290.345L263.167,290.429L262,287.586L260.485,286.425L257.455,286.449L257.226,284.596L255.122,284.343L252.921,282.542L252.17,280.843L253.174,279.572L252.655,277.817L253.627,276.942L253.025,274.962L248.973,271.199L248.188,267.54L246.37,266.935L244.381,264.295L243.85,260.022L241.459,259.276L240.782,257.972L238.715,258.057L239.977,261.029L236.132,260.926L233.347,262.708L230.308,261.496L228.581,262.635L227.244,259.003L228.128,258.518L227.734,255.306L226.29,255.828L226.244,254.316L225.334,254.073L224.002,255.136L222.562,254.826L223.458,252.845L222.698,251.41L221.88,252.273L220.747,251.891L220.967,250.808L218.48,251.167L218.439,249.542L217.393,248.441L217.393,248.441L217.945,246.907L217.343,246.517L218.418,245.183L218.339,241.281L221.216,237.301L220.921,236.403L222.698,235.174L221.478,234.086L224.33,227.923L224.525,226.256L223.192,225.533L224.845,222.012L224.845,222.012L224.795,221.49L224.795,221.49L225.787,221.066L231.076,223.632L231.881,223.117L230.279,220.6L231.06,219.126L232.762,220.803L233.795,220.631L234.405,219.046L239.894,217.393L240.836,216.09L239.877,216.385L239.462,214.571L241.164,212.484L244.273,211.555L243.888,210.551L247.047,207.544L246.715,203.317L247.918,202.626L248.807,204.077L248.977,201.378L250.368,200.891L249.11,198.047L250.085,195.35L248.222,194.892L248.072,192.824L250.119,192.675L250.21,191.299L248.886,191.008L250.044,190.742L250.447,188.913L253.141,188.572L248.238,185.127L248.238,185.127L249.592,183.929L247.844,180.989L248.591,179.235L246.482,178.583L247.088,177.164L247.819,175.993L253.075,174.024L255.636,169.797L254.154,168.811L253.98,167.544L254.793,167.175L254.241,166.07L255.25,164.602L253.498,163.771L254.129,162.976L253.573,162.307L250.476,160.918L250.297,159.222L249.135,159.072L249.667,157.707L248.99,155.445L248.99,155.445L248.99,155.445L248.99,155.445L250.991,154.329L251.518,152.585L253.419,152.993L256.188,151.971L256.188,151.971L257.048,151.971L257.048,151.971L258.098,151.801L259.281,149.899L261.444,150.64L261.697,147.952L265.895,149.924L266.774,149.165L267.327,149.962L270.453,149.724L272.113,148.467L271.682,145.117L275.758,142.765L276.215,141.19L275.248,139.509z" />
                                    <path id="REGION-COR" class="<?php echo $regionClass; ?>" title="Corse"
                                        d="M579.428,571.32l1.212,-2.684l0.635,0.664l2.2,-0.957l1.794,-2.259l-4.31,-1.469l-1.266,0.804l-0.282,-2.294l-2.819,1.086l-0.096,-0.976l-1.901,-0.066l2.977,-1.996l-0.768,-1.431l2.479,-0.521l0.494,-1.16l0.195,-0.999l-0.411,-1.8l1.021,-0.7l-2.279,-2.106l-1.208,1.401l-3.205,-0.123l-1.416,0.917l0.64,-2.295l-1.267,-1.68l2.316,-0.194l0.855,-0.796l-0.369,-1.642l3.615,-2.072l-1.17,-0.769l-0.798,-2.726l-1.689,0.658l-1.959,-1.907l-1.304,0.368l0.179,-1.311l-1.014,-1.104l0.997,-0.419l-0.162,-1.49l-0.328,-1.257l-1.37,-0.52l6.427,-1.638l-1.433,-1.996l-2.324,-0.179l-0.274,-0.755l1.258,-0.728l-0.548,-0.984l-2.578,0.89l-0.345,-2.312l1.018,0.341l1.656,-0.974l-0.142,-1.675l2.063,0.056l0.369,-1.075l-0.651,-0.443l1.312,-1.485l-1.295,-0.544l0.743,-2.082l2.229,-0.538l-0.581,-2.481l0.813,-0.854l0.07,1.309l1.146,-0.566l1.399,1.005l0.552,-2.741l2.694,-0.332l0.494,-1.169l2.217,-0.979l0.627,0.731l2.815,-0.428l1.88,-1.125l-0.107,-1.98l2.781,-1.976l4.031,-0.208l3.188,3.298l1.914,-3.338l-0.096,-3.318l-1.374,-2.154l1.282,-1.845l-0.764,-1.931l1.632,-1.355l-0.876,-3.951l3.449,-0.979l1.682,1.414l-0.506,1.346l1.727,8.79l-1.951,7.417l3.604,7.144l-0.021,9.957l1.146,4.93l-0.046,4.86l-0.395,5.127l-5.699,8.352l-0.743,8.561l0.515,4.729l-1.403,1.917l0.577,1.854l-1.835,0.741l-1.412,0.199l-1.22,1.781l0.373,1.184l1.274,-1.664l2.122,0.586l-1.067,1.952l-2.894,1.58l0.195,3.655l-2.3,1.197l0.17,1.391l-0.747,0.221l0.552,0.513l1.785,-1.335l-0.245,0.806l-1.603,2.607l-1.71,0.127l-0.946,-1.549l-2.641,-0.1l1.125,-2.404l-2.104,-0.364l0.395,-2.025l-1.657,1.347l-1.702,-1.838l-0.631,0.895l-0.942,-1.033l-1.681,0.188l-1.835,-1.944l-1.387,0.359l0.456,-1.613l-2.765,-0.492l0.706,-1.056L579.428,571.32z" />
                                    <path id="REGION-IDF" class="<?php echo $regionClass; ?>" title="Île-de-France"
                                        d="M285.855,120.07L286.262,119.487L287.354,120.546L286.303,121.648L286.831,122.409L286.831,122.409L287.208,122.396L287.208,122.396L287.96,123.631L289.994,123.01L290.351,123.757L291.372,123.555L291.31,124.346L293.074,123.644L293.298,124.435L297.151,123.124L298.23,123.612L301.514,121.427L302.146,122.712L303.503,122.478L303.806,123.409L304.292,122.808L305.234,124.391L307.223,123.39L307.912,124.232L307.156,124.954L307.82,125.169L309.996,124.631L311.171,122.94L312.989,125.365L313.711,124.631L316.41,125.46L316.165,126.283L317.244,125.814L319.059,127.27L318.502,127.991L320.241,128.401L321.08,126.839L322.367,129.659L324.422,127.852L326.847,130.5L328.055,129.918L328.615,130.847L330.408,130.241L330.048,129.451L331.704,128.585L333.514,130.253L335.527,129.375L337.217,129.824L338.367,128.907L339.147,130.203L340.036,128.907L342.428,129.312L342.568,127.301L345.408,127.991L346.491,128.465L346.022,129.482L347.566,131.529L346.596,133.922L350.083,136.433L350.635,138.551L352.3,137.927L353.296,140.485L354.902,139.213L355.538,142.765L358.137,143.494L358.784,144.922L359.784,143.998L359.784,143.998L359.784,143.998L359.784,143.998L359.855,146.4L356.385,146.727L357.962,147.079L358.045,147.877L356.608,148.279L356.007,149.88L359.074,151.148L359.424,153.639L357.896,155.802L358.705,156.498L358.356,157.588L361.814,156.886L361.226,157.732L362.856,158.753L360.449,159.485L360.964,160.418L358.921,161.625L359.59,163.433L356.497,164.289L357.805,166.626L355.538,167.3L356.476,168.955L355.891,170.739L357.161,171.313L356.85,172.909L356.85,172.909L356.85,172.909L356.85,172.909L355.247,172.298L354.795,174.019L353.595,174.18L351.374,173.445L350.211,174.504L345.487,174L343.946,175.476L341.618,174.828L340.289,178.209L341.622,181.654L339.841,184.314L337.06,185.767L337.047,187.033L337.047,187.033L334.111,187.461L332.165,189.093L331.413,188.981L331.317,186.679L329.819,187.629L328.719,186.803L329.462,188.131L327.437,189.489L321.367,188.404L319.802,189.44L316.567,189.458L318.212,186.928L319.183,187.442L319.636,186.785L319.615,183.14L317.676,181.356L315.741,181.039L314.928,177.556L313.052,178.047L311.752,176.479L310.756,177.356L310.756,177.356L310.54,177.767L310.54,177.767L309.224,177.593L308.318,178.632L308.34,176.547L306.571,175.793L305.666,177.83L304.441,177.543L304.927,178.626L302.49,178.109L299.841,179.509L297.001,179.279L296.392,177.923L297.213,177.755L296.832,175.98L297.653,174.616L296.719,173.557L297.205,172.248L295.15,171.974L295.246,168.786L294.291,169.853L292.738,169.828L291.654,169.435L291.331,168.162L289.907,168.193L288.835,165.283L289.309,162.757L288.068,161.463L286.075,161.294L286.324,158.947L284.29,158.966L283.306,156.729L281.637,155.783L282.064,154.292L280.599,153.407L282.671,150.646L280.786,149.749L280.699,145.362L281.487,144.815L280.599,144.488L280.919,143.532L279.308,142.878L280.03,141.612L277.46,138.463L277.46,138.463L277.46,138.463L277.46,138.463L277.095,136.773L278.204,136.055L276.182,136.219L276.522,133.815L275.26,131.321L275.862,130.664L276.934,131.504L277.81,129.299L278.258,130.323L278.258,130.323L278.478,130.316L278.478,130.316L282.479,129.299L283.929,126.403L284.618,121.363z" />
                                    <path id="REGION-OCC" class="<?php echo $regionClass; ?>" title="Occitanie"
                                        d="M408.142,419.977l0.979,3.176l1.415,0.069l0.594,1.553l-0.685,4.584l0.64,1.521l2.735,0.91l2.408,4.407l-1.267,0.063l0.013,1.442l-7.157,5.542l1.071,1.251l-1.014,0.809l0.354,2.798l-1.611,3.225l0.632,2.289l-3.646,-1.236l-2.267,0.566l-2.475,4.186l1.901,0.663l-0.432,1.319l-5.318,3.077l-0.423,0.435l-3.404,1.653l-0.44,2.247l0,0l-3.96,-1.471l-0.664,-1.335l0.834,-1.289l-1.333,-1.188l-5.496,0.383l-2.093,0.885l0.507,0.365l-3.367,2.024l-3.233,3.391l-1.977,0.678l-0.22,0.969l-3.351,0.968l-3.836,3.538l-1.868,3.063l-3.267,-1.324l-3.155,0.955l-0.432,0.329l-6.668,5.421l-2.407,3.634l-3.467,9.506l0.926,1.255l-1.32,12.066l0.631,0.079l-0.548,5.118l0.656,3.932l3.915,1.42l-0.752,0.595l0.291,1.296l1.063,0.303l0.901,2.131l-3.804,0.751l-2.217,-2.77l-2.728,0.533l-0.826,-0.937l-1.216,1.446l-1.993,-0.611l-2.956,2.747l-2.71,-0.331l-2.512,1.138l-0.876,0.975l0.834,2.569l-3.952,-0.99l-1.47,1.393l-2.458,-0.374l-2.038,-2.979l-7.314,-2.499l-2.3,1.25l-1.906,-0.443l-2.91,3.434l-2.86,0.789l-2.196,-1.909l-1.221,-3.961l-2.221,0.208l-2.399,-2.126l-3.915,-0.448l0.386,-3.407l2.346,-1.454l-2.873,-0.489l0.407,-1.5l-5.667,-0.546l-2.018,-1.636l-2.354,0.141l-1.017,2.619l-1.32,0.208l-1.963,-4.706l-1.611,-0.94l0.224,-0.895l-4.272,0.236l-0.942,-0.721l-2.545,1.081l-3.745,-4.489l-3.956,0.101l-0.984,-1.076l-1.416,0.93l-2.91,-2.103l-6.144,-1.992l-2.047,1.265l0.457,1.923l-1.055,1.234l0.901,0.434l-1.017,1.15l1.486,1.599l-0.1,1.993l-3.259,-0.816l-7.261,0.839l-2.59,-1.869l-2.728,2.849l-1.445,-2.381l-3.462,-1.188l-4.816,2.19l-1.897,-0.175l-0.685,0.918l-2.275,-0.411l-0.49,-1.424l-1.806,-0.474l-1.993,-4.057l-1.142,0.62l-5.189,-3.524l0,0l-0.585,-3.833l1.922,-0.943l-0.278,-4.03l1.188,-0.516l-0.054,-1.284l3.354,-0.826l-0.785,-0.855l0.245,-2.679l1.951,-0.833l1.191,-2.897l0.465,0.76l1.59,-0.59l-0.22,-2.61l0.988,0.244l1.329,-2.953l-1.2,-1.756l0.813,-1.581l1.528,0.217l0.81,-1.189l-1.382,-1.484l0.12,-4.157l-1.748,2l-1.013,-0.035l0.685,-0.455l-0.847,-0.929l0.22,-1.59l1.972,-0.513l-1.312,-1.123l0.407,-1.181l-1.083,-2.031l-1.134,0.269l-0.116,-2.204l-2.657,0.092l-0.689,-0.908l-2.553,0.782l-0.361,-1.891l-1.337,-0.148l-0.091,-1.406l0.789,0.377l-0.017,-0.914l0.88,-0.138l-0.32,-3.003l2.292,-1.724l-0.997,-0.75l-0.328,-3.312l1.375,-0.104l-0.627,-2.735l0.921,-0.608l-2.212,-1.676l2.491,-2.395l0.83,0.654l1.378,-0.885l1.266,0.851l0.087,-1.12l1.997,-0.753l0.386,-1.334l1.785,1.742l-1.154,1.431l3.321,1.889l0.71,-1.183l-0.851,-2.568l2.956,-2.322l1.233,1.656l1.461,-2.427l1.627,-0.403l-0.075,0.656l2.964,1.145l0.59,-1.081l2.752,0.172l2.557,-1.3l0.776,-1.571l3.94,0.052l1.536,-1.451l2.939,3.224l3.167,-2.146l0.731,-2.633l1.723,-0.213l-0.365,-1.873l3.026,0.98l1.329,-0.651l-0.361,-2.14l-1.071,0.236l-0.257,-0.756l2.213,-0.375l0.901,-4.382l0.926,-0.439l-1.437,-1.612l-0.938,0.376l-1,-0.821l1.121,-4.102l1.005,-0.168l0.872,2.245l0.436,-0.954l4.546,-0.231l-0.237,-3.532l-1.569,-1.043l-0.021,-3.549l-1.47,-2.158l1.395,0.406l1.233,-1.44l2.462,-0.668l-0.398,-1.167l2.454,-2.639l-0.245,-1.803l3.13,-0.797l1.918,-2.253l0.714,0.361l0.498,-1.596l0.693,0.198l0.278,-1.421l-1.038,-0.653l0.033,-1.172l2.811,-0.88l-0.174,-1.896l3.247,-2.083l-1.158,-1.863l1.195,-0.351l-1.167,-4.49l0,0l-0.174,-0.69l0,0l5.21,-2.464l0.423,1.007l1.229,-0.679l2.329,0.509l2.15,1.668l0.972,2.042l1.797,0.737l0.029,1.14l2.138,0.847l4.396,-3.209l1.341,0.263l0.307,1.216l1.578,-1.281l3.122,-0.099l0,0l0.64,2.42l1.083,0.812l-0.748,0.976l0.258,1.764l3.342,4.941l-1.744,5.359l1.216,0.052l0.531,3.42l1.499,1.163l0.706,-0.384l-0.395,-1.494l3.313,-1.117l1.316,-0.117l1.063,1.739l5.463,-0.593l0.648,-2.223l2.52,-1.811l-0.424,-1.939l2.097,-2.255l0.175,-3.132l5.496,-5.583l1.553,1.707L330.242,386l1.325,-1.086l2.271,0.006l1.191,4.965l1.337,-0.256l0.693,1.143l-1.063,0.74l0.977,0.997l0.07,3.744l1.864,2.065l1.474,-4.021l0.904,-0.122l-0.519,-0.74l0.813,-4.184l1.092,-2.193l1.101,0.233l0.19,-1.874l0,0h0.237l0,0l-0.245,-1.185l1.166,-1.022l2.504,2.4l1.839,-1.471l-0.527,-1.262l1.084,-0.415l-0.32,-1.116l1.042,-0.409l0.781,0.918l3.545,-2.824l0.021,0.889l1.811,1.058l0.07,2.548l2.886,5.357l0.81,-1.038l2.669,-0.677l0.769,0.578l0.203,-2.9l2.512,-0.012l0.855,1.272l-0.328,1.482l3.188,-0.542l2.744,4.286l1.033,-0.694l0.059,1.672l1.652,0.443l-0.606,1.683l0.959,0.844l-0.606,1.071l1.191,1.931l0.208,2.953l1.083,1.452l0.976,-0.087l1.479,5.716l3.351,3.87l-1.184,0.811l0.727,1.604l-0.889,1.944l0.478,0.636l3.396,-1.018l0.536,1.354l1.478,-0.278l3.271,3.063l1.304,-1.577l-0.033,-1.318l1.599,-1.342l2.728,-0.475l0.149,3.238l1.756,0.416l0.631,-3.191l2.163,-0.307l0.278,0.874l1.527,0.19l0.403,1.336L408.142,419.977z" />
                                    <path id="REGION-HDF" class="<?php echo $regionClass; ?>" title="Hauts-de-France"
                                        d="M389.314,73.741L389.193,72.833L387.288,72.447L387.965,70.889L386.886,69.697L387.948,67.783L390.792,66.487L389.422,64.158L389.538,62.375L386.558,62.331L387.662,60.418L387.483,57.198L390.406,54.616L389.879,53.366L387.961,52.258L387.441,53.178L388.164,54.259L386.936,54.279L386.076,51.331L384.391,50.852L382.24,47.731L377.15,49.808L374.996,48.179L370.732,48.238L369.088,51.228L367.021,47.043L367.71,44.881L367.087,41.411L364.924,38.848L360.44,39.42L361.196,37.057L359.365,36.432L358.228,38.17L355.268,39.167L351.76,37.005L351.241,32.391L349.593,28.299L350.672,27.097L350.481,25.45L347.604,23.914L345.943,19.672L344.324,19.397L343.315,20.786L340.306,20.7L337.707,22.167L335.793,26.078L333.314,24.07L332.11,24.528L330.94,23.815L328.188,18.33L325.934,17.563L324.551,18.192L323.068,15.753L323.455,12.571L322.683,11.153L324.41,9.333L323.385,6.513L321.998,5.703L320.752,0L313.985,2.787L312.835,1.957L306.679,4.071L305.222,4.459L304.371,4.479L302.295,5.559L292.771,7.834L287.544,9.53L284.074,13.359L280.745,14.336L282.094,18.755L281.276,23.429L280.524,24.456L280.146,22.886L279.977,23.848L280.549,34.08L282.986,37.734L280.977,36.1L279.636,45.063L282.546,47.238L279.686,47.589L278.935,52.705L279.536,54.279L281.155,54.415L282.479,57.114L284.747,57.45L285.211,58.802L283.999,59.681L282.027,58.466L281.043,58.886L279.765,57.47L278.336,57.593L276.705,59.746L275.406,63.958L272.325,66.81L272.325,66.81L273.6,67.28L275.281,66.436L275.426,68.402L286.204,78.229L287.121,82.839L289.271,86.206L287.748,86.142L287.619,87.699L286.258,87.987L286.312,89.748L285.245,90.529L285.955,91.425L287.532,90.055L287.839,90.529L285.593,93.766L286.585,95.107L285.457,96.526L286.532,97.637L285.734,97.72L285.734,97.72L285.552,97.72L286.934,99.067L286.739,100.19L287.723,100.547L286.436,102.741L287.574,103.659L288.18,102.244L289.462,102.748L288.703,104.908L288.703,104.908L288.304,105.169L288.304,105.169L286.756,106.787L286.291,108.887L287.362,109.001L286.598,109.784L288.242,111.52L288.711,116.258L289.761,116.372L290.023,117.35L289.404,119.157L288.109,117.489L286.087,117.978L285.855,120.07L285.855,120.07L286.262,119.487L287.354,120.546L286.303,121.648L286.831,122.409L286.831,122.409L287.208,122.396L287.208,122.396L287.96,123.631L289.994,123.01L290.351,123.757L291.372,123.555L291.31,124.346L293.074,123.644L293.298,124.435L297.151,123.124L298.23,123.612L301.514,121.427L302.146,122.712L303.503,122.478L303.806,123.409L304.292,122.808L305.234,124.391L307.223,123.39L307.912,124.232L307.156,124.954L307.82,125.169L309.996,124.631L311.171,122.94L312.989,125.365L313.711,124.631L316.41,125.46L316.165,126.283L317.244,125.814L319.059,127.27L318.502,127.991L320.241,128.401L321.08,126.839L322.367,129.659L324.422,127.852L326.847,130.5L328.055,129.918L328.615,130.847L330.408,130.241L330.048,129.451L331.704,128.585L333.514,130.253L335.527,129.375L337.217,129.824L338.367,128.907L339.147,130.203L340.036,128.907L342.428,129.312L342.568,127.301L345.408,127.991L346.491,128.465L346.022,129.482L347.566,131.529L346.596,133.922L350.083,136.433L350.635,138.551L352.3,137.927L353.296,140.485L354.902,139.213L355.538,142.765L358.137,143.494L358.784,144.922L359.784,143.998L359.784,143.998L361.558,140.233L363.317,140.07L363.459,138.514L364.68,138.287L364.136,137.203L365.418,136.818L366.27,134.427L367.78,133.796L366.655,131.972L363.937,132.363L364.011,130.892L366.137,129.824L364.588,127.143L365.477,125.194L368.138,124.96L368.918,125.707L370.724,124.656L370.753,123.251L369.333,123.523L368.665,121.617L367.976,122.244L366.801,121.243L367.806,119.848L366.726,118.631L367.295,117.686L366.443,114.849L371.948,112.13L374.996,112.86L375.179,110.61L378.014,108.925L379.496,110.789L382.701,111.882L382.759,106.907L384.029,106.449L382.938,105.035L382.904,102.537L384.478,101.409L384.341,100.299L383.253,100.107L384.42,98.429L382.161,95.178L382.888,94.168L385.964,94.469L386.429,91.591L388.874,90.247L391.561,86.533L389.742,85.059L391.701,79.392L391.797,77.104L390.219,76.468L390.817,73.574z" />
                                    <path id="REGION-NOR" class="<?php echo $regionClass; ?>" title="Normandie"
                                        d="M288.703,104.908L288.703,104.908l0.76,-2.16l-1.283,-0.503l-0.606,1.415l-1.138,-0.918l1.287,-2.194l-0.984,-0.357l0.195,-1.123l-1.382,-1.347l0,0h0.183l0,0l0.797,-0.083l-1.075,-1.111l1.129,-1.418l-0.992,-1.342l2.246,-3.237l-0.307,-0.474l-1.578,1.37l-0.71,-0.896l1.067,-0.781l-0.054,-1.761l1.361,-0.288l0.129,-1.557l1.523,0.064l-2.15,-3.367l-0.917,-4.61l-10.777,-9.827l-0.145,-1.967L273.6,67.28l-1.274,-0.471l0,0l-7.605,6.146l-4.596,2.239l-2.707,1.222l-2.449,-0.708L247.196,79l-7.73,1.162l-10.371,7.037l-5.393,2.158l-1.781,1.703l-0.307,1.599l-0.162,1.049l-3.628,8.466l1.059,1.938l3.063,1.886l4.43,0.91l0.984,-0.757l-0.469,1.362l-2.499,0.083l-4.006,1.687l-5.326,4.862l-3.537,1.752l-5.65,1.047l-1.063,-0.457l-1.295,-0.298l-4.774,-2.571l-14.995,-1.01l-8.718,-3.083l-4.542,0.483l-1.81,1.895l0.1,1.023l-1.623,-1.194l-1.951,1.779l1.449,-4.616l-5.928,-8.958l0.478,-2.208l1.067,-0.198l0.714,-1.763l1.083,0.377l-1.502,-5.71l-4.334,-0.678l-4.305,0.627l-0.577,1.836l-1.931,0.876l-3.101,-0.167l-3.126,-0.601l-3.288,-0.736l-2.52,-0.793l-1.1,-1.728l-1.457,0.762l-2.325,-1.306l-0.245,3.271l2.993,1.017l1.108,1.784l0.332,3.852l-1.959,2.354l1.652,1.926l1.59,8.359l0.926,-0.185l3.33,2.98l0.88,2.533l2.458,5.042l0.523,-0.558l0.922,5.205l-0.718,2.113l0.419,4.057l0.896,2.411l0.851,-1.667l-0.212,5.368l0.482,0.517l-0.461,0.485l-0.909,4.829l-1.254,0.855l1.661,0.836l0.253,4.9l1.677,0.841l1.204,2.923l1.989,0.777l0.112,1.015l2.545,-1.278l-1.05,1.028l2.412,1.679l-2.989,-0.664l-2.69,1.259l-0.847,-0.934l-0.046,1.096l-2.474,-0.896l0,0l3.462,9.094l1.582,0.125l1.208,1.636l2.798,-0.5l1.05,-1.874l2.051,-0.662l1.054,-2.15l7.635,2.231l0,0l2.719,1.181l1.295,-0.318l0.714,-1.431l1.943,1.287l2.641,-0.168l1.312,2.753l1.453,-0.63l0.785,1.829l1.922,-0.867l-0.697,-1.467l1.723,0.325l1.05,-1.062l0.502,2.572l2.242,-1.71l1.922,-0.1l1.715,-2.236l4.704,-0.063l1.81,1.605l1.328,-2.386l2.067,0.937l1.246,-1.812l-0.896,-0.775l0.573,-0.976l1.739,0.044l2.574,2.226l-1.175,1.087l1.121,3.354l3.99,0.356l-0.013,4.777l2.08,-1.421l0.635,1.029l1.814,0.199l0.552,-1.926l3.558,-2.046l-0.515,-0.999l1.216,0.424l-0.058,-0.905l5.335,-0.974l2.275,1.349l1.1,2.146l-0.511,0.817l0.917,5.607l3.62,1.45l0.424,-0.722l0.141,1.586l1.764,2.232l3.67,0.174l0.619,0.802l-0.303,-1.429l0.917,-0.485l1.258,0.578l2.246,4.125l0.934,0.484l1.544,-0.857l0,0l1.354,-1.199l-1.748,-2.939l0.748,-1.754l-2.109,-0.653l0.606,-1.419l0.73,-1.17l5.256,-1.969l2.562,-4.228l-1.482,-0.986l-0.174,-1.267l0.813,-0.369l-0.552,-1.105l1.009,-1.468l-1.752,-0.831l0.631,-0.794l-0.557,-0.669l-3.097,-1.389l-0.179,-1.696l-1.254,-0.326l0.623,-1.189l-0.93,-1.861l2.254,-1.517l0.527,-1.744l1.901,0.408l2.769,-1.022l0,0h0.859l0,0l1.05,-0.169l1.183,-1.902l2.163,0.741l0.253,-2.688l4.197,1.972l0.88,-0.76l0.552,0.797l3.126,-0.238l1.66,-1.256l-0.432,-3.35l4.077,-2.353l0.457,-1.574l-0.967,-1.682l2.212,-1.046l0,0l-0.365,-1.689l1.108,-0.719l-2.021,0.164l0.34,-2.404l-1.262,-2.494l0.602,-0.657l1.071,0.84l0.876,-2.205l0.448,1.023l0,0l0.22,-0.006l0,0l4.002,-1.017l1.449,-2.896l0.689,-5.04l1.237,-1.293l0,0l0.232,-2.093l2.022,-0.488l1.295,1.668l0.619,-1.808l-0.262,-0.978l-1.05,-0.114l-0.469,-4.738l-1.644,-1.736l0.764,-0.783l-1.071,-0.114l0.465,-2.1l1.548,-1.618L288.703,104.908z" />
                                    <path id="REGION-PDL" class="<?php echo $regionClass; ?>" title="Pays de la Loire"
                                        d="M121.443,256.703l1.636,1.147l-0.594,2.051l3.114,1.57l0.303,3.315l-2.429,-3.848l-2.213,-0.091l-1.615,-1.929l0.403,-1.232l-0.685,-0.801L121.443,256.703zM170.697,165.558l2.719,1.181l1.295,-0.318l0.714,-1.431l1.943,1.287l2.641,-0.168l1.312,2.753l1.453,-0.63l0.785,1.829l1.922,-0.867l-0.697,-1.467l1.723,0.325l1.05,-1.062l0.502,2.572l2.242,-1.71l1.922,-0.1l1.715,-2.236l4.704,-0.063l1.81,1.605l1.328,-2.386l2.067,0.937l1.246,-1.812l-0.896,-0.775l0.573,-0.976l1.739,0.044l2.574,2.226l-1.175,1.087l1.121,3.354l3.99,0.356l-0.013,4.777l2.08,-1.421l0.635,1.029l1.814,0.199l0.552,-1.926l3.558,-2.046l-0.515,-0.999l1.216,0.424l-0.058,-0.905l5.335,-0.974l2.275,1.349l1.1,2.146l-0.511,0.817l0.917,5.607l3.62,1.45l0.424,-0.722l0.141,1.586l1.764,2.232l3.67,0.174l0.619,0.802l-0.303,-1.429l0.917,-0.485l1.258,0.578l2.246,4.125l0.934,0.484l1.544,-0.857l0,0l4.903,3.444l-2.694,0.341l-0.403,1.829l-1.158,0.267l1.325,0.291l-0.092,1.375l-2.046,0.149l0.149,2.068l1.864,0.458l-0.976,2.697l1.258,2.844l-1.391,0.488l-0.17,2.699l-0.889,-1.451l-1.204,0.691l0.332,4.227l-3.159,3.007l0.386,1.003l-3.109,0.93l-1.702,2.086l0.415,1.814l0.959,-0.295l-0.942,1.303l-5.488,1.653l-0.61,1.585l-1.034,0.172l-1.702,-1.677l-0.781,1.474l1.603,2.517l-0.805,0.515l-5.289,-2.565l-0.992,0.424l0,0l0.05,0.521l0,0l-1.652,3.521l1.333,0.723l-0.195,1.667l-2.853,6.163l1.221,1.088l-1.777,1.229l0.295,0.898l-2.877,3.98l0.079,3.902l-1.075,1.334l0.602,0.39l-0.552,1.534l0,0l-1.482,-0.669l-1.1,0.913l-1.382,2.817l0.17,1.666l-2.08,-0.863l-0.66,2.212l-1.125,0.62l-2.068,-0.978l1.516,-2.024l-1.719,-0.298l-0.847,0.857l-2.536,-0.699l-3.097,1.143l-2.337,-0.261l-0.457,1.489l-2.105,-0.134l-0.951,0.942l0.901,-1.713l-1.457,-0.115l-2.558,1.179l0.527,1.919l-2.292,2.161l-2.96,-0.382l-0.353,0.947l-1.482,0.224l-3.018,-1.298l-0.876,1.098l-1.44,-0.151l-0.382,1.213l-1.806,-0.285l0.793,1.109l0.556,-0.346l-0.61,0.982l1.258,0.036l-0.477,0.661l2.146,0.812l-0.959,2.187l2.309,2.717l0,0h0.174l0,0l1.648,1.107l0,0h0.295l0,0l1.092,0.707l-0.831,0.768l0,0l0.038,0.248l0,0l-0.096,2.248l2.645,3.333l-0.971,0.838l1.772,1.381l-0.896,1.634l1.777,0.88l-0.54,2.782l0.972,2.588l-1.814,0.716l1.627,3.937l-1.208,1.381l-0.153,2.065l0.868,0.378l0.614,-1.344l2.765,1.74l-0.813,1.523l-1.739,-0.018l-0.179,0.881l-1.395,0.42l-0.365,1.282l-2.088,-0.509l-1,1.396l-3.342,-1.354l0.116,-1.031l-1.154,0.264l0,0l-0.183,-0.258l0,0l-0.785,1.48l-1.515,-0.563l-1.855,0.995l-1.233,-0.743l1.312,-2.907l-1.864,1.169l-3.28,0.102l-0.884,1.954l-1.702,0.042l0,0l-3.558,0.102l-0.174,2.695l-4.554,-3.84l-1.146,-0.485l-5.165,-0.006l-1.939,-3.688l-5.583,-0.966l-5.372,-4.355l-1.461,-0.138L138.004,282l-3.782,-5.276l-0.751,0.242l-2.059,-3.242l-5.251,-4.515l-0.407,-4.085l1.719,-0.151l-0.366,-1.03l3.579,-3.63l-0.535,-0.503l0.739,-1.948l2.097,-1.208l-1.088,-1.992l-1.98,-1.987l-2.217,-0.729l-0.374,-0.03l-5.48,-1.582l1.333,-1.667l1.544,0.238l0.481,-0.737l-0.211,-5.831l-1.673,-0.36l-3.637,2.28l-3.163,-2.774l-1.735,0.098l-0.598,1.123l-4.695,-1.94l1.503,-1.123l0.125,-1.807l-2.233,-2.199l4.185,-3.015l0.017,-1.493l0,0l1.428,-1.769l0.901,1.267l3.5,-0.294l0.785,-3.381l1.632,0.135l0.594,1.195l2.486,-1.109l-0.17,1.084l1.063,0.318l0.262,-1.954l2.462,-0.693l-0.112,-3.76l0.797,-1.056l-0.689,-1.216l0.685,-1.148l1.229,0.067l0.498,-1.216l1.15,0.166l1.632,-1.715l0.755,1.377l3.936,-2.293l3.741,0.689l4.571,-0.744l1.573,-3.323l6.186,-2.427l-0.241,-1.991l3.761,0.444l1.03,1.788l4.836,1.392l1.038,-4.628l1.428,-0.993l-0.374,-1.401l0.818,-0.476l0.889,-4.12l1.22,-0.39l0.066,-0.946l3.081,0.136l1.382,-1.169l-0.697,-1.782l0.498,-2.285l-1.221,-1.357l-0.988,-6.836l0,0l-0.174,-0.155l0,0l-0.934,-3.909l2.325,-3.895l-1.49,-5.346L170.697,165.558z" />
                                    <path id="REGION-PAC" class="<?php echo $regionClass; ?>"
                                        title="Provence-Alpes-Côte d'Azur"
                                        d="M436.874,480.46l1.407,-2.374l-1.229,-1.426l1.154,-0.762l-0.402,-0.966l-0.432,0.847l-0.154,-1.479l0.071,-0.608l-1.769,-1.553l-3.347,1.86l-7.41,0.216l-1.328,-0.973l0.037,-1.536l-2.026,-3.199l-2.067,-0.388l-0.589,0.148l-1.001,0.587l-0.166,0.489l-2.047,-1.094l1.366,1.601l-1.134,-0.279l-0.443,0.513l1.236,0.456l-0.05,0.085l-0.672,0.677l1.776,1.145l1.599,-1.395l-2.342,2.936l-1,0.074l-2.566,-1.184l-7.995,-0.671l-1.005,-1.155l1.561,-1.314l-0.207,-1.043l-2.379,-1.715l-12.575,-0.455l0,0l0.44,-2.247l3.404,-1.653l0.423,-0.435l5.318,-3.077l0.432,-1.319l-1.901,-0.663l2.475,-4.186l2.267,-0.566l3.646,1.236l-0.632,-2.289l1.611,-3.225l-0.354,-2.798l1.014,-0.809l-1.071,-1.251l7.157,-5.542l-0.013,-1.442l1.267,-0.063l-2.408,-4.407l-2.735,-0.91l-0.64,-1.521l0.685,-4.584l-0.594,-1.553l-1.415,-0.069l-0.979,-3.176l0,0l0.05,-3.439l5.729,0.966l1.262,4.957l2.528,-1.929l1.757,0.058l5.716,-2.763l0.686,1.37l1.332,0.37l1.761,-1.85l0,0l0.664,-0.313l0,0l-0.606,4.796l3.218,1.201l0.806,-1.155l2.03,1.403l2.37,-0.416l1.233,0.809l-0.075,2.602l2.176,0.201l0.813,1.874l2.009,0.207l1.582,-0.974l1.715,-1.436l-0.764,-0.762l0.423,-0.911l1.125,-0.277l1.569,1.356l-0.349,0.997l1.964,0.236l0.17,-0.985l-1.636,-0.462l0.357,-1.032l1.437,-0.393l0.008,-4.088h-1.636l-0.436,-1.948l-1.191,-0.323l0.884,-1.579l-3.383,0.186l-1.101,-1.186l-1.166,0.758l-2.607,-2.147l0.531,-0.949l-1.001,-1.963l0.798,-0.47l1.598,0.806l0.872,-1.031l-1.395,-0.608l-0.271,-2.98l6.477,1.606l0.603,-1.658l1.469,-0.128l-2.777,-2.414l2.113,-3.938l-0.203,-2.319l3.574,0.744l0.843,-1.338l1.665,0.501l1.702,-2.153l-1.308,-0.931l1.166,-3.093l2.316,0.757l2.836,-0.815l1.212,-1.23l-1.278,-1.358l2.831,-1.796l1.611,1.143l3.217,-2.818l4.708,0.724l1.831,-1.284l1.855,1.506l0.813,-0.397l0.104,-4.936l-1.475,-0.848l0.046,-2.626l-3.001,0.135l-1.96,-1.153l0.644,-2.829l1.017,-0.363l-0.572,-1.834l0.622,-1.096l0.731,-0.352l1.278,1.079l1.632,-0.886l1.282,1.208l0.025,1.898l3.578,1.066l1.479,-0.182l-0.262,-2.221l1.249,-0.961l1.3,0.563l1.507,-1.413l2.188,0.868l0,0l1.756,5.301l2.939,0.328l-0.287,1.387l1.13,1.767l-0.872,1.251l0.307,1.963l4.675,3.217l1.943,0.373l1.05,-1.056l3.6,2.258l-0.938,2l3.164,6.156l-3.409,-0.459l-1.319,0.814l-0.577,1.402l0.793,1.948l-0.752,0.063l-0.714,2.574l-2.25,1.074l-0.946,1.515l0.938,2.802l2.919,2.916l-2.309,0.48l-0.224,3.422l1.474,0.677l1.395,3.164l1.582,0.919l0.502,2.564l7.494,1.985l3.807,3.49l2.636,-0.312l0.603,1.775l1.465,-0.564l1.329,0.749l0.253,-1.049l1.258,0.282l4.193,-1.775l2.354,0.386l0.76,-1.574l1.964,0.115l-0.73,2.515l1.996,2.725l-0.382,2.401l-1.772,0.788l-0.439,3.135l-3.542,1.856l-0.36,2.63l-2.545,1.338l1.444,5.184l-1.599,0.819l-0.224,1.134l-1.042,-0.658l-0.988,0.538l-1.304,1.815l-2.794,0.371l0.452,1.465l-0.688,0.618l-0.735,-1.739l-0.452,1.207l-0.813,-0.721l-1.769,0.504l-1.383,2.196l-0.345,-0.669l-1.818,0.531l-1.461,3.783l0.972,1.992l-0.997,0.577l-0.946,-1.661l-2.482,2.043l-0.935,-0.913l-2.212,0.514l-1.071,1.598l0.817,0.97l-2.715,3.876l-1.221,-0.297l-0.299,1.253l-2.711,0.194l-1.826,-0.814l-1.191,4.263l-1.479,0.388l-0.386,1.604l-4.015,2.313l3.711,0.421l0.569,-0.818l0.806,0.716l-1.325,1.347l0.656,2.457l-1.632,0.738l0.212,1.083l-1.079,0.545l-0.885,-1.44l-1.59,-0.329l-2.689,2.172l-4.646,0.368l-0.947,1.151l0.096,2.142l-3.732,-1.966l-3.615,0.346l-1.524,2.81l0.096,1.67l0.822,0.158l-0.71,0.356l-2.491,-0.119l-0.07,-0.64l1.49,-0.231l-0.212,-1.977l-4.28,0.063l-0.821,-1.569l-3.064,0.21l-0.203,-1.27l-1.387,0.335l-0.27,0.924l1.195,0.067l0.976,0.815l0.594,1.07l-2.35,-0.622l-1.324,1.828l-1.291,-0.181l-1.474,-1.07l0.635,-2.628l-1.731,-0.046l0.229,-1.292l-3.196,-0.272l-0.382,-2.053l-2.682,-0.38l-0.735,1.509l-2.844,-3.092l-1.523,0.998L436.874,480.46z" />
                                </g>
                            </svg>

                        </div>
                    </div>
                </div>

                <div class="right-map">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2" class="title-map-right">Manières possibles d'écrire le numéro
                                    <?php echo $unNumero->numero; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- ligne1 debut -->
                            <tr class="tabmap">
                                <td>
                                    <?php
                                    $numberChunks = str_split($unNumero->numero, 2);
                                    echo implode(' ', $numberChunks);
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo substr($unNumero->numero, 0, 4) . ' ';
                                    echo implode(' ', str_split(substr($unNumero->numero, 4), 2));
                                    ?>
                                </td>
                            </tr>
                            <!-- ligne1 fin-->

                            <!-- ligne2 debut-->
                            <tr class="tabmap">
                                <td>
                                    <?php
                                    $numeroSansPremierCaractere = substr($unNumero->numero, 1);
                                    $numeroAvecPrefixe = '0033' . $numeroSansPremierCaractere;
                                    echo $numeroAvecPrefixe;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $numeroSansPremierCaractere = substr($unNumero->numero, 1);
                                    $numeroAvecPrefixe = '+33' . $numeroSansPremierCaractere;
                                    echo substr($numeroAvecPrefixe, 0, 3) . ' ' . substr($numeroAvecPrefixe, 3, 3) . ' ' . implode(' ', str_split(substr($numeroAvecPrefixe, 6), 2));
                                    ?>
                                </td>
                            </tr>
                            <!-- ligne2 fin-->

                            <!-- ligne3 debut-->
                            <tr class="tabmap">
                                <td>
                                    <?php
                                    echo substr($unNumero->numero, 0, 4) . '.' . implode('.', str_split(substr($unNumero->numero, 4), 2));
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $numeroSansPremierCaractere = substr($unNumero->numero, 1);
                                    $numeroAvecPrefixe = '+33 ' . $numeroSansPremierCaractere;
                                    $numeroAvecEspaces = substr_replace($numeroAvecPrefixe, ' ', 4, 0);
                                    for ($i = 6; $i < strlen($numeroAvecEspaces); $i += 3) {
                                        $numeroAvecEspaces = substr_replace($numeroAvecEspaces, ' ', $i, 0);
                                    }

                                    echo $numeroAvecEspaces;
                                    ?>
                                </td>



                            </tr>
                            <!-- ligne3 fin-->

                            <!-- ligne4 debut-->
                            <tr class="tabmap">
                                <td>
                                    <?php
                                    $numeroSansPremierCaractere = substr($unNumero->numero, 1);
                                    echo '+33' . $numeroSansPremierCaractere;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $numeroSansPremierCaractere = '.' . substr($unNumero->numero, 1);
                                    $numeroFormate = preg_replace("/ /", ".", $numeroSansPremierCaractere);
                                    $numeroFormateAvecPrefixe = '00.33' . $numeroFormate;
                                    $numeroAvecPointApresNeuf = substr_replace($numeroFormateAvecPrefixe, '.', 9, 0);
                                    $numeroAvecDeuxPointsApresNeuf = substr_replace($numeroAvecPointApresNeuf, '.', 12, 0);
                                    $numeroAvecPointApresDeuxPoints = substr_replace($numeroAvecDeuxPointsApresNeuf, '.', 15, 0);
                                    echo $numeroAvecPointApresDeuxPoints;
                                    ?>
                                </td>
                            </tr>
                            <!-- ligne4 fin-->

                            <!-- ligne5 debut-->
                            <tr class="tabmap">
                                <td>
                                    <?php
                                    $numeroSansPremierCaractere = substr($unNumero->numero, 1);
                                    $numeroAvecPrefixe = '+33' . $numeroSansPremierCaractere;
                                    echo substr($numeroAvecPrefixe, 0, 3) . '.' . substr($numeroAvecPrefixe, 3, 3) . '.' . implode('.', str_split(substr($numeroAvecPrefixe, 6), 2));
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    $numeroAvecPointApresPremier = ' ' . substr($unNumero->numero, 1);
                                    $numeroAvecDeuxPointsApresPremier = substr_replace($numeroAvecPointApresPremier, ' ', 2, 0);
                                    $numeroAvecPointApresDeuxPoints = substr_replace($numeroAvecDeuxPointsApresPremier, ' ', 5, 0);
                                    $numeroAvecPointApresTroisPoints = substr_replace($numeroAvecPointApresDeuxPoints, ' ', 8, 0);
                                    $numeroAvecPointApresQuatrePoints = substr_replace($numeroAvecPointApresTroisPoints, ' ', 11, 0);
                                    $numeroFormate = preg_replace("/ /", " ", $numeroAvecPointApresQuatrePoints);
                                    $numeroFormateAvecPrefixe = '0033' . $numeroFormate;
                                    echo $numeroFormateAvecPrefixe;
                                    ?>
                                </td>




                            </tr>
                            <!-- ligne5 fin-->

                            <!-- ligne6 debut-->
                            <tr>
                                <td>
                                    <?php
                                    $numeroSansPremierCaractere = ' ' . substr($unNumero->numero, 1);
                                    $numeroFormate = preg_replace("/ /", " ", $numeroSansPremierCaractere);
                                    $numeroFormateAvecPrefixe = '0033' . $numeroFormate;
                                    $numeroAvecPointApresNeuf = substr_replace($numeroFormateAvecPrefixe, ' ', 8, 0);
                                    $numeroAvecDeuxPointsApresNeuf = substr_replace($numeroAvecPointApresNeuf, ' ', 11, 0);
                                    $numeroAvecPointApresDeuxPoints = substr_replace($numeroAvecDeuxPointsApresNeuf, ' ', 14, 0);
                                    echo $numeroAvecPointApresDeuxPoints;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $numeroSansPremierCaractere = '.' . substr($unNumero->numero, 1);
                                    $numeroFormate = preg_replace("/ /", ".", $numeroSansPremierCaractere);
                                    $numeroFormateAvecPrefixe = '0033' . $numeroFormate;
                                    $numeroAvecPointApresNeuf = substr_replace($numeroFormateAvecPrefixe, '.', 8, 0);
                                    $numeroAvecDeuxPointsApresNeuf = substr_replace($numeroAvecPointApresNeuf, '.', 11, 0);
                                    $numeroAvecPointApresDeuxPoints = substr_replace($numeroAvecDeuxPointsApresNeuf, '.', 14, 0);
                                    echo $numeroAvecPointApresDeuxPoints;
                                    ?>
                                </td>
                            </tr>
                            <!-- ligne6 fin-->

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- LOCALISATION NUMERO FIN -->


            <!-- FAQ DEBUT -->
            <div class="faq-container">
                <?php foreach ($randomFaqs as $faq): ?>
                    <div class="faq">
                        <div class="faq-item">
                            <div class="faq-question">
                                <?php
                                $questionAvecNumero = str_replace('[numero]', $unNumero->numero, $faq->question);
                                ?>
                                <span class="faq-text">
                                    <?php echo $questionAvecNumero; ?>
                                </span>
                                <span class="faq-icon"><i class="fas fa-chevron-down"></i></span>
                            </div>
                            <div class="faq-answer">
                                <?php
                                $reponseAvecNumero = str_replace('[numero]', $unNumero->numero, $faq->reponse);
                                ?>
                                <p>
                                    <?php echo $reponseAvecNumero; ?>
                                </p>
                                <div class="bottom-faq">
                                    <a class="redirect"
                                        href="<?php echo base_url('questions-frequemment-posees'); ?>">Questions
                                        fréquemment posées</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- FAQ FIN -->




        </div>



        <!-- SIDEBAR DEBUT -->
        <div class="sidebar">
            <div class="top-sidebar">
                <h4 class="h4-sidebar top-h2">Derniers numéro ajoutées</h4>
                <div class="com-random">
                    <?php foreach ($randomNumbers as $randomNumber): ?>
                        <a class="num-sidebartop" href="<?= base_url("numero/{$randomNumber}"); ?>">

                            <?php echo $randomNumber; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="middle-sidebar">
                <h4 class="h4-sidebar mid-h2">Les derniers commentaires</h4>

                <?php foreach ($derniersCommentairesGeneraux as $commentaire): ?>
                    <div class="commentaire">
                        <a class="num-sidebar" href="<?php echo base_url("/numero/{$commentaire->numero}"); ?>">

                            <?php echo $commentaire->numero; ?>
                        </a>

                        <?php
                        $commentaireTexte = strlen($commentaire->commentaire) > 130
                            ? substr($commentaire->commentaire, 0, 130) . ' ...'
                            : $commentaire->commentaire;
                        ?>
                        <p class="com-sidebar">
                            <?php echo $commentaireTexte; ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>

            <h3 class="h3-sidebar-bottom">Statistique des heures d'appels</h3>
            <div class="bottom-sidebar style=">
                <canvas id="hourlyViewsChart" style="height: 300px;"></canvas>
            </div>
            <script>
                let hourlyViewsData = <?php echo json_encode($viewModel->getViewsParTrancheHeureAujourdhui($unNumero->numero)); ?>;
                let trancheHours = Object.keys(hourlyViewsData);
                let views = Object.values(hourlyViewsData);
                let ctx = document.getElementById('hourlyViewsChart').getContext('2d');

                // Créez le graphique à barres avec des bordures arrondies
                let hourlyViewsChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: trancheHours,
                        datasets: [{
                            label: 'Nombre de vues',
                            data: views,
                            backgroundColor: 'rgba(80, 37, 209, 0.5)',
                            borderColor: 'rgba(80, 37, 209, 0.5)',
                            borderWidth: 1,
                            borderRadius: 10
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        let heureDebut = trancheHours[context.dataIndex];
                                        let heureFinIndex = context.dataIndex + 1;
                                        let heureFin = (heureFinIndex < 10) ? '0' + heureFinIndex + ':00' : heureFinIndex + ':00';

                                        // Affichez la plage horaire en plus du pourcentage
                                        return `${context.parsed.y}%`;
                                    }
                                }
                            }
                        }
                    }
                });

            </script>



        </div>

        <!-- SIDEBAR FIN -->

    </section>

</body>

</html>