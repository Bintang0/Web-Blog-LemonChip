<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "kpl";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $judul = $conn->real_escape_string($_POST["judul"]);
    $isi = $conn->real_escape_string($_POST["isi"]);

    $sql = "UPDATE artikel SET judul='$judul', isi='$isi', tanggal=CURRENT_TIMESTAMP() WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Artikel berhasil diperbarui!');
                window.location.href = 'ArtikelSaya.php';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
