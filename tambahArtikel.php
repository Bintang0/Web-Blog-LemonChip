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

// Cek apakah user sudah login
if (!isset($_SESSION['UserId'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            window.location.href='login.php';
          </script>";
    exit();
}

$UserId = intval($_SESSION['UserId']);

// Periksa form yang dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = trim($_POST['judul']);
    $isi = trim($_POST['isi']);
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $keywords = isset($_POST['keywords']) ? trim($_POST['keywords']) : '';
    $tanggal = date("Y-m-d H:i:s");
    $status = "Dipublish";
    
    // Validasi input
    if (empty($judul) || empty($isi)) {
        echo "<script>
                alert('Judul dan isi artikel harus diisi!');
                window.history.back();
              </script>";
        exit();
    }

    // Validasi file gambar
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['gambar']['name'];
        $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        // Validasi tipe file
        if (!in_array($filetype, $allowed)) {
            echo "<script>
                    alert('Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan!');
                    window.history.back();
                  </script>";
            exit();
        }

        // Validasi ukuran file (max 5MB)
        if ($_FILES['gambar']['size'] > 5000000) {
            echo "<script>
                    alert('Ukuran file terlalu besar! Maksimal 5MB');
                    window.history.back();
                  </script>";
            exit();
        }

        // Generate nama file unik
        $gambar = uniqid() . '.' . $filetype;
        $target_dir = "img/";
        $target_file = $target_dir . $gambar;
        
        // Upload file
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            // Format keywords
            $keywords = implode(', ', array_filter(array_map('trim', explode(',', $keywords))));
            
            // Mulai transaction
            $conn->begin_transaction();
            
            try {
                // Simpan artikel ke database
                $sql = "INSERT INTO artikel (judul, isi, tanggal, gambar, UserId, status, category_id, keywords) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssisis", $judul, $isi, $tanggal, $gambar, $UserId, $status, $category_id, $keywords);
                
                if ($stmt->execute()) {
                    $artikel_id = $conn->insert_id;
                    
                    // Simpan keywords ke table article_keywords jika ada
                    if (!empty($keywords)) {
                        $keywordsArr = array_unique(array_filter(array_map('trim', explode(',', $keywords))));
                        foreach ($keywordsArr as $keyword) {
                            $sql = "INSERT INTO article_keywords (artikel_id, keyword) VALUES (?, ?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("is", $artikel_id, $keyword);
                            $stmt->execute();
                        }
                    }
                    
                    $conn->commit();
                    echo "<script>
                            alert('Artikel berhasil ditambahkan!');
                            window.location.href='ArtikelSaya.php';
                          </script>";
                } else {
                    throw new Exception("Gagal menyimpan artikel");
                }
            } catch (Exception $e) {
                $conn->rollback();
                // Hapus file gambar jika upload gagal
                if (file_exists($target_file)) {
                    unlink($target_file);
                }
                echo "<script>
                        alert('Gagal menambahkan artikel: " . $e->getMessage() . "');
                        window.history.back();
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Gagal mengupload gambar!');
                    window.history.back();
                  </script>";
        }
    } else {
        echo "<script>
                alert('Gambar harus diupload!');
                window.history.back();
              </script>";
    }
}

$conn->close();
?>