<!-- Extends -->
<?= $this->extend('bootstrap_view'); ?>

<!-- Section -->
<?= $this->section('bootstrap'); ?>
<nav class="sidebar close">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="https://upload.wikimedia.org/wikipedia/id/thumb/3/3e/Logo_Politeknik_Negeri_Bandung.svg/1200px-Logo_Politeknik_Negeri_Bandung.svg.png" alt="logo">
            </span>

            <class class="text header-text">
                <span class="profession"> Toko Online </span>
                <span class="name"> Madya Pilot </span>
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
                <a href="/barang/create">
                    <i class='bx bxs-package icon'></i>
                    <span class="text nav-text">Create</span>
                </a>
            </li>
        </div>

        <div class="bottom-content">
            <!-- <li class="">
                <a href="{{ Route('petugas_peralatan.logout') }}">
                    <i class='bx bx-log-out icon'></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li> -->

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
        <?= $this->renderSection('content') ?>
    </div>
</div>

<style scoped>
    * {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        /* ===== Colors ===== */
        --body-color: #E4E9F7;
        --sidebar-color: #FFF;
        --primary-color: #695CFE;
        --primary-color-light: #F6F5FF;
        --toggle-color: #DDD;
        --text-color: #707070;
        /* ===== Transition ===== */
        --tran-02: all 0.2s ease;
        --tran-03: all 0.3s ease;
        --tran-04: all 0.4s ease;
        --tran-05: all 0.5s ease;
    }

    body {
        background: var(--body-color);
        transition: var(--tran-04);
    }

    body.dark {
        --body-color: #18191A;
        --sidebar-color: #242526;
        --primary-color: #3A3B3C;
        --primary-color-light: #3A3B3C;
        --toggle-color: #FFF;
        --text-color: #CCC;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 250px;
        padding: 10px 14px;
        background: var(--sidebar-color);
        transition: var(--tran-05);
        z-index: 1;
    }

    .sidebar.close {
        width: 88px;
    }

    .sidebar .text {
        font-size: 16px;
        font-weight: 500;
        color: var(--text-color);
        transition: var(--tran-03);
        white-space: nowrap;
        opacity: 1;
    }

    .sidebar.close .text {
        opacity: 0;
    }

    .sidebar .image {
        min-width: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sidebar li {
        height: 50px;
        margin-top: 10px;
        list-style: none;
        display: flex;
        align-items: center;
    }

    .sidebar li .icon {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 60px;
        font-size: 20px;
    }

    .sidebar li .icon,
    .sidebar li .text {
        color: var(--text-color);
        transition: var(--tran-02);
    }

    .sidebar .menu-bar .top-content {
        margin-top: 30px;
    }

    .sidebar header {
        position: relative;
    }

    .sidebar .image-text img {
        width: 40px;
    }

    .sidebar header .image-text {
        display: flex;
        align-items: center;
    }

    header .image-text .header-text {
        display: flex;
        flex-direction: column;
    }

    .header-text .name {
        font-size: 10px;
        font-weight: 500;
        text-align: center;
        margin-top: -2px;
    }

    .header-text .profession {
        font-weight: 500;
    }

    .sidebar header .toggle {
        position: absolute;
        top: 50%;
        right: -25px;
        transform: translateY(-50%) rotate(180deg);
        height: 25px;
        width: 25px;
        background: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: var(--sidebar-color);
        font-size: 22px;
        transition: var(--tran-03);
    }

    .sidebar.close header .toggle {
        transform: translateY(-50%);
    }

    body.dark .sidebar header .toggle {
        color: var(--text-color);
    }

    .sidebar .menu {
        margin-top: 35px;
    }

    .sidebar li a {
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        text-decoration: none;
        border-radius: 6px;
        transition: var(--tran-04);
    }

    .sidebar li a:hover {
        background: var(--primary-color);
    }

    .sidebar li a:hover .icon,
    .sidebar li a:hover .text {
        color: var(--sidebar-color);
    }

    body.dark .sidebar li a:hover .icon,
    body.dark .sidebar li a:hover .text {
        color: var(--text-color);
    }

    .sidebar .menu-bar {
        height: calc(100% - 70px);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .menu-bar .mode {
        position: relative;
        border-radius: 6px;
        background: var(--primary-color-light);
    }

    .menu-bar .mode .moon-sun {
        height: 50px;
        width: 60px;
        display: flex;
        align-items: center;
    }

    .menu-bar .mode i {
        position: absolute;
        transition: var(--tran-03);
    }

    .menu-bar .mode i.sun {
        opacity: 0;
    }

    body.dark .menu-bar .mode i.sun {
        opacity: 1;
    }

    body.dark .menu-bar .mode i.moon {
        opacity: 0;
    }

    .menu-bar .mode .toggle-switch {
        position: absolute;
        right: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        min-width: 60px;
        cursor: pointer;
        border-radius: 6px;
        background: var(--primary-color-light);
    }

    .toggle-switch .switch {
        position: relative;
        height: 22px;
        width: 44px;
        border-radius: 25px;
        background: var(--toggle-color);
    }

    .switch::before {
        content: "";
        position: absolute;
        height: 15px;
        width: 15px;
        border-radius: 50%;
        top: 50%;
        left: 5px;
        transform: translateY(-50%);
        background: var(--sidebar-color);
        transition: var(--tran-03);
    }

    body.dark .switch::before {
        left: 24px;
    }

    .home {
        position: relative;
        height: 100vh;
        left: 250px;
        width: calc(100% - 250px);
        background: var(--body-color);
        transition: var(--tran-05);
    }

    .home .text {
        background: var(--body-color);
        color: var(--text-color);
        padding: 8px 40px;
        transition: var(--tran-05);
    }

    .sidebar.close~.home {
        left: 88px;
        width: calc(100% - 88px);
    }
</style>

<script>
    const body = document.querySelector("body");
    const sidebar = document.querySelector(".sidebar");
    const toggle = document.querySelector(".toggle");
    const modeSwitch = document.querySelector(".toggle-switch");
    const modeText = document.querySelector(".mode-text");
    const modeMoonSun = document.querySelector(".moon-sun");
    modeSwitch.addEventListener("click", () => {
        body.classList.toggle("dark");
        if (body.classList.contains("dark")) {
            modeText.textContent = "Dark Mode";
            localStorage.setItem("theme", "dark");
        } else {
            modeText.textContent = "Light Mode";
            localStorage.setItem("theme", "light");
        }
    });
    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("close");
        if (sidebar.classList.contains("close")) {
            // local storage
            localStorage.setItem("sidebar", "close");
        } else {
            // local storage
            localStorage.setItem("sidebar", "open");
        }
    });
    localStorage.getItem("theme") === "dark" ? body.classList.add("dark") : body.classList.remove("dark");
    localStorage.getItem("sidebar") === "close" ? sidebar.classList.add("close") : sidebar.classList.remove("close");
</script>
<?= $this->endSection(); ?>