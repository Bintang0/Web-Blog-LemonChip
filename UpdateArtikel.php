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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $judul = $conn->real_escape_string($_POST['judul']);
    $isi = $conn->real_escape_string($_POST['isi']);

    // Update artikel & perbarui tanggal otomatis
    $sql = "UPDATE artikel SET judul='$judul', isi='$isi', updated_at=NOW() WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "updated_at" => date("Y-m-d H:i:s")]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }
}

$conn->close();
?>
