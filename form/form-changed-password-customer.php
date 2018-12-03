<form method="POST" action="changed-password-customer.php" name="add-rekening-customer-data">
    <!-- tampilan tulisan sukses -->
    <?php if (!empty($berhasil)){ ?>
    <div class="input-group">
        <span class="berhasil">
            <?php echo $berhasil; ?></span>
    </div>
    <?php } ?>
    <!-- tampilan username -->
    <div class="input-group">
        <label>Username</label>

        <label class="biru">
            <?php 
            if (isset($_POST["username"])){
                echo $_POST["username"];
            }else{
                echo $username;
            } 
            ?>
        </label>
    </div>
    <!-- inputan password baru -->
    <div class="input-group">
        <label>Password Baru</label>
        <input type="password" name="add-password" value="<?php  if(isset($_POST["add-password"])) echo htmlspecialchars($_POST["add-password"]) ?>">
        <span>
            <?php echo $error_changed_password ?></span>
    </div>
    <!-- inputan konfirmasi password -->
    <div class="input-group">
        <label>Konfirmasi Password</label>
        <input type="password" name="add-cpassword" value="<?php if(isset($_POST["add-cpassword"])) echo htmlspecialchars($_POST["add-cpassword"]) ?>">
        <span>
            <?php echo $error_changed_cpassword ?></span>
    </div>

    <div class="input-group">
        <input type="hidden" name="id" value="<?php  
            if (isset($_POST["button-changed-password"])){
                echo $_POST["id"];
            }else{
                echo $_GET["id"];
            } 
                                              ?>">
        <input type="hidden" name="username" value="<?php 
            if (isset($_POST["button-changed-password"])){
                echo $_POST["username"];
            }else{
                echo $username;
            }  
                                                    ?>">
        <!--tombol ubah untuk mengubah password -->
        <button type="submit" name="button-changed-password" class="btn btn-submit">Ubah</button>
        <button type="reset" name="cancel-changed-password-customer" class="btn btn-submit" onClick="window.location.href = 'index-admin.php';">Batal</button>
    </div>
</form>
