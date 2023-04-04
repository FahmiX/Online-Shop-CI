<!-- Extends -->
<?= $this->extend('bootstrap_view'); ?>

<!-- Section -->
<?= $this->section('bootstrap'); ?>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/styles/navbar.css">

<nav class="sidebar close">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="https://seeklogo.com/images/F/fresh-supermarket-logo-640D95FBEE-seeklogo.com.png" alt="logo">
            </span>

            <div class="text header-text">
                <span class="profession"> Supermarket </span>
                <span class="name"> MadPilot </span>
            </div>
        </div>

        <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
        <div class="top-content">
            <li class="">
                <a href="/">
                    <i class='bx bx-home icon'></i>
                    <span class="text nav-text">Home</span>
                </a>
            </li>

            <li class="">
                <a href="/keranjang">
                    <i class='bx bx-home icon'></i>
                    <span class="text nav-text">Keranjang</span>
                </a>
            </li>

            <li class="">
                <a href="/barang/create">
                    <i class='bx bxs-package icon'></i>
                    <span class="text nav-text">Create</span>
                </a>
            </li>
        </div>

        <div class="bottom-content">
            <li class="mode">
                <div class="moon-sun">
                    <i class='bx bx-moon icon moon'></i>
                    <i class='bx bx-sun icon sun'></i>
                </div>
                <span class="mode-text text">Dark Mode</span>

                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li>
        </div>
    </div>
</nav>

<div class="home">
    <div class="text">
        <script src="/scripts/navbar.js"></script>
        
        <?= $this->renderSection('content') ?>
    </div>
</div>

<?= $this->endSection(); ?>