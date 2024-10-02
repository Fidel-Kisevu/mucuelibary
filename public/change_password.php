<h2>Change Password</h2>
<form action="change_password_process.php" method="POST">
    <div class="form-group">
        <label for="current_password">Current Password</label>
        <input type="password" class="form-control" id="current_password" name="current_password" required>
    </div>
    <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" class="form-control" id="new_password" name="new_password" required>
    </div>
    <button type="submit" class="btn btn-primary">Change Password</button>
</form>

