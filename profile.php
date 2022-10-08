<?php
session_start();
require_once("config.php");
if(!isset($_SESSION['user'])) {
    header("location: login.php");
    exit;
} 
$id = $_SESSION['id'];
$sql = "SELECT * FROM user_info WHERE id = {$id}";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

?>
<?php include_once("inc/header.php"); ?>
    <?php if($user['user_img'] === null):  ?>
        <img src="avatar/avatar.jpg" alt="" height="300px">
    <?php else: ?>
        <img src="<?= $user['user_img'];  ?>" alt="" height="300px">
    <?php endif; ?>
    <div>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="image"><br>
            <button class="btn" name="submit">Upload image</button>
        </form>
        <h3><?= $user['name']; ?></h3>
    </div>
    <?php
    if(isset($_POST['submit'])) {
        if(($_FILES['image']['name'] != "")) {
            $id_img = $user['id'];
            $img = $_FILES['image'];
            //print_r($img);
            $tmp = $img['tmp_name'];
            $name = "avatar/".$id_img.".".pathinfo($img['name'], PATHINFO_EXTENSION);
            $size = $img['size'];
            if($size < 2000000) {
                $allowed_ext = array("jpg", "jpeg", "webp", "gif", "png", "bmp");
                if(in_array(pathinfo($name, PATHINFO_EXTENSION), $allowed_ext)) {
                    $image = getimagesize($tmp);
                    //print_r($image);
                    if($image[0] < 1200 && $image[1] < 768) {
                        if(@move_uploaded_file($tmp, $name)) {
                            $sql = "UPDATE user_info SET user_img = '{$name}' WHERE id = {$id}";
                            mysqli_query($conn, $sql);
                            header("Refresh:0");

                        } else echo "Upload error";

                    } else echo "Resolution too big";

                } else echo "Not valid format";

            } else echo "Image is too big";

        } else echo "File not chosen";
    }
        
      
    ?>
   
        
<?php include_once("inc/footer.php"); ?>