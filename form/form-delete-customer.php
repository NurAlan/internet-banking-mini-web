<form name="delete_customer" method="POST" action="delete-customer.php">
    <!-- tampilan no rekening -->
    <div class="input-group">
        <label>No. Rekening</label>
        <label class="biru"><?php echo $rekening ?></label>
    </div>
    <!-- tampilan username -->
    <div class="input-group">
        <label>Username</label>
        <label class="biru"><?php echo $username ?></label>
    </div>
    <!-- tampilan nama -->
    <div class="input-group">
        <label>Nama</label>
        <label class="biru"><?php echo $nama ?></label>
    </div>
    <!-- tampilan saldo -->
    <div class="input-group">
        <label>Saldo</label>
        <label class="biru"><?php echo $saldo ?></label>
    </div>
    <div class="input-group">
        <label>Apakah anda yakin ingin menghapus ?</label>
        <input type="hidden" name="norekening" value="<?php echo $_GET['rekening']; ?>">
        
        <button type="submit" name="delete" class="btn btn-submit">Ya</button>
        <button type="reset" name="cancel-add-customer-data" class="btn btn-submit" onClick="window.location.href = 'index-admin.php';">Batal</button>
    </div>
</form>
