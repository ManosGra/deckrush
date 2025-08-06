<form action="functions/authcode.php" method="post">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" class="form-control border border-black" id="username" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control border border-black" id="email" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control border border-black" id="password" required>
    </div>

    <div class="mb-3">
        <label for="cpassword" class="form-label">Confirm Password</label>
        <input type="password" name="cpassword" class="form-control border border-black" id="cpassword" required>
    </div>

    <input type="submit" name="register_btn" class="btn btn-primary py-3" value="Εγγραφή">
</form>
