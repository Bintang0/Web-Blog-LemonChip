<?php
require 'functions.php';

if (isset($_POST['register'])) {
    // Verifikasi CSRF Token
    if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
        writeLog("CSRF token tidak valid saat registrasi", "ERROR");
        die("Invalid CSRF token. Please try again.");
    }

    // Jalankan fungsi registrasi
    if (registrasi($_POST) > 0) {
        writeLog("Registrasi berhasil: " . $_POST['email'], "INFO");
        echo "<script>
            alert('User Baru Berhasil Ditambahkan');
            document.location.href = 'login.php';
            </script>";
    } else {
        writeLog("Registrasi gagal: " . mysqli_error($conn), "ERROR");
        echo mysqli_error($conn);
    }
}
?>



<!DOCTYPE html>
<html lang="en" class="h-full bg-white">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-30 w-auto" src="img/LogoLemonChip.png" alt="Your Company">
            <h2 class="mt-0 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Daftar ke Lemon Chip</h2>
        </div>

        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                <div>
                    <label for="nama" class="block text-sm/6 font-medium text-gray-900">Nama</label>
                    <div class="mt-2">
                        <input type="text" name="nama" id="nama" autocomplete="nama" required minlength="3"
                            maxlength="50" pattern="[a-zA-Z0-9\s]{3,50}"
                            title="Nama hanya boleh terdiri dari huruf, angka, dan spasi (3-50 karakter)"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
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
                            minlength="8"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input type="password" name="password2" id="password2" autocomplete="current-password" required
                            minlength="8"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <button type="submit" name="register"
                        class="flex w-full justify-center rounded-md bg-gray-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">Daftar</button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Sudah punya akun?
                <a href="login.php" class="font-semibold text-gray-600 hover:text-gray-500">Masuk</a>
            </p>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>