<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
</head>

<body>

    <div class="container-page">
        <div class="container-bloc">



            <!-- FAQ DEBUT -->
            <div class="faq-homepage">
                <div class="blochome-title">
                    <h2 class="titlefaq">
                        Questions fréquemment posées </h2>
                </div>
                <div class="faq-home">
                    <div class="faq-container faq-home">
                        <?php foreach ($randomFaqs as $faq): ?>
                            <div class="faq">
                                <div class="faq-item">
                                    <div class="faq-question">
                                        <span class="faq-text">
                                            <?php echo $faq->question; ?>
                                        </span>
                                        <span class="faq-icon"><i class="fas fa-chevron-down"></i></span>
                                    </div>
                                    <div class="faq-answer">
                                        <p>
                                            <?php echo $faq->reponse; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- FAQ FIN -->


        </div>
    </div>

</body>

</html>