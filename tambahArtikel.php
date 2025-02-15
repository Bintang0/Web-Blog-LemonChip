<?php
session_start();
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

// Cek apakah pengguna sudah login
if (!isset($_SESSION['UserId'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href='login.php';</script>";
    exit();
}

$UserId = intval($_SESSION['UserId']);

// Periksa form yang dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date("Y-m-d H:i:s");

    // Upload Gambar
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "img/";
    $target_file = $target_dir . basename($gambar);
    
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        // Simpan data ke database 
        $sql = "INSERT INTO artikel (judul, isi, tanggal, gambar, UserId) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $judul, $isi, $tanggal, $gambar, $UserId);

        if ($stmt->execute()) {
            echo "<script>alert('Artikel berhasil ditambahkan!'); window.location.href='ArtikelSaya.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Gagal mengunggah gambar.";
    }
}

$conn->close();
?>
