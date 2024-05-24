<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
</head>

<body>
    <section id="contact" class="contact">
        <div class="contact-box contact-box-sizing">
            <div class="contact-links">
                <h2 class="contacth2">CONTACT</h2>
                <div class="links">
                    <div class="link">
                        <a><i class="fa-brands fa-facebook"></i></a>
                    </div>
                    <div class="link">
                        <a><i class="fa-brands fa-twitter"></i></a>
                    </div>
                    <div class="link">
                        <a><i class="fa-brands fa-instagram"></i></a>
                    </div>
                    <div class="link">
                        <a><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="contact-form-wrapper">
                <form>
                    <h3 class="contact-title">Nous Contacter</h3>
                    <div class="form-item">
                        <input type="text" name="sender" placeholder="Nom" required>
                    </div>
                    <div class="form-item">
                        <input type="text" name="email" placeholder="Email" required>

                    </div>
                    <div class="form-item">
                        <textarea class="" name="message" placeholder="Message" required></textarea>

                    </div>
                    <button class="submit-btn">Envoyer</button>
                </form>
            </div>
        </div>
    </section>

    <style>
        * {
            box-sizing: border-box;
        }


        .contact {
            display: flex;
            box-sizing: border-box;
            margin: 0;
            margin: 80px 0px;
        }

        .contact #contact {
            background-color: #f8f8f9;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .contact .contact-box {
            width: clamp(100px, 90%, 1000px);
            display: flex;
            flex-wrap: wrap;
            margin: auto;
        }

        .contact-links,
        .contact-form-wrapper {
            width: 50%;
            padding: 8% 5% 10% 5%;

        }


        .contact .contact-links {
            background-color: #673de6;
            border-radius: 10px 0 0 10px;
        }

        .contact .contact-form-wrapper {
            background-color: #ecedfa;
            border-radius: 0 10px 10px 0;
        }

        @media only screen and (max-width: 800px) {


            .contact .contact-links,
            .contact .contact-form-wrapper {
                width: 100%;
            }

            .contact .contact-links {
                border-radius: 10px 10px 0 0;
            }

            .contact-form-wrapper {
                border-radius: 0 0 10px 10px;
            }
        }

        @media only screen and (max-width: 400px) {
            .contact-box {
                width: 95%;
                margin: 8% 5%;

            }
        }

        .contact h2 {
            color: #fff;
            font-size: clamp(30px, 6vw, 60px);
            letter-spacing: 2px;
            text-align: center;
            transform: scale(.95, 1);
        }

        .contact .links {
            gap: 5spx;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .contact .link {
            margin: 10px;
            cursor: pointer;
        }

        .contact i {
            font-size: 25px;
            transition: 0.2s;
            user-select: none;
        }

        .contact i:hover {
            transform: scale(1.1, 1.1);
            color: #ecedfa;
        }

        .contact i {
            color: #ecedfa;
        }

        .contact .form-item {
            position: relative;
        }

        .contacth2 {
            padding-bottom: 10px;
        }

        .contact-title {
            font-size: 25px;
            padding-bottom: 20px;
            color: #111010;
        }

        .contact label,
        .contact input,
        .contact textarea {
            font-family: 'Roboto';
        }

        .contact label {
            position: absolute;
            top: 10px;
            left: 2%;
            color: #999;
            font-size: clamp(14px, 1.5vw, 18px);
            pointer-events: none;
            user-select: none;
        }

        .contact input,
        .contact textarea {
            width: 100%;
            border-radius: 7px;
            outline: none;
            margin-bottom: 20px;
            padding: 12px;
            font-size: clamp(15px, 1.5vw, 18px);
            border: 2px solid rgba(216, 216, 216, 0.4);
            box-sizing: border-box;
            line-height: 1.5;
            font-size: 16px;
        }


        .contact .submit-btn {
            background-color: #fc5185;
            filter: drop-shadow(2px 2px 3px #0003);
            color: #fff;
            font-size: clamp(16px, 1.6vw, 18px);
            display: block;
            padding: 12px 58px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            user-select: none;
            transition: 0.2s;
        }

        .contact .submit-btn:hover {
            background-color: #d63163;
        }


        @media only screen and (max-width: 800px) {
            .contact h2 {
                font-size: clamp(40px, 10vw, 50px);
            }

            .contact {
                margin: 36px 25px;
            }
        }

        @media only screen and (max-width: 400px) {
            .contact h2 {
                font-size: clamp(20px, 10vw, 50px);
            }



            .contact img {
                width: 38px;
                height: 38px;
            }

            .contact {
                margin: 36px 14px;
            }
        }
    </style>

</body>

</html>