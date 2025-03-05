<?php
session_start();
//koneksi ke DB
$conn = mysqli_connect('localhost', 'root', '', 'kpl');

function query($query)
{
  global $conn;
  $result = mysqli_query($conn, $query);
  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }
  return $rows;
}


// Function to sanitize and validate input
function sanitizeInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Function to get user info from session
function getUserInfo()
{
  // Default values
  $userInfo = [
    'userId' => null,
    'nama' => 'Guest',
    'isLoggedIn' => false
  ];

  // If user is logged in, update the values
  if (isset($_SESSION['login']) && isset($_SESSION['UserId'])) {
    $userInfo['isLoggedIn'] = true;
    $userInfo['userId'] = (int)$_SESSION['UserId'];
    $userInfo['nama'] = isset($_SESSION['nama']) ? sanitizeInput($_SESSION['nama']) : 'Guest';
  }

  return $userInfo;
}

//register
function registrasi($data)
{
  global $conn;
  $nama = strtolower(stripslashes($data["nama"]));
  $password = mysqli_real_escape_string($conn, $data["password"]);
  $password2 = mysqli_real_escape_string($conn, $data["password2"]);
  $email = htmlspecialchars($data["email"]);


  //cek nama sudah ada atau belum
  $stmt = $conn->prepare("SELECT nama FROM user WHERE nama = ?");
  $stmt->bind_param("s", $nama);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->fetch_assoc()) {
    echo " <script>
                alert('nama sudah terdaftar');    
            </script> 
      ";
    return false;
  }

  //cek konfirmasi pass
  if ($password !== $password2) {
    echo " <script>
                alert('Konfirmasi password tidak sesuai');    
            </script> 
      ";
    return false;
  }

  //enkripsi password
  $password = password_hash($password, PASSWORD_DEFAULT);

  //tambahkan userbaru ke database
  $stmt = $conn->prepare("INSERT INTO user VALUES(null, ?, ?, ?, 'user')");
  $stmt->bind_param("sss", $nama, $email, $password);
  $stmt->execute();

  return $stmt->affected_rows;
}

// CSRF token functions
function generateCSRFToken()
{
  if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function verifyCSRFToken($token)
{
  return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Validasi GET parameter ID
function validateId($id) {
  $id = filter_var($id, FILTER_VALIDATE_INT);
  if ($id === false || $id <= 0) {
    return false;
  }
  return $id;
}
?>