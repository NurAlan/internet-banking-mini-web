<?php

//fungsi validasi login dengan parameter field list, field username dan password
function validateLogin($field_list, $field_name, $field_password)
{
    include "connect.php";
     //mengecek data username, password dan tipe user dari database   
    $query = $connect->prepare("SELECT USERNAME, PASSWORD, ID_TYPE FROM user WHERE USERNAME = :USERNAME AND PASSWORD = SHA2(:PASSWORD, 0)");
    $query->bindValue(":PASSWORD", $field_list[$field_password]);
    $query->bindValue(":USERNAME", $field_list[$field_name]);
    $query->execute();
    $ada = $query->rowCount()>0;
    if ($ada){
        foreach ($query as $row){
            //mengambil nilai tipe
            $type = $row["ID_TYPE"];
        }
        //jika tipe bernilai 0 maka memberi nilai kembalian 0 jika tidak maka nilai kembaliannya 1
        if($type == 0){
            return 0;
        }else{
            return 1;
        }
    }else{
        return 2;
    }
}

//fungsi validasi username dengan parameter nama error, field list, field name dan konfirmasi error
function validateUsername (&$errors, $field_list, $field_name, &$error_confirm)
{
    include "connect.php";
    $username = $field_list[$field_name];
    //mencari data username 
    $query = $connect->prepare("SELECT user.USERNAME FROM user WHERE user.USERNAME = :username");
    $query->bindValue(":username", $username);
    $query->execute();
    $ada = $query->rowCount();
    
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
    {  
        //pengecekan kolom terisi apa tidak
        $errors = "* Kolom harus diisi";
        $error_confirm = true;
    }  else if ($ada > 0){
        //jika variabel ada lebih dari 1 maka username sudah digunakan
        $errors = "* Username tidak tersedia";
        $error_confirm = true;
    }  
}
//fungsi validasi alamat dengan parameter nama error, field list, field name dan konfirmasi error
function validateAlamat (&$errors, $field_list, $field_name, &$error_confirm)
{ 
    //pengecekan untuk kolom sudah terisi apa tidak
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
    {   
        $errors = "* Kolom harus diisi";
        $error_confirm = true;
    } 
}

//fungsi validasi nama dengan parameter nama error, field list, field name, dan konfirmasi error
function validateName (&$errors, $field_list, $field_name, &$error_confirm)
{
    //berisi regular expression untuk format nama yaitu huruf dan petik
    $pattern = "/^[a-z A-Z'-]+$/"; 
    
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
    { 
        //pengecekan apakah kolom sudah diisi apa tidak
        $errors = "* Kolom harus diisi";
        $error_confirm = true;
    }
    else if (!preg_match($pattern, $field_list[$field_name]))
    {
        //pengecekan apakah input sesuai dengan pattern apa tidak
        $errors = "* Harus mengandung huruf saja";
        $error_confirm = true;
    }
        
    
}

//fungsi validasi email dengan parameter nama error, field list, field name dan konfirmasi error
function validateEmail (&$errors, $field_list, $field_name, &$error_confirm)
{
    //berisi regular expression untuk format email
    $pattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
    
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
    {
        //pengecekan apakah kolom sudah terisi apa tidak
        $errors = '* kolom harus diisi';
        $error_con = true;
    }
    else if (!preg_match($pattern, $field_list[$field_name]))
    {
        //pengecekan apakah inputan sudah sesuai dengan pattern apa tidak
        $errors = '* Email tidak benar';
        $error_confirm = true;
    }
}

