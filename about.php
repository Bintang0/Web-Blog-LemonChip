<?php require 'functions.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHIP BLOG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .carousel-item img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .navbar {
            background-color: #343a40;
        }

        .about-section {
            background-color: rgb(255, 255, 255);
            padding: 100px 20px;
            /* Padding atas dan bawah lebih besar */
            margin-top: 104px;
        }

        .about-text {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 20px;
            /* Menambahkan jarak bawah untuk teks */
        }

        .about-section h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            /* Jarak bawah untuk heading */
        }

        .about-image img {
            max-width: 100%;
            border-radius: 8px;
            margin-top: -90px;
            /* Memberikan sedikit jarak antara gambar dan teks */
        }

        @media (max-width: 767px) {
            .about-section {
                padding: 60px 20px;
                /* Padding sedikit lebih kecil pada perangkat mobile */
            }

            .about-text {
                font-size: 1rem;
            }

            .about-image img {
                margin-top: 20px;
            }
        }
    </style>
</head>

<body>
    <?php require('views/partials/header.php') ?>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="row">
                <!-- Text Section -->
                <div class="col-sm-12 col-md-6">
                    <h2>Tentang Kami</h2>
                    <p class="about-text">Kami menyediakan sumber daya yang berguna melalui artikel dan tutorial,
                        mendorong pembaca untuk berinovasi, menghadirkan konten terupdate dan relevan, serta menciptakan
                        platform digital yang aktif untuk berbagi pengetahuan dan pengalaman.</p>
                    <p class="about-text">Visi kami adalah menyajikan konten berkualitas yang mudah dipahami,
                        memberdayakan pembaca dengan informasi praktis yang dapat langsung diterapkan, serta membangun
                        komunitas yang saling mendukung dalam dunia digital.</p>
                    <a href="blog.php" class="btn btn-primary d-inline-flex align-items-center px-3 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            viewBox="0 0 576 512" class="me-2">
                            <path
                                d="M249.6 471.5c10.8 3.8 22.4-4.1 22.4-15.5l0-377.4c0-4.2-1.6-8.4-5-11C247.4 52 202.4 32 144 32C93.5 32 46.3 45.3 18.1 56.1C6.8 60.5 0 71.7 0 83.8L0 454.1c0 11.9 12.8 20.2 24.1 16.5C55.6 460.1 105.5 448 144 448c33.9 0 79 14 105.6 23.5zm76.8 0C353 462 398.1 448 432 448c38.5 0 88.4 12.1 119.9 22.6c11.3 3.8 24.1-4.6 24.1-16.5l0-370.3c0-12.1-6.8-23.3-18.1-27.6C529.7 45.3 482.5 32 432 32c-58.4 0-103.4 20-123 35.6c-3.3 2.6-5 6.8-5 11L304 456c0 11.4 11.7 19.3 22.4 15.5z" />
                        </svg>
                        <span>Baca</span>
                    </a>
                </div>
                <!-- Image Section -->
                <div class="col-sm-12 col-md-6 about-image">
                    <img src="img/LogoLemonChip.png" alt="About Image" class="img-fluid">
                </div>
            </div>
        </div>
    </section>


    <!-- Link ke JS Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php require('views/partials/footer.php') ?>
</body>

</html>