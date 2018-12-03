<form method="POST" action="add-rekening-customer.php" name="add-rekening-customer-data">
    <!-- tampilan tulisann sukses -->
    <?php if (!empty($berhasil)){ ?>
    <div class="input-group">
        <span class="berhasil">
            <?php echo $berhasil; ?></span>
    </div>
    <?php } ?>
    <!--tampilan username -->
    <div class="input-group">
        <label>Username</label>
        <input type="hidden" name="username" value=" <?php if(isset($_POST["username"])) { echo htmlspecialchars($_POST["username"]); } else { echo $username; } ?>">
        <label class="biru">
            <?php 
            if (isset($_POST["button-add"])){
                echo $_POST["username"];
            }else{
                echo $username;
            }  ?></label>
    </div>
    <!--inputan No. Rekening -->
    <div class="input-group">
        <label>No. Rekening</label>
        <input type="text" name="add-norekening" value="<?php if(isset($_POST["add-norekening"])) echo htmlspecialchars($_POST["add-norekening"]) ?>">
        <span>
            <?php echo $error_add_norekening_baru ?></span>
    </div>
    <!-- tombol tambah -->
    <div class="input-group">
        <input type="hidden" name="add-id" value="<?php if (isset($_POST["button-add"])){ echo $_POST["add-id"]; }else{ echo $_GET["id"]; } ?>">
        <button type="submit" name="button-add" class="btn btn-submit">Tambah</button>
        <button type="reset" name="cancel-add-rekening-customer-data" class="btn btn-submit" onClick="window.location.href = 'index-admin.php';">Batal</button>
    </div>
</form>
