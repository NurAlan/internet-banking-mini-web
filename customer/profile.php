<?php
//untuk pengecekan apakah nasabah sudah melakukan login dengan benar
include './sesi_database.php';

//variabel penyimpan tulisan sukses
$sukses = "";
//variabel penyimpan error
$error_pass_baru ="";
$error_password="";
$error_password1="";


if(!empty($_POST)) {
    //jika tombol edit ditekan maka

	$edit_pass_baru = $_POST['edit_pass_baru'];
	$kon_password = $_POST['kon_password'];
	$password_lama = $_POST['password_lama'];
    
    //digunakan untuk pengecekan inputan
	include "./validatec.php";
    validate_password($edit_pass_baru,$error_pass_baru);
	validate_kecocokanpassword($kon_password,$edit_pass_baru,$error_password);
	cek_adapassword($password_lama,$error_password1);

	if(empty($error_pass_baru)&&empty($error_password)&&empty($error_password1)){
		global $dbc;
        //digunakan untuk mengubah password baru
		$statemen1 = $dbc -> prepare("update user SET PASSWORD = SHA2(:PASSWORD,0) WHERE USERNAME =:USERNAME");
		$statemen1 -> bindValue(":PASSWORD",$edit_pass_baru);
		$statemen1 -> bindValue(":USERNAME",$NAMA);
		$statemen1 -> execute();
		$sukses = "edit sukses";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<!--berisi informasi halaman web-->
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
            <!--tampilan edit profile-->
			<div class="content">
				<div class="isi">
					<div class="artikel">
			            <form method="POST">
                            <!--digunakan untuk input password lama-->
			            	<div class="grup">
			                    <label>Konfirmasi Password Lama</label>
			                    <input type="password" name="password_lama" >
			                    <span><?php echo $error_password1 ?></span>
			                </div>
                            <!--digunakan untuk input password baru-->
			                <div class="grup">
			                    <label>Password Baru</label>
			                    <input type="password" name="edit_pass_baru">
			                    <span><?php echo $error_pass_baru ?></span>
			                </div>
                            <!--digunakan untuk input konfirmasi password baru-->
			                 <div class="grup">
			                    <label>Konfirmasi Password Baru</label>
			                    <input type="password" name="kon_password" >
			                    <span><?php echo $error_password ?></span>
			                </div>
			                
			                <div class="grup">
			                    <input name="password" type="submit" value="Edit">
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



