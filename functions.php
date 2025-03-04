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
    $userInfo['userId'] = $_SESSION['UserId'];
    $userInfo['nama'] = $_SESSION['nama'] ?? 'Guest';
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
  $result = mysqli_query($conn, "SELECT nama FROM user WHERE nama = '$nama'");

  if (mysqli_fetch_assoc($result)) {
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
  mysqli_query($conn, "INSERT INTO user VALUES(null, '$nama', '$email', '$password', 'user')");

  return mysqli_affected_rows($conn);
}

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
?>