//fungsi validasi norekening dengan parameter nama error, field list, field name dan konfirmasi error
function validateNoRekening (&$errors, $field_list, $field_name, &$error_confirm)
{
    include "connect.php";
    //berisi regular expression untuk angka
    $pattern = "/^[0-9]+$/"; //
    $norekening = $field_list[$field_name];
    //digunakan untuk mencari no rekening 
    $kueri = $connect->prepare("SELECT rekening_ibanking.NO_REKENING FROM rekening_ibanking WHERE rekening_ibanking.NO_REKENING = :norekening");
    $kueri->bindValue(":norekening", $norekening);
    $kueri->execute();
    $ada = $kueri->rowCount();
    
    
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
    {   
        //apakah sudah diinput apa tidak
        $errors = "* Kolom harus diisi";
        $error_confirm = true;
    }
    else if (!preg_match($pattern, $field_list[$field_name]))
    {
        //apakah sesuai dengan pattern apa tidak
        $errors = "* Harus mengandung angka!";
        $error_confirm = true;
    }
    else if (strlen($field_list[$field_name]) != 10)
    {
        //harus 10 digit
        $errors = "* No. Rekening harus 10 digit";
        $error_confirm = true;
    } else if ($ada > 0)
    {
        //jika variabel ada bernilai lebih dari 0 maka No. Rekening sudah digunakan
        $errors = "* No. Rekening sudah ada";
        $error_confirm = true;
    }   
}

//fungsi validasi tambah rekening dengan parameter nama error, field list, field name, dan konfirmasi error
function validateAddNoRekening (&$errors, $field_list, $field_name, &$error_confirm)
{
    include "connect.php";
    $pattern = "/^[0-9]+$/"; //berisi regular expression untuk angka
    $norekening = $field_list[$field_name];
    //digunakan untuk mencari no rekening dari rekening_ibanking
    $kueri = $connect->prepare("SELECT rekening_ibanking.NO_REKENING FROM rekening_ibanking WHERE rekening_ibanking.NO_REKENING = :norekening");
    $kueri->bindValue(":norekening", $norekening);
    $kueri->execute();
    $ada = $kueri->rowCount();
    
    //digunakan untuk mencari no rekening dari nasabah
    $cek = $connect->prepare("select * from nasabah where NO_REKENING = :rek_penerima");
	$cek->bindValue(":rek_penerima",$norekening);
	$cek->execute();
    $ada1 = $cek->rowCount();
    
    
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
    {  
        //apakah sudah diisi atau tidak
        $errors = "* Kolom harus diisi";
        $error_confirm = true;
    }
    else if (!preg_match($pattern, $field_list[$field_name]))
    {
        //apakah sesuai dengan format angka
        $errors = "* Harus mengandung angka!";
        $error_confirm = true;
    }
    else if (strlen($field_list[$field_name]) != 10)
    {
        //harus 10 digit
        $errors = "* No. Rekening harus 10 digit";
        $error_confirm = true;
    } else if ($ada > 0){
        //No. Rekening sudah menjadi akun internet banking
        $errors = "* No. Rekening sudah terdaftar sebagai member i-banking";
        $error_confirm = true;
    } else if ($ada1 == 0){
        //No. Rekening tidak ada dalam tabel nasabah
        $errors = "* No. Rekening tidak ditemukan";
        $error_confirm = true;
    }  
}

//fungsi validasi password
function validatePassword (&$errors, $field_list, $field_name, &$error_confirm)
{
    //berisi regular expression untuk huruf besar, huruf kecil dan angka
    $pattern = "/^.*(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/";
    
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
    {   
        //apakah sudah terisi atau tidak
        $errors = "* Kolom harus diisi";
        $error_confirm = true;
    }
    else if (!preg_match($pattern, $field_list[$field_name]))
    {
        //apakah sesaui dengan pattern password atau tidak
        $errors = "* Harus mengandung Huruf Besar, Huruf Kecil dan Angka ";
        $error_confirm = true;
    }
    else if (strlen($field_list[$field_name]) < 8)
    {
        //minimal 8 digit password
        $errors = "* Password kurang dari 8 digit";
        $error_confirm = true;
    } 
        
}

//fungsi validasi konfirmasi password
function validateCPassword (&$errors, $field_list, $field_name, &$error_confirm, &$password)
{ 
    //apakah sudah terisi apa tidak
    if (!isset($field_list[$field_name]) || empty($field_list[$field_name]))
    {   
        $errors = "* Kolom harus diisi";
        $error_confirm = true;
    }
    //apakah sama dengan password pertama yang diinputkan
    else if ( $field_list[$field_name] != $password)
    {
        $errors = "* Password tidak sama";
        $error_confirm = true;
    }
        
}

?>
