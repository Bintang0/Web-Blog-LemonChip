<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CHIP BLOG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .carousel-item img {
            width: 1000px;
            height: 500px;
            aspect-ratio: 16 / 9; /* Rasio aspek 16:9 */
            object-fit: cover;
        }

        .navbar {
            background-color: #343a40;
        }

    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg" style="background-color: #343a40;">
  <div class="container-fluid">
    <!-- <a class= "navbar-brand" href="" style="color: #ffffff;"></a> -->
    <img src="img/LogoLemonChip.png" alt="" width="65">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#" style="color: #f8f9fa;">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" style="color: #f8f9fa;">Blog</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="" style="color: #f8f9fa;">About</a>
        </li>
      </ul>
      <!-- Tombol Pencarian -->
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <!-- Tombol Login -->
      <div class="dropdown">
  <!-- Dropdown trigger button -->
  <button class="btn btn-outline-primary dropdown-toggle" 
          type="button" 
          id="userDropdown" 
          data-bs-toggle="dropdown" 
          aria-expanded="false"
          style="border: none; background: transparent;">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 24px; height: 24px; fill: #ffffff;">
      <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z"/>
    </svg>
  </button>
  
  <!-- Dropdown menu -->
  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
    <li><a class="dropdown-item" href="#">Profile</a></li>
    <li><a class="dropdown-item" href="#">Settings</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="#">Logout</a></li>
  </ul>
    </div>
  </div>
</nav>



    <!-- CAROUSEL -->
<div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel" style="width: 90%; margin: auto; padding-top: 5px;">
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="5000">
      <img src="img/1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item" data-bs-interval="3000">
      <img src="img/2.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="img/3.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


<!-- ARTIKEL -->
<h1 style="margin-top: 10px; margin-bottom: 10px; border-bottom: black 1px solid; width: 90%; margin: auto;">Artikel</h1>
<div class="bungkus-artikel" style="display: flex; justify-content: space-around; align-items: flex-start;">
    <!-- Card pertama -->
    <div class="card" style="width: 60%; margin: 0; margin-top: 10px; margin-bottom: 10px;">
        <div class="card-body">
          <img src="img/if.png" class="d-block w-50" alt="">
            <h5 class="card-title">Judul Artikel</h5>
            <h6 class="card-subtitle mb-2 text-body-secondary">tanggal artikel</h6>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <a class="btn btn-primary" role="button" aria-disabled="true">Read More</a>
        </div>
    </div>
    <!-- List group kedua -->
    <div class="list-group" style="width: 18rem; margin-top: 10px; margin-bottom: 10px;">
        <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
            Category
        </a>
        <a href="#" class="list-group-item list-group-item-action">A link item 1</a>
        <a href="#" class="list-group-item list-group-item-action">A link item 2</a>
        <a href="#" class="list-group-item list-group-item-action">A link item 3</a>
        <a href="#" class="list-group-item list-group-item-action">A link item 4</a>
    </div>
</div>



<!-- FOOTER -->
<div class="bungkus-footer" style="background-color: #343a40; padding: 20px; color: white; text-align: center; margin-top: 50px;">
    <footer>
        <div>
            <p>&copy; 2025 LemonChip</p>
            <p>Follow us on:
                <a href="#" style="text-decoration: none; color: #f8f9fa; margin: 0 10px;">Facebook</a>|
                <a href="#" style="text-decoration: none; color: #f8f9fa; margin: 0 10px;">Twitter</a>|
                <a href="#" style="text-decoration: none; color: #f8f9fa; margin: 0 10px;">Instagram</a>
            </p>
        </div>
    </footer>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>