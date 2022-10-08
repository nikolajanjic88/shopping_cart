<?php
    session_start();
    if(isset($_SESSION['user'])) {
        header("location: index.php");
    }
    require_once("config.php");
    if(isset($_POST['submit'])) {
        //$msg = "";
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        if($email != "" && $password != "") {
            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $sql = "SELECT * FROM user_info WHERE email = '{$email}'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    if(password_verify($password, $row['password'])) {
                        $_SESSION['user'] = $row['name'];
                        $_SESSION['id'] = $row['id'];
                        header("location: index.php");
                       // echo $_SESSION['user'];
                    }
                    else $msg = "Password inccorect";
                }
                else $msg = "User not exists";
            } 
            else $msg = "Email not valid";
        }
        else $msg = "Please, fill all fields!";
    }

?>
<?php include_once("inc/header.php"); ?>
        <div class="form-container">
            <form action="login.php" method="post">
                <input type="text" name="email" placeholder="Enter your email" class="box">
                <input type="password" name="password" placeholder="Enter your password" class="box">
                <button name="submit" class="btn">Register</button>
                <?php if(isset($msg)): ?>
                    <div class="messageErr" onclick="this.remove()"><?php echo $msg; ?></div>
                <?php endif; ?>
                <p>Dont have account? <a href="register.php">register here</a></p>
            </form>
        
        </div>
<?php include_once("inc/footer.php"); ?>