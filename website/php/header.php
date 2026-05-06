<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?=CSS_URL?>main.css">

<header class="container-fluid sticky-top p-3">
        <div class="top row align-items-center">

            <!-- LOGO -->
            <div class="col-sm-3 col-9 mb-2 d-flex justify-content-sm-end justify-content-start">
                <a 
                    href="https://www.zs4.oswiata.tychy.pl/"
                    class="d-inline-block shadow-none">
                        <img 
                            src="<?=IMG_URL?>logo.svg"
                            class="img-fluid img-logo" alt="logo"
                        >
                </a>
            </div>

            <div class="col-lg-5 col-0 mb-2 d-lg-flex d-none justify-content-md-start">
                <a 
                    href="<?=HOME_F_URL?>home.php"
                    class="d-inline-block shadow-none">
                        <img 
                            src="<?=IMG_URL?>zegowska-szama.svg"
                            class="img-fluid img-logo" alt="zegowska-szama"
                        >
                </a>
            </div>

            <!-- NAV -->
            <div class="nav col-lg-4 col-sm-9 col-3 d-flex justify-content-end gap-2">
                <a
                    href="<?=ACCOUNT_F_URL?>account.php"
                    class="btn btn-secondary">
                    <img
                        class="naviImg"
                        src="<?=IMG_URL?>.svg"
                        alt="Konto"
                    >
                </a>

                <a
                    href="<?=CART_F_URL?>cart.php"
                    class="btn btn-secondary">
                    <img
                        class="naviImg"
                        src="<?=IMG_URL?>.svg"
                        alt="Koszyk"
                    >
                </a>

                <?php if($_SESSION["site"] === "home")
                {
                echo 
                "<button
                    type='button'
                    id='filterBtn'
                    class='btn btn-secondary'
                >
                    <img
                        class='naviImg'
                        src='" . IMG_URL . "menu.svg'
                        alt='Filtry'
                    >
                </button>";
                }
                else
                {
                echo 
                "<a
                    href='" . HOME_F_URL . "home.php'
                    class='btn btn-secondary'
                >
                    <img
                        class='naviImg'
                        src='" . IMG_URL . "home.svg'
                        alt='Sklep'
                    >
                </a>";
                }
                ?>
            </div>

        </div>
    </header>