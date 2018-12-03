<?php 
    session_start(); /*Digunakan untuk memulai permbeian nlai terhadapt variabel %_SESSIoN*/
    if (@$_SESSION["isUser"] == true){
        header("Location: ./customer/customer.php");
    }
    if (@$_SESSION["isAdmin"] == true){
        header("Location: ./admin/index-admin.php");
    }
    if (isset($_POST["masuk"])) {
        require './admin/validate.php';
        $cek = validateLogin($_POST, 'username', 'password');
        if($cek == 0)
        {
            $_SESSION["isAdmin"] = true;
            header("Location: ./admin/index-admin.php");
        }else if($cek == 1){
            $_SESSION["isUser"] = true;
            $_SESSION['User'] = $_POST['username'];
            header("Location: ./customer/customer.php");    
        }
        else{
            $error_login = '* Username & Password Salah';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="./img/iconib.png">
    <link rel="stylesheet" href="./css/index-style.css">
</head>

<body>
    <div class="head">
        <img src="./img/bannerIBank.jpg" alt="gambar-bannerIBank" />
    </div>
    <div class="sub-header">
        <h2>Menabung Yes, Narkoba No!! </h2>
    </div>
    <div class="clear"></div>
    <div class="sidebar">
        <img src="./img/uangku.jpg" alt="gambarLaptopUang" />

        <h5>Tips Keamanan Perbankan<br />
            Tidak memberitahukan password dan keamanan anda melalui email atau telepon</h5>
    </div>
    <div class="content">
        <div class="header">
            <h2 class="judul">Login</h2>
        </div>
        <div class="artikel">
            <form action="./index.php" method="POST" name="formlogin">
                <div class="grup">
                    <label>Username</label>
                    <input type="text" placeholder="Masukkan Username Anda" name="username" value="<?php if(isset($_POST["username"])){ echo htmlspecialchars($_POST["username"]);} ?>">
                </div>
                <div class="grup">
                    <label>Password</label>
                    <input type="password" placeholder="Masukkan password Anda" name="password" value="<?php if(isset($_POST["password"])){ echo htmlspecialchars($_POST["password"]);}?>">
                    <span>
                        <?php if(isset($_POST["masuk"])) {echo $error_login;}?></span>
                </div>
                <div class="grup">
                    <input name="masuk" type="submit" value="Login">
                </div>
            </form>
        </div>
    </div>
    <div class="footer">
        &copy; Copyright Kelompok 5 PAW C
    </div>
</body>

</html>
