<?php
    //digunakan untuk pengecekan apakah nasabah melakukan login dengan benar 
    include './sesi_database.php';

    if(!empty($_POST)) {
        //jika button lihat ditekan maka melakukan pencarian data riwayat transaksi berdasarkan type transaksi dan no. rekening
        $rek = $_POST['nomer'];
        
        global $dbc;

        $baca= $dbc->prepare("SELECT * FROM `transaksi` t, type_transaksi ty WHERE `NR_PENGIRIM`=:rek and ty.ID_TYPE_TRANSAKSI=t.ID_TYPE_TRANSAKSI");
        $baca->bindValue(":rek",$rek);
        $baca -> execute();
        }

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
					<div class="artikel">
			            <form method="POST">
			                <div class="grup">
			                    <label>Pilih Rekening</label>
			                    <select name="nomer" id="nomer">
			                    	<option value="none">No.Rekening</option>
									<?php foreach ($ambil as $row) { $temp = $row['NO_REKENING']; ?>
									<option value=<?php echo $temp; ?>> <?php echo $temp;?></option><?php } ?>
								</select> 
						
			                </div>
			                <div class="grup">
			                    <input name="submit" type="submit" value="submit">
			                </div>
			            </form>
        			</div>
                    <br>
                    <div class="riwayat">
                        <table >
                            <tr>
                                <th>ID TRANSAKSI</th>
                                <th>TANGGAL TRANSAKSI</th>
                                <th>JUMLAH TRANSAKSI</th>
                                <th>TYPE TRANSAKSI</th>
                                <th>SALDO TERAKHIR</th>
                            </tr>
                                <?php
                                if($_POST){ 
                                    foreach ($baca as $a) {
                                        echo "<tr>";
                                        echo "<td>"; echo $a['ID_TRANSAKSI']; echo "</td>";	
                                        echo "<td>"; echo $a['TANGGAL']; echo "</td>";	
                                        echo "<td>Rp. ".number_format($a['JUMLAH_TRANSAKSI'],2,',','.')."</td>";	
                                        echo "<td>"; echo $a['TYPE_TRANSAKSI']; echo "</td>";	
                                        echo "<td>Rp. ".number_format($a['SALDO_TERAKHIR'],2,',','.')."</td>";	
                                        echo "</tr>";
                                    }
                                }
                                ?>
                        </table>
                    </div>
					</div>	
				</div>	
			</div>
		<div class="clear"></div>
		<div class="footer">
				&copy; Copyright Kelompok 5 PAW C
		</div>

	</div>

</body>
</html>



