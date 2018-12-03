<?php
    //untuk pengecekan apakah nasabah sudah melakukan login dengan benar
    include './sesi_database.php';
?>
<!DOCTYPE html>
<html lang="en">

<!--Berisi informasi tentang halaman web-->
<head>
    <title>LancarJayaIB</title>
    <link rel="icon" type="image/png" href="../img/iconib.png">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/style2.css">
</head>
<!--berisi tampilan isi halaman web-->
<body>
    <!--layout wrap berfungsi untuk mengatur layout isi halaman web-->
    <div class="wrap">
        <!--tampilan atas halaman web-->
        <div class="header">
            <img src="../img/bannerIBank.jpg" alt="gambar-bannerIBank" />
        </div>
        <!--tampilan navigasi halaman web-->
        <header class="">
            <div class="menu-pilihan">
                <ul>
                    <li>
                        <?php
							if (isset($_SESSION['User'])){
								echo "<a href=\"../logout.php\">Logout</a>";
							}
						?>
                    </li>
                    <!--digunakan untuk menuju halaman edit profile-->
                    <li><a href="./profile.php">Edit Profile</a></li>
                    <!--digunakan untuk menuju halaman riwayat transaksi-->
                    <li><a href="./riwayat.php">Riwayat Transaksi</a></li>
                    <!--digunakan untuk menuju halaman transfer-->
                    <li><a href="./transfer.php">Transfer</a></li>
                    <!--digunakan untuk menuju halaman utama nasabah-->
                    <li><a href="./customer.php">Home</a></li>
                </ul>
            </div>
        </header>
        <br>
        <!--berisi tampilan dari hasil navigasi-->
        <div class="badan">
            <div class="sidebar">
                <!--tampilan side bar foto dan username nasabah-->
                <div class="head">
                    <img src="../img/akun.png" alt="gambarAkun">
                    <p>
                        <?php echo $NAMA; ?>
                    </p>
                </div>
                <br>
                <!--digunakan untuk menuju halaman tentang-->
                <div class="tentang">
                    <hr>
                    <ul>
                        <li><a href="./about.php">Tentang</a></li>
                    </ul>
                    <hr>
                </div>
                <br>
                <div class="head">
                    Contac Us
                </div>
                <br>
                <!--tampilan kontak kami-->
                <div class="kontak">
                    <img src="../img/contact.jpg" alt="gambar-kontak" />

                </div>
                <br>
                <div>
                    <h5>Tips Keamanan Perbankan
                        Tidak memberitahukan password
                        dan keamanan anda melalui email atau telepon</h5>
                </div>

            </div>
            <!--tampilan No Rekening dan Saldo sesuai username nasabah-->
            <div class="content">
                <div class="isi">
                    <table class="informasi">
                        <tr>
                            <th>No.Rekening</th>
                            <th>Saldo</th>
                        </tr>
                        <?php
                        //untuk mengambil nilai no rekening dan saldo dari database
							foreach ($ambil as $row1 ) {
								echo "<tr>";
								echo "<td>{$row1['NO_REKENING']}</td>";
								echo "<td>Rp. ".number_format($row1['SALDO'],2,',','.')."</td>";
								echo "</tr>";
							}
						?>
                    </table>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <!--tampilan bawah halaman web-->
        <div class="footer">
            &copy; Copyright Kelompok 5 PAW C
        </div>

    </div>

</body>

</html>
