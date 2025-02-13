<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kpl";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the comment data from the form
$artikel_id = isset($_POST['artikel_id']) ? (int)$_POST['artikel_id'] : 0;
$comment = isset($_POST['comment']) ? $conn->real_escape_string($_POST['comment']) : '';
$nama = "Anonymous"; // For simplicity, we use "Anonymous" as the commenter name. You can implement user authentication to get the actual user name.

// Insert the comment into the database
$sql = "INSERT INTO comments (artikel_id, isi, nama, tanggal) VALUES ('$artikel_id', '$comment', '$nama', NOW())";

if ($conn->query($sql) === TRUE) {
    echo "New comment created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Redirect back to the artikel detail page
header("Location: detail.php?id=$artikel_id");
exit;
?>