<?php
    //digunakan untuk pengecegahan user yang belum login ketika mengakses halaman ini
    require "./permission.php";
    include "./connect.php";
 
    if (isset($_POST["delete"]))
    {   
        //jika button delete ditekan maka ada pengecekan banyak rekening dalam 1 user
        if ($_SESSION["banyak_rekening"] == 1){
            //jika username hanya memiliki satu no rekening maka menghapus user dan hubungan rekening dengan user
            $kueri = $connect->prepare("SELECT ID_USER FROM rekening_ibanking WHERE NO_REKENING = :norekening");
            $kueri->bindValue(":norekening", $_POST["norekening"]);
            $kueri->execute();
            foreach ($kueri as $hasil){
                $iduser = $hasil["ID_USER"];
            }
            //digunakan untuk menghapus nilai pada tabel rekening_ibanking
            $kueri_delete1 = $connect->prepare("DELETE FROM `rekening_ibanking` WHERE NO_REKENING = :norekening;");
            $kueri_delete1->bindValue(":norekening", $_POST['norekening']);
            $kueri_delete1->execute();
            
            //digunakan untuk mengahpus user
            $kueri_delete2 = $connect->prepare("DELETE FROM `user` WHERE ID_USER = :iduser ");
            $kueri_delete2->bindValue(":iduser", $iduser);
            $kueri_delete2->execute();
            
            //digunakan untuk berpindah halaman web ke halaman utama admin
            echo "<script>window.location.href = './index-admin.php'; </script>";
        }
        else
        {
            //jika username memiliki lebih dari satu rekening maka yang dihapus hanya pada tabel rekening_ibanking
            $kueri_delete1 = $connect->prepare("DELETE FROM `rekening_ibanking` WHERE NO_REKENING = :norekening; ");
            $kueri_delete1->bindValue(":norekening", $_POST['norekening']);
            $kueri_delete1->execute();
            
            //digunakan untuk berpindah halaman web ke halaman utama admin
            echo "<script>window.location.href = './index-admin.php'; </script>";   
        }
    }
    else 
    {
        //mengambil no rekening dari halaman web
        $norekening = $_GET["rekening"];
        
        //digunakan untuk mengambil nilai dari database
        $kueri = $connect->prepare("SELECT user.ID_USER, rekening_ibanking.NO_REKENING, user.USERNAME, user.PASSWORD, nasabah.NAMA, nasabah.ALAMAT, nasabah.SALDO FROM nasabah, rekening_ibanking, user WHERE nasabah.NO_REKENING = rekening_ibanking.NO_REKENING and user.ID_USER = rekening_ibanking.ID_USER and rekening_ibanking.NO_REKENING = :norekening");
        $kueri->bindValue(":norekening",$norekening);
        $kueri->execute();
        foreach ($kueri as $hasil){
            $id = $hasil["ID_USER"];
            $rekening = $hasil["NO_REKENING"];
            $nama = $hasil["NAMA"];
            $username = $hasil["USERNAME"];
            $alamat = $hasil["ALAMAT"];
            $password = $hasil["PASSWORD"];
            $saldo = $hasil["SALDO"];
        }
        //digunakan untuk mengambil nilai dari tabel rekening_ibanking
        $kueri_select = $connect->prepare ("SELECT * FROM rekening_ibanking WHERE ID_USER = :iduser");
        $kueri_select->bindValue(":iduser", $id);
        $kueri_select->execute();
        foreach ($kueri_select as $hasil){
            $iduser = $hasil["ID_USER"];
        }
        //menyimpan nilai global dari banyak rekening
        $_SESSION["banyak_rekening"] = $kueri_select->rowCount();
    }
    
?>
<!DOCTYPE html>
<html lang="en">

<!--digunakan memberikan informasi tentang halaman web-->
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
    <!--tampilan tulisan dibawah header-->
    <div class="sub-header">
        <h2>Halaman Admin - Hapus Data Customer</h2>
    </div>
    <!--berisi navigasi halaman web-->
    <div class="column side">
        <!--tombol yang digunakan untuk kembali ke halaman utama admin-->
        <div class="nav">
            <a href="./index-admin.php">Lihat Daftar Nasabah</a>
        </div>
        <!--tombol yang digunakan untuk logout admin-->
        <div class="nav">
            <a href="../logout.php">Keluar</a>
        </div>
    </div>
    <!--tampilan konfirmasi hapus rekening-->
    <div class="containter">
        <div class="">
            <?php
                //memanggil form delete
                include "../form/form-delete-customer.php";
            ?>
        </div>
    </div>
    <!--tampilan bawah halaman web-->
    <div class="footer">
        &copy; Copyright Kelompok 5 PAW C
    </div>

</body>

</html>
