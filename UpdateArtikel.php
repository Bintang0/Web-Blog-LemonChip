<?php require 'functions.php' ?>
<?php
date_default_timezone_set("Asia/Jakarta");

// Cek apakah user sudah login
if (!isset($_SESSION['UserId'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            window.location.href='login.php';
          </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST["id"];
    $judul = trim($_POST["judul"]);
    $isi = trim($_POST["isi"]);
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $keywords = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';
    $userId = $_SESSION['UserId'];
    $current_time = date('Y-m-d H:i:s');

    // Validasi input dasar
    if (empty($judul) || empty($isi)) {
        echo "<script>
                alert('Judul dan isi artikel tidak boleh kosong!');
                window.history.back();
              </script>";
        exit();
    }

    // Mulai transaction
    $conn->begin_transaction();

    try {
        // Cek kepemilikan artikel dan ambil data current
        $check_sql = "SELECT UserId, gambar FROM artikel WHERE id = ? AND UserId = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $id, $userId);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        $artikel = $result->fetch_assoc();

        if (!$artikel) {
            throw new Exception("Anda tidak memiliki hak untuk mengubah artikel ini!");
        }

        $old_image = $artikel['gambar'];
        $new_image_name = $old_image;
        $update_image = false;

        // Handle image upload jika ada
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['gambar']['name'];
            $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            // Validasi tipe file
            if (!in_array($filetype, $allowed)) {
                throw new Exception("Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan!");
            }

            // Validasi ukuran file (max 5MB)
            if ($_FILES['gambar']['size'] > 5 * 1024 * 1024) {
                throw new Exception("Ukuran file terlalu besar! Maksimal 5MB");
            }

            // Generate nama file unik
            $new_image_name = uniqid() . '_' . time() . '.' . $filetype;
            $target_file = "img/" . $new_image_name;

            // Upload file baru
            if (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                throw new Exception("Gagal mengupload gambar baru!");
            }

            $update_image = true;
        }

        // Format keywords
        $keywords = implode(', ', array_filter(array_map('trim', explode(',', $keywords))));

        // Update artikel
        $sql = $update_image 
            ? "UPDATE artikel SET judul=?, isi=?, category_id=?, keywords=?, gambar=?, tanggal=? WHERE id=? AND UserId=?"
            : "UPDATE artikel SET judul=?, isi=?, category_id=?, keywords=?, tanggal=? WHERE id=? AND UserId=?";
        
        $stmt = $conn->prepare($sql);
        
        if ($update_image) {
            $stmt->bind_param("ssisssii", $judul, $isi, $category_id, $keywords, $new_image_name, $current_time, $id, $userId);
        } else {
            $stmt->bind_param("ssissii", $judul, $isi, $category_id, $keywords, $current_time, $id, $userId);
        }

        if (!$stmt->execute()) {
            throw new Exception("Gagal memperbarui artikel!");
        }

        // Update keywords dalam article_keywords
        $delete_keywords = "DELETE FROM article_keywords WHERE artikel_id = ?";
        $stmt = $conn->prepare($delete_keywords);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if (!empty($keywords)) {
            $keywordsArr = array_unique(array_filter(array_map('trim', explode(',', $keywords))));
            foreach ($keywordsArr as $keyword) {
                $sql = "INSERT INTO article_keywords (artikel_id, keyword) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("is", $id, $keyword);
                $stmt->execute();
            }
        }

        // Jika update gambar berhasil, hapus gambar lama
        if ($update_image && $old_image && file_exists("img/" . $old_image)) {
            unlink("img/" . $old_image);
        }

        $conn->commit();
        echo "<script>
                alert('Artikel berhasil diperbarui!');
                window.location.href='ArtikelSaya.php';
              </script>";

    } catch (Exception $e) {
        $conn->rollback();
        
        // Jika ada error dan gambar baru sudah diupload, hapus gambar tersebut
        if (isset($update_image) && $update_image && file_exists("img/" . $new_image_name)) {
            unlink("img/" . $new_image_name);
        }

        echo "<script>
                alert('Error: " . $e->getMessage() . "');
                window.history.back();
              </script>";
    }
}

$conn->close();
?>