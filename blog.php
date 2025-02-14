<?php require ('functions.php'); ?>

<?php
// Ambil halaman saat ini, default ke 1 jika tidak ada
$perPage = 5; // Batasi artikel per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $perPage;

// Hitung total artikel
$totalArtikel = count(query('SELECT * FROM artikel'));
$totalPages = ceil($totalArtikel / $perPage);

// Query dengan pagination
$all = query("SELECT * FROM artikel ORDER BY tanggal DESC LIMIT $perPage OFFSET $start");
?> 

<?php require('views/partials/header.php'); ?>

<!-- Wrapper untuk memastikan footer di bawah -->
<div class="content-wrapper">

    <!-- Bagian Utama -->
    <div class="content-main">
        <!-- ARTIKEL -->
        <h1>New Articles</h1>
        <div class="bungkus-artikel" style="display: flex; justify-content: center; align-items: flex-start; margin-bottom: 20px;">
            <!-- Card pertama (diatur vertikal) -->
            <div style="display: flex; flex-direction: column; width: 40%; margin-top: 10px; margin-bottom: 10px;">
                <?php foreach($all as $alls) { ?>
                <div class="card" style="width: 100%; margin-top: 10px; margin-bottom: 10px;">
                    <div class="card-body">
                        <img src="img/<?= $alls["gambar"] ;?>" class="d-block w-100" alt="" style="object-fit: cover; width: 500px; height: 200px;">
                        <h5 class="card-title"><?= $alls["judul"] ;?></h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary"><?= $alls["tanggal"] ;?></h6>
                        <p class="card-text"><?= substr($alls["isi"], 0, 150); ?>...</p>
                        <a href="detail.php?id=<?= $alls['id']; ?>" class="btn btn-primary">Read More</a>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- List group satu (di sebelah kanan card) -->
            <div class="list-group" style="width: 18rem; margin-left: 20px; margin-top: 10px; margin-bottom: 10px;">
                <a href="#" class="list-group-item list-group-item-action active">Category</a>
                <a href="#" class="list-group-item list-group-item-action">A link item 1</a>
                <a href="#" class="list-group-item list-group-item-action">A link item 2</a>
                <a href="#" class="list-group-item list-group-item-action">A link item 3</a>
                <a href="#" class="list-group-item list-group-item-action">A link item 4</a>
            </div>
        </div>

        <!-- Pagination (Tetap di atas footer) -->
        <div class="pagination-container">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- FOOTER (Tetap di Bawah) -->
    <?php require('views/partials/footer.php'); ?>

</div>
