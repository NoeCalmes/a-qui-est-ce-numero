<div class="header">

    <img class="img-mobile" src="<?= base_url('public/img/search-img.svg') ?>" alt="">


    <a href="<?= base_url() ?>">
        <div class="img-logo">
            <img class="search-img img-one" src="<?= base_url('public/img/search-img.svg') ?>" alt="">
        </div>
    </a>
    <div class="search">
        <form class="form-search" action="<?= base_url('PageNumero/recherche') ?>" method="post"
            onsubmit="removeSpaces()">
            <input type="tel" id="numero-search" class="search-bar" placeholder="06 45 67 89 01" name="numero" required>
            <button class="submit-nav" type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="28" width="28"
                    viewBox="0 0 512 512">
                    <path
                        d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                </svg></button>
        </form>
    </div>

    <script>
        function removeSpaces() {
            var numeroSearch = document.getElementById('numero-search');
            numeroSearch.value = numeroSearch.value.replace(/\s/g, '');
        }
    </script>



    <img class="search-img img-two" src="<?= base_url('public/img/text-logo.svg') ?>" alt="">
</div>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Récupérer la valeur de showPopup depuis la session
        const showPopup = <?= session()->getFlashdata('showPopup') ? 'true' : 'false' ?>;

        // Afficher la popup si le paramètre showPopup est true
        if (showPopup) {

            Swal.fire({
                title: 'Numéro inconnu pour l\'instant',
                text: 'Ce numero n\'est pas encore référencé.',
                position: 'top',
                customClass: {
                    popup: 'custom-popup-class',
                    title: 'custom-title-class',
                    content: 'custom-content-class' // Ajouter une classe personnalisée au contenu
                },
                background: '#DF4775',
                showConfirmButton: false,
                timer: 3000
            });
        }
    });



</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>