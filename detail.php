<?php require('functions.php') ?>

<?php
// Get the ID from the URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch the data from the database
$sql = "SELECT id, judul, tanggal, isi, gambar FROM artikel WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    $row = $result->fetch_assoc();
} else {
    echo "0 results";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['judul']); ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
   
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg" style="background-color: #343a40;">
  <div class="container-fluid">
    <!-- <a class= "navbar-brand" href="" style="color: #ffffff;"></a> -->
    <img src="img/LogoLemonChip.png" alt="" width="65">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#" style="color: #f8f9fa;">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" style="color: #f8f9fa;">Blog</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="" style="color: #f8f9fa;">About</a>
        </li>
      </ul>
    </nav>
    <div class="container mt-5">
    <a href="index.php" class="" style="text-decoration: none;"><svg xmlns="http://www.w3.org/2000/svg" height="20" width="15.5" viewBox="0 0 448 512" style="margin-right: 10px;"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>Kembali ke Beranda</a>
        <h1 class="h2" style="margin-top: 30px;"><?php echo htmlspecialchars($row['judul']); ?></h1>
        <p><small><?php echo htmlspecialchars($row['tanggal']); ?></small></p>
        <img src="img/<?php echo htmlspecialchars($row['gambar']); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['judul']); ?>">
        <p><?php echo nl2br(htmlspecialchars($row['isi'])); ?></p>

        <div class="comments mt-5">
            <h2>Comments</h2>
            <!-- Comment form -->
            <form action="submit_comment.php" method="post">
                <input type="hidden" name="artikel_id" value="<?php echo $row['id']; ?>">
                <div class="form-group">
                    <label for="comment">Your Comment:</label>
                    <textarea name="comment" id="comment" rows="4" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <!-- Display comments -->
            <?php
            // Connect to the database again to fetch comments
            $conn = new mysqli('localhost', 'root', '', 'kpl');
            $sql = "SELECT * FROM comments WHERE artikel_id = $id ORDER BY tanggal DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($comment = $result->fetch_assoc()) {
                    echo "<div class='comment mt-4'>";
                    echo "<p><strong>" . htmlspecialchars($comment['nama']) . "</strong> <small>" . htmlspecialchars($comment['tanggal']) . "</small></p>";
                    echo "<p>" . nl2br(htmlspecialchars($comment['isi'])) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No comments yet. Be the first to comment!</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <!-- Button to go back to index.php -->
<!-- Button to go back to index.php -->



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>