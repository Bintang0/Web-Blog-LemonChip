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

$UserId = intval($_SESSION['UserId']); // Pastikan UserId adalah integer

// Periksa apakah form dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date("Y-m-d H:i:s");
    $status = "Dipublish"; // Status yang ingin di-set
    
    // Pastikan status benar
    var_dump($status); // Debugging status, pastikan bernilai 'Dipublish'
    
    // Upload Gambar
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "img/";
    $target_file = $target_dir . basename($gambar);
    
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        // Simpan ke database menggunakan prepared statement
        $sql = "INSERT INTO artikel (judul, isi, tanggal, gambar, UserId, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // Bind parameter yang benar sesuai dengan tipe data
        // "sssssi" artinya:
        // s = string, i = integer
        $stmt->bind_param("ssssss", $judul, $isi, $tanggal, $gambar, $UserId, $status); // Cek parameter
        
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
