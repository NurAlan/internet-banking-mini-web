<form name="edit_customer" method="POST" action="edit-customer.php">
    <!-- tampilan username -->
    <div class="input-group">
        <label>No. Rekening</label>
        <input type="hidden" name="edit-norekening" value="<?php if(isset($_POST["edit-norekening"])) 
            { echo htmlspecialchars($_POST["edit-norekening"]); }
        else { echo $rekening; }
               ?>">
        <label class="biru">
            <?php if (isset($_POST["edit-norekening"])){
                echo $_POST["edit-norekening"];
            }else{
                echo $rekening;
            } ?>
        </label>
        <span></span>
    </div>
    <!-- tampilan username -->
    <div class="input-group">
        <label>Username</label>
        <input type="hidden" name="edit-username" value="<?php
        if(isset($_POST["edit-username"])) 
            { echo htmlspecialchars($_POST["edit-username"]); }
        else { echo $username; } ?>">
        <label class="biru">
            <?php if (isset($_POST["edit-username"])){
                echo $_POST["edit-username"];
            }else{
                echo $username;
            } ?>
        </label>
    </div>
    <!-- inputan nama -->
    <div class="input-group">
        <label>Nama</label>
        <input type="text" name="edit-nama" value="<?php if(isset($_POST["edit-nama"])) 
            { echo htmlspecialchars($_POST["edit-nama"]); }
        else { echo $nama; } ?>">
        <span><?php echo $error_nama ?></span>
    </div>
    <!-- inputan email -->
    <div class="input-group">
        <label>Email</label>
        <input type="text" name="edit-email" value="<?php if(isset($_POST["edit-email"])) 
            { echo htmlspecialchars($_POST["edit-email"]); }
        else { echo $email; } ?>">
        <span><?php echo $error_email ?></span>
    </div>
    <!-- inputan alamat -->
    <div class="input-group">
        <label>Alamat</label>
        <input type="text" name="edit-alamat" value="<?php if(isset($_POST["edit-alamat"])) 
            { echo htmlspecialchars($_POST["edit-alamat"]); }
        else { echo $alamat; } ?>">
        <span><?php echo $error_alamat ?></span>
    </div>
    <!-- tombol ubah untuk mengubah data nasabah -->
    <div class="input-group">
        <input type="hidden" name="id" value="<?php if($_POST['edit']){ echo $_POST['id']; }else { echo $_GET['rekening']; } ?>">
        
        <button type="submit" name="edit" class="btn btn-submit">Ubah</button>
        <button type="reset" name="cancel-add-customer-data" class="btn btn-submit" onClick="window.location.href = 'index-admin.php';">Batal</button>
    </div>
</form>
