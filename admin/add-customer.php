<?php
    //digunakan untuk pengecegahan user yang belum login ketika mengakses halaman ini
    require "./permission.php";
    include "./connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<!--Bagian yang digunakan untuk memberikan info tentang halaman web-->
<head>
    <title>LancarJayaIB</title>
    <link rel="icon" type="image/png" href="../img/iconib.png">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/index-admin-style.css">
</head>

<!--Bagian yang digunakan untuk menampilkan isi halaman web-->
<body>
    <!--bagian tampilan atas halaman web -->
    <div class="header">
        <img src="../img/bannerIBank.jpg" alt="gambar-bannerIBank" />
    </div>
    <!--bagian tampilan tulisan dibawah header-->
    <div class="sub-header">
        <h2>Halaman Admin - Tambah Akun</h2>
    </div>
    <!--bagian navigasi halaman web-->
    <div class="column side">
        <!--digunakan untuk menuju halaman utama admin-->
        <div class="nav">
            <a href="./index-admin.php">Lihat Daftar Nasabah</a>
        </div>
        <!--link yang digunakan untuk menuju halaman tambah akun internet banking-->
        <div class="nav">
            <a href="./add-customer.php">Tambah Akun</a>
        </div>
        <!--link yang digunakan untuk logout dari halaman admin-->
        <div class="nav">
            <a href="../logout.php">Keluar</a>
        </div>
    </div>
    <!--bagian tampilan dari form untuk menambahkan akun internet banking-->
    <div class="container">
        <?php 
            //digunakan untuk menyimpan tulisan sukses dan menyimpan erro
            $berhasil = "";
            $error_add_username = "";
            $error_add_password = "";
            $error_add_cpassword = "";
            $error_add_rekening = "";
    
            $error_confirm = false;
            
            if (isset($_POST["button-add-customer-data"]))
            {
                //kondisi jika tombol tambah sudah diklik melakukan validasi inputan
                require "./validate.php";
                validateUsername($error_add_username, $_POST, "add-username", $error_confirm);
                validatePassword($error_add_password, $_POST, "add-password", $error_confirm);
                validateCPassword($error_add_cpassword, $_POST, "add-cpassword", $error_confirm, $_POST["add-password"]);
                validateAddNoRekening($error_add_rekening, $_POST, "add-norekening", $error_confirm);
                
                if ($error_confirm)
                {
                    //jika ada error maka form tambah akun muncul kembali
                    include "../form/form-add-customer.php";
                }
                else
                {
                    //jika tidak ada error maka data inputan akan ditambah ke database yaitu menambah value ke tabel user
                    $query1 = $connect->prepare("INSERT INTO `user`( `ID_TYPE`, `USERNAME`, `PASSWORD`) VALUES (1,:username,SHA2(:password, 0));");
                    $query1->bindValue(":username", $_POST["add-username"]);
                    $query1->bindValue(":password", $_POST["add-password"]);
                    $query1->execute();
                    
                    //digunakan untuk mengambil nilai id user
                    $query2 = $connect->prepare("SELECT ID_USER FROM `user` WHERE USERNAME = :username");
                    $query2->bindValue(":username", $_POST["add-username"]);
                    $query2->execute();

                    foreach ($query2 as $id){
                        $id_user = $id["ID_USER"];
                    }
                    
                    //digunakan untuk menambahkan nilai ke tabel rekening_ibanking
                    $query3 = $connect->prepare("INSERT INTO `rekening_ibanking` (`NO_REKENING`,`ID_USER`) VALUES (:norekening, :iduser)");
                    $query3->bindValue(":norekening", $_POST["add-norekening"]);
                    $query3->bindValue(":iduser",$id_user);
                    $query3->execute();
                    
                    //memberikan nilai pada variabel berhasil dan menghapus nilai pada variabel POST
                    $berhasil = "Berhasil menambahkan Akun";
                    $_POST["add-username"] = "";
                    $_POST["add-password"] = "";
                    $_POST["add-cpassword"] = "";
                    $_POST["add-norekening"] = "";
                    
                    include "../form/form-add-customer.php";
                }
            }
            else
                include "../form/form-add-customer.php";
        ?>
    </div>
    <!--tampilan bawah halaman web-->
    <div class="footer">
        &copy; Copyright Kelompok 5 PAW C
    </div>
</body>

</html>
