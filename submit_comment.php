<?php require 'functions.php' ?>
<?php

// Validasi CSRF Token
if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
    die("Invalid CSRF token. Please try again.");
}

// data komentar dari form
$artikel_id = isset($_POST['artikel_id']) ? (int) $_POST['artikel_id'] : 0;
$comment = isset($_POST['comment']) ? $conn->real_escape_string($_POST['comment']) : '';

// Cek apakah UserId ada di session
$UserId = NULL; // Defaultkan ke NULL jika pengguna tidak login
if (isset($_SESSION['UserId'])) {
    $UserId = $_SESSION['UserId']; // Ambil UserId dari session

    // Ambil nama pengguna berdasarkan UserId
    $sql_nama = "SELECT nama FROM user WHERE UserId = $UserId";
    $result = $conn->query($sql_nama);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama = $row['nama']; // Ambil nama pengguna
    } else {
        echo "User not found!";
    }
}

$sql = "INSERT INTO comments (artikel_id, isi, nama, tanggal, UserId) 
        VALUES ('$artikel_id', '$comment', '$nama', NOW(), " . ($UserId ? $UserId : "NULL") . ")";

if ($conn->query($sql) === TRUE) {
    echo "New comment created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("Location: detail.php?id=$artikel_id");
exit;
?>