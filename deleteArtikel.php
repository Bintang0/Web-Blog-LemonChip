<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$password = "";
$database = "kpl";

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah ID dikirimkan
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan nama file gambar sebelum dihapus
    $query = "SELECT gambar FROM artikel WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        $gambarPath = "img/" . $data['gambar'];

        // Hapus file gambar jika ada
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }

        // Hapus artikel dari database
        $deleteQuery = "DELETE FROM artikel WHERE id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>alert('Artikel berhasil dihapus!'); window.location.href='ArtikelSaya.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus artikel!'); window.location.href='ArtikelSaya.php';</script>";
        }
    } else {
        echo "<script>alert('Artikel tidak ditemukan!'); window.location.href='ArtikelSaya.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak diberikan!'); window.location.href='ArtikelSaya.php';</script>";
}

// Tutup koneksi
$conn->close();
?>
