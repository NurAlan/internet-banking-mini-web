<?php
    //digunakan untuk pengecegahan user yang belum login ketika mengakses halaman ini
    require "./permission.php";
    include "./connect.php";
?>
<!DOCTYPE html>
<html lang=en>

<!--digunakan untuk memberikan informasi mengenai halaman web-->
<head>
    <title>LancarJayaIB</title>
    <link rel="icon" type="image/png" href="../img/iconib.png">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/index-admin-style.css">
</head>

<!--digunakan untuk menampilkan isi halaman web-->
<body>
    <!--tampilan atas halaman web-->
    <div class="header">
        <img src="../img/bannerIBank.jpg" alt="gambar-bannerIBank" />
    </div>
    <!--tampilan tulisan dibawah header -->
    <div class="sub-header">
        <h2>Halaman Admin - Ubah Password</h2>
    </div>
    <!--kumpulan navigasi halaman web-->
    <div class="column side">
        <!--digunakan untuk menuju halaman utama admin-->
        <div class="nav">
            <a href="./index-admin.php">Lihat Daftar Nasabah</a>
        </div>
        <!--digunakan untuk logout admin-->
        <div class="nav">
            <a href="../logout.php">Keluar</a>
        </div>
    </div>
    <!--digunakan untuk menampilkan form ganti password-->
    <div class="container">
        <?php
            //digunakan untuk menyimpan tulisan sukses mengganti password
            $berhasil = "";
            $error_changed_password = "";
            $error_changed_cpassword = "";
            $error_confirm = false;
            if (isset($_POST["button-changed-password"]))
            {
                //untuk pengecekan inputan
                require "./validate.php";
                validatePassword($error_changed_password, $_POST, "add-password", $error_confirm);
                validateCPassword($error_changed_cpassword, $_POST, "add-cpassword", $error_confirm, $_POST["add-password"]);
                if ($error_confirm)
                {
                    //jika terdapat error inputan maka form muncul kembali
                    include "../form/form-changed-password-customer.php";
                }
                else
                {
                    //jika tidak ada error inputan maka mengubah password di database
                    $query1 = $connect->prepare("UPDATE user SET PASSWORD = SHA2(:password, 0) WHERE ID_USER = :iduser");
                    $query1->bindValue(":password", $_POST["add-password"]);
                    $query1->bindValue(":iduser", $_POST['id']);
                    $query1->execute();
                    //memberikan nilai pada variabel berhasil
                    $berhasil = "Berhasil merubah Password";
                    $_POST["add-password"] == "";
                    $_POST["add-cpassword"] == "";
                    include "../form/form-changed-password-customer.php";
                }
            }
            else
            {
                //digunakan untuk mendapatkan id dari url
                $ID = $_GET["id"];
                //digunakan untuk mendapatkan nilai username
                $query = $connect->query("SELECT USERNAME FROM user WHERE ID_USER = $ID");
                $query->execute();
                foreach ($query as $hasil){
                    $username = $hasil["USERNAME"];
                }
                include "../form/form-changed-password-customer.php";
            }
                
        ?>
    </div>
    <!--tampilan bawah halaman web-->
    <div class="footer">
        &copy; Copyright Kelompok 5 PAW C
    </div>
</body>

</html>
