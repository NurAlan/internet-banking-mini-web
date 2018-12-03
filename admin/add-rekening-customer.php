<?php
    //digunakan untuk pengecegahan user yang belum login ketika mengakses halaman ini
    require "./permission.php";
    include "./connect.php";
?>
<!DOCTYPE html>
<html lang=en>
<!--digunakan untuk memberikan informasi halaman web-->
<head>
    <title>LancarJayaIB</title>
    <link rel="icon" type="image/png" href="../img/iconib.png">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/index-admin-style.css">
</head>

<!--digunakan untuk menampilkan isi halaman web-->
<body>
    <!--tampilan paling atas dari isi halaman web-->
    <div class="header">
        <img src="../img/bannerIBank.jpg" alt="gambar-bannerIBank" />
    </div>
    <!--tampilan tulisan dibawah header untuk informasi admin-->
    <div class="sub-header">
        <h2>Halaman Admin - Tambah Rekening</h2>
    </div>
    <!--bagian navigasi halaman web-->
    <div class="column side">
        <!--digunakan untuk menuju halaman web utama-->
        <div class="nav">
            <a href="./index-admin.php">Lihat Daftar Nasabah</a>
        </div>
        <!--digunakan untuk menuju logout admin-->
        <div class="nav">
            <a href="../logout.php">Keluar</a>
        </div>
    </div>
    <!--digunakan untuk menampilkan form tambah rekening-->
    <div class="container">
        <?php 
            //digunakan untuk menyimpan tulisan sukses menambah rekening
            $berhasil = "";
            //digunakan untuk menyimpan error
            $error_add_norekening_baru = "";
            $error_confirm = false;
            if (isset($_POST["button-add"]) )
            {
                //ketika button add sudah digunakan maka akan melakukan validasi dengan menggunakan file validate.php
                require "./validate.php";
                validateAddNoRekening($error_add_norekening_baru, $_POST, "add-norekening", $error_confirm);           
                if ($error_confirm)
                {
                    //jika terdapat error inputan maka form muncul kembali
                    include "../form/form-add-rekening-customer.php";
                }
                else
                {
                    //jika tidak terdapat error maka penambahan rekening pada sebuah username yang sudah dipilih
                    $norekening = $_POST["add-norekening"];
                    
                    //menambah nilai pada tabel rekening_ibanking
                    $query1 = $connect->prepare("INSERT INTO `rekening_ibanking`(`NO_REKENING`, `ID_USER`) VALUES (:norekening, :id);");
                    $query1->bindValue(":norekening", $norekening);
                    $query1->bindValue(":id", $_POST["add-id"]);
                    $query1->execute();
                    
                    //memberikan nilai pada variabe berhasil
                    $berhasil = "Berhasil menambahkan Rekening";
                    $_POST["add-norekening"] = "";
                    include "../form/form-add-rekening-customer.php";
                }
            }
            else
            {
                //digunakan untuk mendapat id dari url
                $ID = $_GET["id"];
                
                //digunakan untuk menampilkan username yang akan ditambah data rekeningnya.
                $kueri = $connect->prepare("SELECT user.USERNAME FROM user WHERE user.ID_USER = :iduser");
                $kueri->bindValue(":iduser",$ID);
                $kueri->execute();
                foreach ($kueri as $hasil){
                    $username = $hasil["USERNAME"];
                }
                include "../form/form-add-rekening-customer.php";
            }
                
        ?>
    </div>
    <!--tampilan paling bawah dari halaman web-->
    <div class="footer">
        &copy; Copyright Kelompok 5 PAW C
    </div>
</body>

</html>
