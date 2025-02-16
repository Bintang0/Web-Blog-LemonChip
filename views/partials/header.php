<?php
// Fungsi logout
if (isset($_GET['logout'])) {
    // Hapus semua session
    session_unset();

    // Hancurkan session
    session_destroy();

    // Redirect ke halaman login atau halaman utama
    header("Location: index.php");
    exit();
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHIP BLOG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .carousel-item img {
            width: 1000px;
            height: 500px;
            aspect-ratio: 16 / 9;
            /* Rasio aspek 16:9 */
            object-fit: cover;
        }

        .carousel {
            max-width: 100%;
            overflow: hidden;
        }

        .navbar {
            background-color: #343a40;
        }

        .container {
            flex: 1;
            /* Menyusun container agar mengambil ruang yang tersisa */
        }



        h1 .judul-utama {
            margin: 20px auto;
            padding-bottom: 8px;
            width: 90%;
            text-align: left;
            font-size: 28px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            color: #333;
            border-bottom: 2px solid #000000;
        }

        /* Wrapper utama agar footer tetap di bawah */
        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Bagian utama agar konten fleksibel */
        .content-main {
            flex-grow: 1;
        }

        /* Pagination tetap di atas footer */
        .pagination-container {
            display: flex;
            justify-content: right;
            margin-top: 250px;
            margin-bottom: 30px;
            padding-right: 40px;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('img/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            height: 500px;
            color: white;
        }

        .article-card {
            transition: transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .datetime-display {
            font-family: 'Courier New', monospace;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
        }

        .user-welcome {
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .category-badge {
            font-size: 0.8rem;
            padding: 5px 10px;
            margin-right: 5px;
            background-color: #007bff;
            color: white;
            border-radius: 15px;
        }

        /* bagian footer */
        @font-face {
            font-family: 'JamGrotesque';
            src: url('fonts/JamGrotesque-Regular.woff2') format('woff2'),
                url('fonts/JamGrotesque-Regular.woff') format('woff'),
                url('fonts/JamGrotesque-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        .bungkus-footer {
            background-color: #E2DFD2;
            padding: 40px 20px;
            color: black;
            font-family: 'JamGrotesque', sans-serif;
        }

        .footer-title {
            font-weight: bold;
            color: black;
            margin-bottom: 10px;
        }

        .footer-menu a {
            text-decoration: none;
            color: black;
            display: block;
            margin: 5px 0;
        }

        .footer-menu a:hover {
            color: blue;
        }

        .newsletter input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .newsletter button {
            background-color: black;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            font-weight: bold;
        }

        .newsletter button:hover {
            background-color: black;
        }

        .footer-bottom {
            text-align: center;
            border-top: 1px solid #ddd;
            font-size: 14px;
            color: #555;
            background-color: #E2DFD2;
        }

        .footer-bottom a {
            text-decoration: none;
            color: #555;
            margin: 0 10px;
        }

        .footer-bottom a:hover {
            color: blue;
        }

        /* bagian footer end */
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg" style="background-color: #E2DFD2	;">
        <div class="container-fluid">
            <a href="index.php">
                <img src="img/LogoLemonChip.png" alt="Logo LemonChip" width="65">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php"
                            style="color: #000000;">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php" style="color: #000000;">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php" style="color: #000000;">Tentang</a>
                    </li>
                </ul>
                <!-- Tombol Login -->
                <div class="dropdown">
                    <!-- Dropdown trigger button atau link untuk login -->
                    <?php if (isset($_SESSION['login']) && $_SESSION['login'] == true): ?>
                        <!-- Dropdown menu jika sudah login -->
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"
                            style="border: none; background: transparent;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                style="width: 24px; height: 24px; fill: #000000;">
                                <path
                                    d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z" />
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="ArtikelSaya.php">Artikel Saya</a></li>
                            <li><a class="dropdown-item" href="logout.php?logout=true">Logout</a></li>
                        </ul>
                    <?php else: ?>
                        <!-- Link login jika belum login -->
                        <a href="login.php" class="btn btn-outline-primary" style="border: none; background: transparent;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                style="width: 24px; height: 24px; fill: #000000;">
                                <path
                                    d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z" />
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>

    </nav>