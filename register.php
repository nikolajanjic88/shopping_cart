<?php
    require_once("config.php");
    if(isset($_POST['submit'])) {
        //$msg = "";
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
        if(trim($name) != "" && trim($email) != "" && trim($password) != "" && trim($cpassword) != "") {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $sql = "SELECT * FROM user_info WHERE email = '{$email}'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) == 0) {
                    if($password === $cpassword) {
                        $password = password_hash($password, PASSWORD_DEFAULT);
                        $sql = "INSERT INTO user_info (name, email, password, user_img) VALUES ('{$name}', '{$email}', '{$password}', null)";
                        mysqli_query($conn, $sql);
                        header("location: login.php");
                    } else $msg = "Password and repeat password did not match";
                }
                else $msg = "User already exists!";
            } 
            else $msg = "Email not valid";
        }
        else $msg = "Please, fill all fields!";
    }

?>

<?php include_once("inc/header.php"); ?>
    <div class="form-container">
        <form action="register.php" method="post">
            <input type="text" name="name" placeholder="Enter your username" class="box">
            <input type="text" name="email" placeholder="Enter your email" class="box">
            <input type="password" name="password" placeholder="Enter your password" class="box">
            <input type="password" name="cpassword" placeholder="Confirm your password" class="box">
            <button name="submit" class="btn">Register</button>
            <?php if(isset($msg)): ?>
                <div class="messageErr" onclick="this.remove()"><?php echo $msg; ?></div>
            <?php endif; ?>
            <p>already have account? <a href="login.php">login here</a></p>
        </form>
       
    </div>
<?php include_once("inc/footer.php"); ?>