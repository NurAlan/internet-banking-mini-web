<?php
    //digunakan untuk pengecegahan user yang belum login ketika mengakses halaman ini
    require "./permission.php";
    include "./connect.php";
    
?>
<!DOCTYPE html>
<html lang="en">

<!--informasi mengenai halaman web-->
<head>
    <title>LancarJayaIB</title>
    <link rel="icon" type="image/png" href="../img/iconib.png">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/index-admin-style.css">
</head>

<!--seluruh tampilan isi halaman web-->
<body>
    <!--tampilan atas halaman web-->
    <div class="header">
        <img src="../img/bannerIBank.jpg" alt="gambar-bannerIBank" />
    </div>
    <!--tampilan tulisan dibawah header-->
    <div class="sub-header">
        <h2>Halaman Admin - Daftar Nasabah</h2>
    </div>
    <!--digunakan untuk menampilkan data nasabah-->
    <div class="containter">
        <!--kumpulan navigasi halaman web-->
        <div class="row">
            <div class="column side">
                <!--digunakan untuk kembali ke halam utama admin-->
                <div class="nav">
                    <a href="./index-admin.php">Lihat Daftar Nasabah</a>
                </div>
                <!--digunakan untuk menuju ke halaman tambah akun-->
                <div class="nav">
                    <a href="./add-customer.php">Tambah Akun</a>
                </div>
                <!--digunakan untuk logout admin-->
                <div class="nav">
                    <a href="../logout.php">Keluar</a>
                </div>
            </div>
            <!--tabel berisi nama-nama nasabah yang sudah tercantum sebagai member internet banking-->
            <div class="column middle">
                <table>
                    <tr>
                        <th>No. Rekening</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Saldo</th>
                        <th colspan="4">Action</th>
                    </tr>
                    <?php
                    //digunakan untuk mengambil data dari tabel nasabah, rekening_ibanking dan user
                    $query = $connect->query("SELECT rekening_ibanking.ID_USER, NASABAH.EMAIL, rekening_ibanking.NO_REKENING, user.USERNAME, NASABAH.NAMA, NASABAH.ALAMAT, NASABAH.SALDO FROM NASABAH, rekening_ibanking, user WHERE NASABAH.NO_REKENING = rekening_ibanking.NO_REKENING and user.ID_USER = rekening_ibanking.ID_USER and user.ID_TYPE = 1 ORDER BY rekening_ibanking.NO_REKENING ASC;");
                    $query->execute();
                    foreach ($query as $statement)
                    {
                        echo "<tr>";
                        echo "<td>{$statement['NO_REKENING']}</td>";
                        echo "<td>{$statement['USERNAME']}</td>";
                        echo "<td>{$statement['NAMA']}</td>";
                        echo "<td>{$statement['ALAMAT']}</td>";
                        echo "<td>{$statement["EMAIL"]}</td>";
                        echo "<td>{$statement['SALDO']}</td>";
                        //tombol ubah digunakan untuk menuju halaman ubah data
                        echo "<td class='a-customer'><a href='./edit-customer.php?rekening={$statement["NO_REKENING"]}' class='btn-edit'>Ubah</a></td>";
                        //tombol hapus digunakan untuk menghapus data
                        echo "<td class='a-customer'><a href='./delete-customer.php?rekening={$statement["NO_REKENING"]}' class='btn-delete'>Hapus</a></td>";
                        //tombol Tambah Rekening digunakan untuk menambah akun rekening ke dalam 1 user
                        echo "<td class='a-customer'><a href='./add-rekening-customer.php?id={$statement["ID_USER"]}' class='btn-add'>Tambah Rekening</a></td>";
                        //tombol Ubah Password digunakan untuk merubah password
                        echo "<td class='a-customer'><a href='./changed-password-customer.php?id={$statement["ID_USER"]}' class='btn-add'>Ubah Password</a></td>";
                        echo "</tr>";
                    }
                            
                    ?>
                </table>
                
            </div>
        </div>
    </div>
    <!--tampilan bawah halaman web-->
    <div class="footer">
        &copy; Copyright Kelompok 5 PAW C
    </div>
</body>

</html>
