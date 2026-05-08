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
                    href="<?=HTML_SHOP?>home.php"
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
                    href="<?=HTML_ACCOUNT?>account.php"
                    class="btn btn-secondary">
                    <img
                        class="naviImg"
                        src="<?=IMG_URL?>account.svg"
                        alt="Konto"
                    >
                </a>

                <a
                    href="<?=HTML_CART?>cart.php"
                    class="btn btn-secondary">
                    <img
                        class="naviImg"
                        src="<?=IMG_URL?>cart.svg"
                        alt="Koszyk"
                    >
                </a>

                <?php if($site === "shop")
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
                    href='" . HTML_SHOP . "shop.php'
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