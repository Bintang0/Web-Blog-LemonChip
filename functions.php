<?php

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

  //register

function registrasi($data) {
    global $conn;
    $nama = strtolower(stripslashes($data["nama"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    $email = htmlspecialchars($data["email"]);
  
  
    //cek nama sudah ada atau belum
    $result = mysqli_query($conn, "SELECT nama FROM user WHERE nama = '$nama'");
  
    if( mysqli_fetch_assoc($result)) {
      echo " <script>
                alert('nama sudah terdaftar');    
            </script> 
      ";
      return false;
    }
  
    //cek konfirmasi pass
    if( $password !== $password2 ) {
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
?>