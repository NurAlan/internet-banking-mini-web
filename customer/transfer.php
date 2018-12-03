<?php
    //melakukan pengecekan apakah nasabah sudah melakukan login dengan benar
    include './sesi_database.php';
    //digunakan untuk menyimpan error inputan
    $error_pengirim ="";
    $error_penerima="";
    $error_saldo="";

    $sukses = "";

    if(!empty($_POST)) {
        //jika transfer ditekan maka melakukan pengecekan inputan
        $rek_pengirim = $_POST['nomer'];
        $rek_penerima = $_POST['penerima'];
        $jumlah_saldo = $_POST['saldo'];
        
        //digunakan untuk pengecekan inputan no rekening penerima dan saldo
        require './validatec.php';
        validate_rekeningpenerima($rek_penerima,$error_penerima);
        validate_saldo($jumlah_saldo,$rek_pengirim,$error_saldo);
        if(empty($error_pengirim)&&empty($error_penerima)&&empty($error_saldo)){
            global $dbc;

            $saldo_pengirim = isi_saldo($rek_pengirim);
            $saldo_penerima = isi_saldo($rek_penerima);
            date_default_timezone_set("Asia/Bangkok");
            $tgl = date("Y-m-d H:i:s");
            //digunakan untuk mengubah data saldo pengirim dan saldo penerima serta menambah data pada riwaya transaksi beserta tanggalnya
            $updatetf = $dbc -> prepare("UPDATE `nasabah` SET `SALDO` = :saldoakhir WHERE `nasabah`.`NO_REKENING` = :penerima;
                UPDATE `nasabah` SET `SALDO` = :saldoakhir1 WHERE `nasabah`.`NO_REKENING` = :pengirim;
                INSERT INTO `transaksi` (`NR_PENGIRIM`, `NR_PENERIMA`, `JUMLAH_TRANSAKSI`, `ID_TYPE_TRANSAKSI`, `SALDO_TERAKHIR`, `TANGGAL`) VALUES (:pengirim, :penerima, :jumlah_saldo, 'C', :saldoakhir1, :tgl);
                INSERT INTO `transaksi` (`NR_PENGIRIM`, `NR_PENERIMA`, `JUMLAH_TRANSAKSI`, `ID_TYPE_TRANSAKSI`, `SALDO_TERAKHIR`, `TANGGAL`) VALUES (:penerima, :pengirim, :jumlah_saldo, 'D', :saldoakhir, :tgl);
                ");
            $updatetf -> bindValue(":saldoakhir",$saldo_penerima+$jumlah_saldo);
            $updatetf -> bindValue(":saldoakhir1",$saldo_pengirim-$jumlah_saldo);
            $updatetf -> bindValue(":penerima",$rek_penerima);
            $updatetf -> bindValue(":pengirim",$rek_pengirim);
            $updatetf -> bindValue(":jumlah_saldo",$jumlah_saldo);
            $updatetf -> bindValue(":tgl",$tgl);
            $updatetf -> execute();

            $sukses = "sukses";
        }

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
                                <!--No. Rekening pengirim-->
			                    <label>Rekening Pengirim</label>
			                    <select name="nomer" id="nomer">
			                    	<option value="none">No.Rekening</option>
									<?php foreach ($ambil as $row) { $temp = $row['NO_REKENING']; ?>
									<option value=<?php echo $temp; ?>> <?php echo $temp;?></option><?php } ?>
								</select> 
								<span><?php echo $error_pengirim ?></span>
			                </div>
                            <!--inputan No. Rekening penerima-->
			                <div class="grup">
			                    <label>Rekening Penerima</label>
			                    <input type="text" name="penerima">
			                    <span><?php echo $error_penerima ?></span>
			                </div>
                            <!--inputan uang yang ingin dikirim-->
			                 <div class="grup">
			                    <label>Jumlah Saldo</label>
			                    <input type="text" name="saldo" >
			                    <span><?php echo $error_saldo?></span>
			                </div>
			                <div class="grup">
			                    <input name="transfer" type="submit" value="transfer">
			           
			                </div>
			            </form>
        			</div>
        			<?php echo $sukses; ?>
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



