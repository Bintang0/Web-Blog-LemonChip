<?php
require 'functions.php';

if (isset($_SESSION['login'])) {
    header('Location: index.php');
    exit;
}

if (isset($_POST["login"])) {

    // Verifikasi CSRF Token
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        writeLog("Token CSRF tidak valid saat login", "ERROR");
        die("Invalid CSRF token. Please try again.");
    }

    // Verifikasi CAPTCHA
    $captcha = $_POST['g-recaptcha-response'];
    $secretKey = '6LfkW1ArAAAAAOWlRbD5gk05nnnfW9cit5JAFD8O'; // Ganti dengan secret key kamu
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$captcha");
    $responseKeys = json_decode($response, true);

    if (!$responseKeys["success"]) {
        writeLog("Captcha tidak valid saat login", "ERROR");
        die("Captcha tidak valid. Silakan coba lagi.");
    }

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare statement
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // cek email
    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);

        // cek password
        if (password_verify($password, $row["password"])) {
            $_SESSION['login'] = true;
            $_SESSION['UserId'] = $row['UserId'];
            writeLog("Login berhasil untuk email: $email", "INFO");
            header('Location: index.php');
            exit;
        } else {
            writeLog("Login gagal: password salah untuk email: $email", "WARNING");
        }

    } else {
        writeLog("Login gagal: email tidak ditemukan ($email)", "WARNING");
    }

    $error = true;
}
?>






<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-30 w-auto" src="img/LogoLemonChip.png" alt="Your Company">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Masuk ke Lemon Chip</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <?php if (isset($error)): ?>
            <p style="color: red;">username / password salah!</p>
            <?php endif; ?>

            <form class="space-y-6" action="" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Email</label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" autocomplete="email" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input type="password" name="password" id="password" autocomplete="current-password" required
                            minlength="5"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <!-- CAPTCHA -->
                <div class="g-recaptcha" data-sitekey="6LfkW1ArAAAAAJ2MTV-cgy4HKmLva_IHgT1NIK-4"></div>

                <div>
                    <button type="submit" name="login"
                        class="flex w-full justify-center rounded-md bg-gray-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">Masuk</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Tidak punya akun?
                <a href="registrasi.php" class="font-semibold text-gray-600 hover:text-gray-500">Daftar</a>
            </p>
        </div>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>