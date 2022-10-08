<?php
session_start();
require_once("config.php");
if(isset($_POST['add'])) {
    if(isset($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
        $product_image = $_POST['product_image'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        
        $select_cart = "SELECT * FROM cart WHERE name = '{$product_name}' AND user_id = {$user_id}";
        $result = mysqli_query($conn, $select_cart);
        if(mysqli_num_rows($result) > 0) {
            echo "<script>alert('This product is already added to cart')</script>";
        } else {
            $sql = "INSERT INTO cart (user_id, name, price, image, quantity) VALUES ({$user_id}, '{$product_name}', '{$product_price}', '{$product_image}', 1)";
            mysqli_query($conn, $sql);
            echo "<script>alert('Product added to cart')</script>";
        }
    } else echo "<script>alert('You have to login first')</script>";
}
?>

<?php include_once("inc/header.php"); ?>

        <div class="products">
            <div class="box-container">
                <?php
                    $sql = "SELECT * FROM products";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($result)): ?>
                        <form action="" method="post" class="box">
                            <img src="images/<?= $row['image'] ?>" alt="">
                            <div class="name"><?= $row['name'] ?></div>
                            <div class="price"><?= $row['price'] ?>$</div>
                            <input type="hidden" name="product_image" value="<?= $row['image'] ?>">
                            <input type="hidden" name="product_name" value="<?= $row['name'] ?>">
                            <input type="hidden" name="product_price" value="<?= $row['price'] ?>">
                            <button class="btn" name="add">Add to cart</button>
                        </form>
                    <?php endwhile; ?>
            </div>
        </div>

<?php include_once("inc/footer.php"); ?>
