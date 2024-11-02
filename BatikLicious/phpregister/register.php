<?php 
    include("../koneksi.php");

    // isset() function akan memeriksa apakah data ada.
    if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
        // tidak dapat memperoleh data.
        exit('Please complete the registration form!');
    }
    // memeriksa submitted form tidak kosong.
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
        //apabila satu atau lebih values kosong.
        exit('Please complete the registration form');
    }

    // check apalbila account username telah ada.
    if ($stmt = $con->prepare('SELECT id, password FROM users WHERE username = ?')) {
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();
        // Menyimpan hasil untuk dicek
        if ($stmt->num_rows > 0) {
            // Username telah digunakan
            echo '<script>
            window.onload = function() {
                alert("Username sudah digunakan, silahkan pilih yang lain");
            };
             </script>';
        } else {
            //Apabila username belum digunakan, daftar akun baru.
            $stmt->close();
            if ($stmt = $con->prepare('INSERT INTO users (first_name, last_name, username, gender, nomer_telp, alamat, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
                $stmt->bind_param('ssssssss', $_POST['first_name'], $_POST['last_name'], $_POST['username'], $_POST['gender'], $_POST['nomer_telp'], $_POST['alamat'], $_POST['email'], $_POST['password']);
                $stmt->execute();
                // Menampilkan Notifikasi dengan JavaScript
            echo "<script>alert('Berhasil Mendaftar');</script>";
            // Mengubah ke halaman login secara otomatis
            echo "<p>Redirecting...</p>";
            echo "<script>setTimeout(function(){ window.location.href = '../phplogin/index.html'; }, 2000);</script>";
                $stmt->close();
            } else {
                // Something is wrong with the SQL statement, so you must check to make sure your users table exists with all eight fields.
                echo 'Could not prepare statement!';
            }
        }
    } else {
        // Something is wrong with the SQL statement, so you must check to make sure your users table exists with all eight fields.
        echo 'Could not prepare statement!';
    }
    $con->close();

?>

