<?php 
//digunakan untuk memulai session
session_start();

if (!isset($_SESSION["isAdmin"])) 
{
    //jika variabel session berindex isAdmin belum diberi nilai maka file akan kembali ke halaman utama
	header("Location: ../index.php");
	exit();
}
?>