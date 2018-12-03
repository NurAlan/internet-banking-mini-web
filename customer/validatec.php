
<?php

//digunakan untuk koneksi antara php dengan mysql
$dbc = new PDO('mysql:host=localhost; dbname=banking', 'root', '');

//fungsi digunakan untuk pengecekan ada atau tidak nilai pada parameter sebut
function ada_isi($kata) {
    if (!empty($kata)) {
        return True;
    }
	return false;
}

//fungsi digunakan untuk pengecekan password
 function validate_password($password,&$error_password){
 	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	if(!ada_isi($password)){
        //jika password tidak terisi
		$error_password ="* Password harus diisi";
	}
	elseif (!$uppercase || !$lowercase || !$number) {
        //jika password tidak sesuai dengan reg_exp yaitu huruf besar  huruf kecil dan angka 
		$error_password ="* Password harus kombinasi huruf besar, huruf kecil dan angka";
	}
	elseif (strlen($password) < 8) {
        //jika password kurang dari 8 digit
		$error_password = "* Password minimum 8 digit";
	}

 }

//fungsi untuk pengecekan konfirmasi password
 function validate_kecocokanpassword($konpassword,$password,&$error_password){
 	if(!ada_isi($konpassword)){
        //jika konfirmasi password belum diisi
		$error_password = "* Konfirmasi Password baru harus diisi !";
	}
	elseif ($konpassword != $password) {
        //jika konfirmasi password tidak sama dengan password pertama
		$error_password = "* Password tidak cocok!";
	}

 }


//fungsi pengecekan apakah password lama benar dengan yang diinputkan
 function cek_adapassword($cekpass,&$error_password){
 	global $dbc;
     //digunakan untuk melihat data user berdasarkan username
 	$statement = $dbc->prepare("select * from user where USERNAME = :USERNAME");
	$NAMA=$_SESSION['User'];	
	$statement->bindValue(":USERNAME", $NAMA);
	$statement->execute();
     
     //digunakan untuk mengonversi password yang dinputkan ke dalam hash SHA2
	$statement1 = $dbc -> prepare("select SHA2(:PASSWORD,0)");
	$statement1 -> bindValue(":PASSWORD",$cekpass);
	$statement1 -> execute();

	foreach ($statement as $row) {
		$passwordnya=$row['PASSWORD'];
	}

	foreach($statement1 as $row){
		$cek = $row[0];
	}
 	if(!ada_isi($cekpass)){
        //jika password lama tidak input maka muncul error dibawah
		$error_password="* Masukkan Password lama !";
	}
	elseif ($cek != $passwordnya) {
        //jika password tidak sama dengan password lama pada database
		$error_password= "* Password salah !";
	}
 }

//fungsi pengecekan rekening penerima
 function validate_rekeningpenerima($rek_penerima,&$error_penerima){
 	global $dbc;
     //digunakan untuk melihat data penerima
 	$cek_penerima = $dbc->prepare("select * from nasabah where NO_REKENING = :rek_penerima");
	$cek_penerima->bindValue(":rek_penerima",$rek_penerima);
	$cek_penerima->execute();

	if(!ada_isi($rek_penerima)){
        //norekening penerima belum diinputkan
		$error_penerima = "* No.Rekening Penerima Harus diisi";
	}
	else{
		if(!preg_match("/^[0-9]*$/",$rek_penerima)){
            //inputan tidak sesuai dengan regular expression
			$error_penerima = "Pastikan nomer rekening angka";
		}
		else{
			if(strlen($rek_penerima) < 10){
                //no rekening kurang dari 10 digit
				$error_penerima = "* Pastikan nomer rekening 10 digit";

			}
			else{
                //no rekening tidak tersedia
				$ada = $cek_penerima->rowCount() > 0 ;
				if (!$ada) {
					$error_penerima = "* Nomer Rekening tidak ditemukan !";	
				}
			}
		}
	}

}

//fungsi validasi saldo
function validate_saldo($jumlah_saldo,$rek_pengirim,&$error_saldo){

	global $dbc;
    //digunakan untuk melihat data dari nasabah
	$cek_saldo= $dbc -> prepare("select * from nasabah where NO_REKENING = :rek_pengirim");
	$cek_saldo->bindValue(":rek_pengirim",$rek_pengirim);
	$cek_saldo->execute();
	foreach ($cek_saldo as $baris) {
		$saldo_pengirim = $baris["SALDO"];
		}
	if(!ada_isi($jumlah_saldo)){
        //saldo belum diinputkan
		$error_saldo = "* Jumlah transaksi belum terisi !";
	}
	else{
		if(!preg_match("/^[0-9]*$/",$jumlah_saldo)){
            //saldo tidak angka
			$error_saldo = "* Pastikan jumlah transaksi adalah angka!";
		}
		else{
			if($saldo_pengirim < 50000){
                    //saldo pengirim kurang dari 50000
					$error_saldo="* Maaf saldo tidak cukup!";
				}
				else{
					$sisa= $saldo_pengirim-$jumlah_saldo;
					if(($saldo_pengirim-$jumlah_saldo) < 50000){
                        //saldo pengirim setelah dikurangi jumlah saldo kurang 50000
						$error_saldo="* Maaf Saldo tidak cukup!";
					}
				}
			}

}
}

//fungsi untuk melihat isi saldo
function isi_saldo($rekening){
	global $dbc;
	$cek_saldo= $dbc -> prepare("select * from nasabah where NO_REKENING = :rekening");
	$cek_saldo->bindValue(":rekening",$rekening);
	$cek_saldo->execute();
	foreach ($cek_saldo as $baris ) {
		$saldo = $baris["SALDO"];
		}
	return $saldo;
}
?>