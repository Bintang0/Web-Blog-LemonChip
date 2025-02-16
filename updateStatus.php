<?php require 'functions.php';

if (!isset($_SESSION['UserId'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['UserId'];
$action = $_GET['action'] ?? '';
$id = (int)$_GET['id'] ?? 0;

if (!$id) {
    echo "<script>
            alert('ID artikel tidak valid!');
            window.location.href='history.php';
          </script>";
    exit;
}

try {
    // Verify article ownership
    $check_sql = "SELECT id FROM artikel WHERE id = ? AND UserId = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $id, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Anda tidak memiliki hak untuk mengubah artikel ini!");
    }

    // Update article status
    $is_hidden = ($action === 'hide') ? 1 : 0;
    $sql = "UPDATE artikel SET is_hidden = ? WHERE id = ? AND UserId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $is_hidden, $id, $userId);

    if ($stmt->execute()) {
        $message = $action === 'hide' ? 'disembunyikan' : 'dipulihkan';
        echo "<script>
                alert('Artikel berhasil $message!');
                window.location.href='history.php';
              </script>";
    } else {
        throw new Exception("Gagal mengubah status artikel!");
    }

} catch (Exception $e) {
    echo "<script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href='history.php';
          </script>";
}

$conn->close();
?>