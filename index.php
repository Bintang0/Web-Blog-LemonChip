<?php require ('functions.php');?>
<?php 
$all = query('SELECT * FROM artikel WHERE status="Dipublish" ORDER BY tanggal DESC LIMIT 2') ?>

<?php require('views/partials/header.php') ?>



    <!-- CAROUSEL -->
    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel" style="width: 100vw; margin: auto; ">
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="5000">
      <img src="img/1.jpg" class="d-block w-100" alt="Slide 1">
    </div>
    <div class="carousel-item" data-bs-interval="3000">
      <img src="img/2.jpg" class="d-block w-100" alt="Slide 2">
    </div>
    <div class="carousel-item">
      <img src="img/3.jpg" class="d-block w-100" alt="Slide 3">
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
<h1 class="judul-utama" style="margin: 20px auto;
            padding-bottom: 8px;
            width: 90%;
            text-align: left;
            font-size: 28px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            color: #333;
            border-bottom: 2px solid 	#000000;">New Articles</h1>
            
<div class="bungkus-artikel" style="display: flex; justify-content: center; align-items: flex-start; margin-bottom: 20px;">
    <!-- Card pertama -->
    <div style="display: flex; flex-direction: column; width: 40%; margin-top: 10px; margin-bottom: 10px;">
        <?php foreach($all as $alls) { ?>
        <div class="card" style="width: 100%; margin-top: 10px; margin-bottom: 10px;">
            <div class="card-body">
              <img src="img/<?= $alls["gambar"] ;?>" class="d-block w-100" alt="" style="object-fit: cover; width: 500px; height: 200px;">
                <h5 class="card-title"><?= $alls["judul"] ;?></h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?= $alls["tanggal"] ;?></h6>
                <p class="card-text"><?= $alls["isi"] ;?></p>
                <a href="detail.php?id=<?= $alls['id']; ?>" class="btn btn-primary" role="button" aria-disabled="true">Read More</a>
            </div>
        </div>
        <?php } ?>
    </div>

    <!-- List group satu -->
    <div class="list-group" style="width: 18rem; margin-left: 20px; margin-top: 10px; margin-bottom: 10px;">
        <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
            Category
        </a>
        <a href="#" class="list-group-item list-group-item-action">A link item 1</a>
        <a href="#" class="list-group-item list-group-item-action">A link item 2</a>
        <a href="#" class="list-group-item list-group-item-action">A link item 3</a>
        <a href="#" class="list-group-item list-group-item-action">A link item 4</a>
    </div>
</div>


<?php require('views/partials/footer.php') ?>