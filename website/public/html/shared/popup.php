<header
    class="container-fluid sticky-top p-3"
>
    <div
        class="top row align-items-center"
    >
        <!-- School logo – hidden on mobile, links to school website -->
        <div
            class="col-sm-3 col-9 mb-2 d-sm-flex d-none justify-content-sm-end justify-content-start"
        >
            <a 
                href="https://www.zs4.oswiata.tychy.pl/"
                class="d-inline-block shadow-none"
            >
                <img 
                    src="<?=PUBLIC_URL?>img/logo.svg"
                    class="img-fluid img-logo" alt="logo"
                >
            </a>
        </div>

        <!-- App logo – hidden below lg, links to shop -->
        <div
            class="col-lg-5 col-0 mb-2 d-lg-flex d-none justify-content-md-start"
        >
            <a 
                href="<?=PUBLIC_URL?>html/shop/shop.php"
                class="d-inline-block shadow-none"
            >
                <img 
                    src="<?=PUBLIC_URL?>img/zegowska-szama.svg"
                    class="img-fluid img-logo" alt="zegowska-szama"
                >
            </a>
        </div>

        <div
            class="nav col-lg-4 col-sm-9 col-12 d-flex justify-content-sm-end justify-content-center gap-2"
        >

            <!-- Show admin panel button when inside the admin folder, otherwise show account link -->
            <?php if (isset($folder) && $folder === "admin"): ?>

            
                href="<?=PUBLIC_URL?>html/admin/admin.php"
                class="btn btn-secondary"
            >
                <img
                    class="naviImg"
                    src="<?=PUBLIC_URL?>img/panel.svg"
                    alt="admin panel"
                >
            </a>

            <?php else: ?>

            
                href="<?=PUBLIC_URL?>html/account/account.php"
                class="btn btn-secondary"
            >
                <img
                    class="naviImg"
                    src="<?=PUBLIC_URL?>img/account.svg"
                    alt="Konto"
                >
            </a>

            <?php endif; ?>

            <!-- Cart link – always visible -->
            
                href="<?=PUBLIC_URL?>html/cart/cart.php"
                class="btn btn-secondary"
            >
                <img
                    class="naviImg"
                    src="<?=PUBLIC_URL?>img/cart.svg"
                    alt="Koszyk"
                >
            </a>

            <!-- Show filter toggle button on shop page and all admin pages, otherwise show home link -->
            <?php if ($site === "shop.php" || (isset($folder) && $folder === "admin")): ?>

            <button
                type="button"
                id="filterBtn"
                class="btn btn-secondary"
            >
                <img
                    class="naviImg"
                    src="<?=PUBLIC_URL?>img/menu.svg"
                    alt="Filtry"
                >
            </button>

            <?php else: ?>

            
                href="<?=PUBLIC_URL?>html/shop/shop.php"
                class="btn btn-secondary"
            >
                <img
                    class="naviImg"
                    src="<?=PUBLIC_URL?>img/home.svg"
                    alt="Sklep"
                >
            </a>

            <?php endif; ?>
            
        </div>
    </div>
</header>