<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/style.css" rel="stylesheet"/>
</head>
<body>
<?php
    if(isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        $sql = "SELECT * FROM cart WHERE user_id = {$user_id}";
        $result = mysqli_query($conn, $sql);
        $product_number = mysqli_num_rows($result);
    } else $product_number = 0;
?>
<nav>
    <ul>
        <li>
            <a href="index.php">Home</a>
        </li>
        <li>
            <a href="cart.php">Cart(<?= $product_number; ?>)</a>
        </li>
        <?php if(isset($user_id)): ?>
            <li>
                <a href="profile.php">Profile</a>
            </li>
            <li>
                <a href="logout.php">Logout</a>
            </li>
        <?php else: ?>
            <li>
                <a href="login.php">Login/Register</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
    <div class="container">
    