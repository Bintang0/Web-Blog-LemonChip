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
    $stmt = $conn->prepare("SELECT nama FROM user WHERE UserId = ?");
    $stmt->bind_param("i", $UserId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama = $row['nama']; // Ambil nama pengguna
    } else {
        echo "User not found!";
    }
}

// Prepare statement
$stmt = $conn->prepare("INSERT INTO comments (artikel_id, isi, nama, tanggal, UserId) VALUES (?, ?, ?, NOW(), ?)");
$stmt->bind_param("issi", $artikel_id, $comment, $nama, $UserId);

if ($stmt->execute() === TRUE) {
    echo "New comment created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();

header("Location: detail.php?id=$artikel_id");
exit;
?>