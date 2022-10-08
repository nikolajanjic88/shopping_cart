<?php
session_start();
require_once("config.php");
if(!isset($_SESSION['id'])) {
    header("location: login.php");
    exit;
}
$user_id = $_SESSION['id'];

if(isset($_POST['update_cart'])) {
    $update_quantity = $_POST['cart_quantity'];
    $update_id = $_POST['cart_id'];
    mysqli_query($conn, "UPDATE cart SET quantity = '$update_quantity' WHERE id = '$update_id'");
}

if(isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    $sql = "DELETE FROM cart WHERE id = {$remove_id}";
    mysqli_query($conn, $sql);
    header("location: cart.php");
}

if(isset($_GET['action']) && $_GET['action'] == "delete") {
    $sql = "DELETE FROM cart WHERE user_id = {$user_id}";
    mysqli_query($conn, $sql);
    header("location: cart.php");
    
}
?>

<?php include_once("inc/header.php"); ?>

<div class="shopping-cart">
    <h1 class="heading">shopping cart</h1>
    <table>
        <thead>
            <th>image</th>
            <th>name</th>
            <th>price</th>
            <th>qunatity</th>
            <th>total price</th>
            <th>action</th>
        </thead>
        <tbody>
            <?php
                $total = 0;
                $select_cart = "SELECT * FROM cart WHERE user_id = {$user_id}";
                $result = mysqli_query($conn, $select_cart);
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)):
            ?>
                        <tr>
                            <td><img src="images/<?= $row['image'] ?>" alt="" height="100"></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['price'] ?>$</td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="cart_id" value="<?= $row['id'] ?>">
                                    <input type="number" name="cart_quantity" min="1" value="<?= $row['quantity'] ?>">
                                    <button class="option-btn" name="update_cart">Update</button>
                                </form>
                            </td>
                            <td><?= $sub_total = $row['price']*$row['quantity'] ?>$</td>
                            <td><a href="cart.php?remove=<?= $row['id'] ?>" class="delete-btn">Remove</a></td>
                        </tr>
            <?php
                $total += $sub_total;
                    endwhile;
                }
                else echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
                
                ?>
                <tr class="table-bottom">
                    <td colspan="4">grand total: </td>
                    <td><?= $total ?>$</td>
                    <td><button class="delete-btn delete-all">Delete all</button></td>
                </tr>
        </tbody>
    </table>
    <div class="cart-btn">
        <a href="" class="btn">Proceed to checkout</a>
    </div>
</div>
<?php include_once("inc/footer.php"); ?>