<?php 
session_start();
    //jika session dengan index isUser tidak berisi suatu nilai maka kembali ke halaman utama
	if(!isset($_SESSION['isUser'])){
	header("Location: ../index.php");
	
	}
    
    //variabel penyimpan koneksi antara php dengan mysql
	$dbc = new PDO('mysql:host=localhost; dbname=banking', 'root', '');
    
    //digunakan untuk mengambil username dari nasabah yang sudah login
	$NAMA=$_SESSION['User'];	
	$ambil = $dbc -> prepare ("select r.NO_REKENING, r.ID_USER, n.NAMA, n.SALDO  from user u, rekening_ibanking r, nasabah n where u.USERNAME =:NAMA and r.NO_REKENING = n.NO_REKENING and r.ID_USER = u.ID_USER");
	$ambil->bindValue(":NAMA", $NAMA);
	$ambil->execute();

	$ambil2 = $dbc -> prepare ("select r.NO_REKENING, r.ID_USER, n.NAMA, n.SALDO  from user u, rekening_ibanking r, nasabah n where u.USERNAME =:NAMA and r.NO_REKENING = n.NO_REKENING and r.ID_USER = u.ID_USER");
	$ambil2->bindValue(":NAMA", $NAMA);
	$ambil2->execute();
	
?>