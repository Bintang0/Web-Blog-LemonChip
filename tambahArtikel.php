<?php
date_default_timezone_set("Asia/Jakarta"); 
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "kpl";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah form dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date("Y-m-d H:i:s");

    // Upload Gambar
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "img/";
    $target_file = $target_dir . basename($gambar);
    
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        // Simpan ke database
        $sql = "INSERT INTO artikel (judul, isi, tanggal, gambar) VALUES ('$judul', '$isi', '$tanggal', '$gambar')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Artikel berhasil ditambahkan!'); window.location.href='ArtikelSaya.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Gagal mengunggah gambar.";
    }
}

$conn->close();
?>
