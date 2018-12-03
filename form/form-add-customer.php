<form method="POST" action="add-customer.php" name="add-customer-data">
    <!--tampilan tulisam sukses-->
    <?php if (!empty($berhasil)){ ?>
    <div class="input-group">
        <span class="berhasil"> <?php echo $berhasil; ?></span>
    </div>
    <?php } ?>
    <!--inputan username-->
    <div class="input-group">
        <label>Username</label>
        <input type="text" name="add-username" value="<?php if(isset($_POST["add-username"])) 
            { echo htmlspecialchars($_POST["add-username"]); } ?>">
        <span>
            <?php echo $error_add_username; ?></span>
    </div>
    <!-- inputan password -->
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="add-password" value="<?php if(isset($_POST["add-password"])) 
            { echo htmlspecialchars($_POST["add-password"]); } ?>">
        <span>
            <?php echo $error_add_password; ?></span>
    </div>
    <!-- inputan konfirmasi password -->
    <div class="input-group">
        <label>Konfirmasi Password</label>
        <input type="password" name="add-cpassword" value="<?php if(isset($_POST["add-cpassword"])) 
            { echo htmlspecialchars($_POST["add-cpassword"]); }?>">
        <span>
            <?php echo $error_add_cpassword; ?></span>
    </div>
    <!-- inputan no rekening -->
    <div class="input-group">
        <label>No. Rekening</label>
        <input type="text" name="add-norekening" value="<?php if(isset($_POST["add-norekening"])) 
            { echo htmlspecialchars($_POST["add-norekening"]); }?>">
        <span>
            <?php echo $error_add_rekening; ?></span>
    </div>
    <!-- button submit -->
    <div class="input-group">
        <button type="submit" name="button-add-customer-data" class="btn btn-submit">Tambah</button>
        <button type="reset" name="cancel-add-customer-data" class="btn btn-submit" onClick="window.location.href = 'index-admin.php';">Batal</button>
    </div>
</form>
