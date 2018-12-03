<?php
    //digunakan untuk pengecegahan user yang belum login ketika mengakses halaman ini
    require "./permission.php";
    include "./connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<!--berisi informasi halaman web-->
<head>
    <title>LancarJayaIB</title>
    <link rel="icon" type="image/png" href="../img/iconib.png">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/index-admin-style.css">
</head>

<!--digunakan untuk tampilan isi halaman web-->
<body>
    <!--tampilan atas halaman web-->
    <div class="header">
        <img src="../img/bannerIBank.jpg" alt="gambar-bannerIBank" />
    </div>
    <!--tampilan tulisan dibawah header-->
    <div class="sub-header">
        <h2>Halaman Admin - Ubah Data Customer</h2>
    </div>
    <!--kumpulan navigasi halaman web-->
    <div class="column side">
        <!--digunakan untuk kembali ke halaman utama admin-->
        <div class="nav">
            <a href="./index-admin.php">Lihat Daftar Nasabah</a>
        </div>
        <!--digunakan untuk logout admin-->
        <div class="nav">
            <a href="../logout.php">Keluar</a>
        </div>
    </div>
    <!--digunakan untuk menampilkan form edit-->
    <div class="containter">
        <div class="">
            <?php
            //digunakan untuk menyimpan error inputan
            $error_nama = "";
            $error_email = "";
            $error_alamat = "";
            $error_confirm = false;
            if (isset($_POST["edit"]))
            {
                //jika tombol edit ditekan maka ada pengecekan inputan
                require "validate.php";
                validateName($error_nama, $_POST, "edit-nama", $error_confirm);
                validateEmail($error_email, $_POST, "edit-email", $error_confirm);
                validateAlamat($error_alamat, $_POST, "edit-alamat", $error_confirm);
                if ($error_confirm)
                {
                    //jika terdapat error inputan maka form edit tampil kembali
                    include "../form/form-edit-customer.php";
                }
                else
                {
                    //digunakan untuk mengubah data
                    $kueri_update1 = $connect->prepare("UPDATE nasabah SET NAMA = :nama , ALAMAT = :alamat, EMAIL = :email WHERE NO_REKENING = :norekening; ");
                    $kueri_update1->bindValue(":nama", $_POST["edit-nama"]);
                    $kueri_update1->bindValue(":email", $_POST["edit-email"]);
                    $kueri_update1->bindValue(":alamat", $_POST["edit-alamat"]);
                    $kueri_update1->bindValue(":norekening", $_POST["edit-norekening"]);
                    $kueri_update1->execute();
                    //digunakan untuk kembali ke halam utama jika tidak terdapat error
                    echo "<script>window.location.href = './index-admin.php'; </script>";
                }
            }
            else
            {
                //digunakan untuk menyimpan norekening dari url
                $norekening = $_GET["rekening"];
                //digunakan untuk mencari  id user berdasarkan norekening
                $query = $connect->prepare("SELECT ID_USER FROM rekening_ibanking WHERE NO_REKENING = :norekening");
                $query->bindValue(":norekening", $norekening);
                $query->execute();
                
                foreach ($query as $hasil){
                    $iduser = $hasil["ID_USER"];
                }
                //digunakan untuk melihat data nasabah
                $query1 = $connect->prepare("SELECT NO_REKENING, NAMA, ALAMAT, EMAIL FROM NASABAH WHERE NO_REKENING = :norekening");
                $query1->bindValue(":norekening", $norekening);
                $query1->execute();
                
                foreach ($query1 as $hasil){
                    $rekening = $hasil["NO_REKENING"];
                    $nama = $hasil["NAMA"];
                    $alamat = $hasil["ALAMAT"];
                    $email = $hasil["EMAIL"];
                }
                //digunakan untuk melihat data user
                $query2 = $connect->prepare("SELECT `ID_USER`, `ID_TYPE`, `USERNAME`, `PASSWORD` FROM `user` WHERE ID_USER = :iduser");
                $query2->bindValue(":iduser", $iduser);
                $query2->execute();
                
                foreach($query2 as $hasil){
                    $username = $hasil["USERNAME"];
                }
                //tampil formulir edit
                include "../form/form-edit-customer.php";
            }
            ?>
        </div>
    </div>
    <!--tampilan bawah halaman web-->
    <div class="footer">
        &copy; Copyright Kelompok 5 PAW C
    </div>

</body>

</html>
