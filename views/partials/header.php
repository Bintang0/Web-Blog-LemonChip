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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
          aspect-ratio: 16 / 9; /* Rasio aspek 16:9 */
          object-fit: cover;
      }

      .navbar {
          background-color: #343a40;
      }

      .container {
    flex: 1; /* Menyusun container agar mengambil ruang yang tersisa */
}

  </style>
</head>
<body>
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg" style="background-color: #343a40;">
<div class="container-fluid">
  <img src="img/LogoLemonChip.png" alt="" width="65">
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="index.php" style="color: #f8f9fa;">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" style="color: #f8f9fa;">Blog</a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="about.php" style="color: #f8f9fa;">About</a>
      </li>
    </ul>
    <!-- Tombol Pencarian -->
    <form class="d-flex" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    <!-- Tombol Login -->
<div class="dropdown">
<!-- Dropdown trigger button atau link untuk login -->
<?php if (isset($_SESSION['login']) && $_SESSION['login'] == true): ?>
  <!-- Dropdown menu jika sudah login -->
  <button class="btn btn-outline-primary dropdown-toggle" 
      type="button" 
      id="userDropdown" 
      data-bs-toggle="dropdown" 
      data-bs-auto-close="outside"
      aria-expanded="false"
      style="border: none; background: transparent;">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 24px; height: 24px; fill: #ffffff;">
  <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z"/>
</svg>
</button>
<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
<li><a class="dropdown-item" href="#">Artikel Saya</a></li>
<li><a class="dropdown-item" href="logout.php?logout=true">Logout</a></li>
</ul>
<?php else: ?>
  <!-- Link login jika belum login -->
  <a href="login.php" class="btn btn-outline-primary" style="border: none; background: transparent;">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 24px; height: 24px; fill: #ffffff;">
      <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z"/>
    </svg>
  </a>
<?php endif; ?>
</div>

</nav>