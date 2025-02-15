<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$password = "";
$database = "kpl";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM artikel";
$result = $conn->query($sql);
?>

<?php require("views/partials/header.php") ?>

<div class="container mt-4">
    <h2 class="text-center">Manajemen Artikel</h2>

    <!-- Tombol Tambah Artikel -->
        <div class="text-center mb-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" >Tambahkan Artikel</button>
        </div>

        <!-- Modal Tambah Artikel -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Artikel</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="tambahArtikel.php" method="POST" enctype="multipart/form-data">
                    <!-- Nama Artikel -->
                    <div class="mb-3">
                        <label for="article-name" class="col-form-label">Nama Artikel:</label>
                        <input type="text" class="form-control" name="judul" id="article-name" required>
                    </div>
                    
                    <!-- Tanggal & Jam Upload (Otomatis) -->
                    <div class="mb-3">
                        <label for="upload-date" class="col-form-label">Tanggal Upload:</label>
                        <input type="text" class="form-control" name="tanggal" id="upload-date" readonly>
                    </div>

                    <!-- Isi Artikel Singkat -->
                    <div class="mb-3">
                        <label for="article-description" class="col-form-label">Isi Artikel:</label>
                        <textarea class="form-control" name="isi" id="article-description" rows="3" required></textarea>
                    </div>

                    <!-- Upload File Artikel -->
                    <div class="mb-3">
                        <label for="article-image" class="col-form-label">Upload Gambar Artikel:</label>
                        <input type="file" class="form-control" name="gambar" id="article-image" accept=".jpg, .jpeg, .png, .gif" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


    <!-- Menampilkan Artikel -->
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <img src="img/<?php echo htmlspecialchars($row['gambar']); ?>" class="card-img-top" style="width: 100%; height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?php echo htmlspecialchars($row['judul']); ?></h5>
                            <p class="card-text text-center"><?php echo htmlspecialchars($row['isi']); ?></p>
                            <p class="text-center"><small class="text-muted"><?php echo $row['tanggal']; ?></small></p>
                            <div class="d-flex justify-content-center gap-2">
                            <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-primary" role="button" aria-disabled="true">Read More</a>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editArtikel<?php echo $row['id']; ?>">
                                    Edit
                                </button>
                                
                               <!-- Modal Edit Artikel -->
                                <div class="modal fade" id="editArtikel<?php echo $row['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Artikel</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editForm<?php echo $row['id']; ?>" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                    
                                                    <!-- Judul -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Judul:</label>
                                                        <input type="text" class="form-control" name="judul" value="<?php echo htmlspecialchars($row['judul']); ?>" required>
                                                    </div>

                                                    <!-- Isi -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Isi:</label>
                                                        <textarea class="form-control" name="isi" rows="3" required><?php echo htmlspecialchars($row['isi']); ?></textarea>
                                                    </div>

                                                    <!-- Tanggal Terakhir Diperbarui -->
                                                    <div class="mb-3">
                                                        <label class="form-label">Terakhir Diperbarui:</label>
                                                        <input type="text" class="form-control" id="edit-tanggal-<?php echo $row['id']; ?>" value="<?php echo date("d M Y H:i:s", strtotime($row['UpdateArtikel.php'])); ?>" readonly>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <!-- Tombol Delete dengan Konfirmasi Modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['id']; ?>">
                                    Delete
                                </button>
                                
                                <!-- Modal Konfirmasi Delete -->
                                <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus artikel <strong><?php echo htmlspecialchars($row['judul']); ?></strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <a href="deleteArtikel.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center'>Tidak ada artikel yang tersedia.</p>";
        }
        $conn->close();
        ?>
    </div>
</div>
<!-- js untuk input data di tambah artikel  -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[id^='editForm']").forEach(form => {
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            
            let formData = new FormData(this);
            let artikelId = this.querySelector("input[name='id']").value;
            let updatedTimeInput = document.getElementById("edit-tanggal-" + artikelId);

            fetch("UpdateArtikel.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Artikel berhasil diperbarui!");
                    updatedTimeInput.value = new Date().toLocaleString("id-ID", {
                        year: "numeric", month: "long", day: "numeric", 
                        hour: "2-digit", minute: "2-digit", second: "2-digit"
                    });
                } else {
                    alert("Gagal memperbarui: " + data.error);
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
</script>

<script>
  // Set waktu otomatis saat modal dibuka
 document.addEventListener("DOMContentLoaded", function () {
    function updateTime() {
        const now = new Date();
        const formattedDate = now.toLocaleString("id-ID", { 
            year: "numeric", month: "long", day: "numeric", 
            hour: "2-digit", minute: "2-digit", second: "2-digit" 
        });

        const dateInput = document.getElementById("upload-date");
        const dateEditInput = document.getElementById("upload-Editdate");

        if (dateInput) dateInput.value = formattedDate;
        if (dateEditInput) dateEditInput.value = formattedDate;
    }

    // Perbarui waktu secara real-time setiap detik
    setInterval(updateTime, 1000);

    // Set waktu saat modal dibuka
    const modals = document.querySelectorAll(".modal");
    modals.forEach(modal => {
        modal.addEventListener("show.bs.modal", updateTime);
    });
});
</script>
<?php require("views/partials/footer.php") ?>
