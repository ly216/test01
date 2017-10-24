<?php
$servername='localhost';
$username='root';
$password='Ttt246810';
$dbuser='shop';


if($_POST) {
    $target_file="image/";
    $is_valid_image=1;
    if(isset($_FILES['new_prod_image'])) {
        $uploaddir = '/var/www/html/image/';
        $uploadfile = $uploaddir . basename($_FILES['new_prod_image']['name']);
        $target_file="image/".basename($_FILES['new_prod_image']['name']);
        //echo "type: ".$_FILES['new_prod_image']['type'];

        $file_ext=strtolower(end(explode('.',$_FILES['new_prod_image']['name'])));
        $expensions= array("jpeg","jpg","png");
        if(in_array($file_ext,$expensions)=== false){
           $is_valid_image=0;
           echo "Invalid image: please upload jpg,jpeg or png image"."<br/>";
        }
        else {
            echo '<pre>';
            if (move_uploaded_file($_FILES['new_prod_image']['tmp_name'], $uploadfile)) {
                echo "File is valid, and was successfully uploaded.\n";
            } else {
                echo "Possible file upload attack!\n";
            }

            // echo 'Here is some more debugging info:';
            //print_r($_FILES);

            print "</pre>";
        }
    }
# connect to the database
    if($is_valid_image){
$prod_cate=htmlspecialchars($_POST['select_categories']);
$prod_namei = htmlspecialchars($_POST['new_prod_name']);
$prod_pricei=htmlspecialchars($_POST['new_prod_price']);
$prod_description=htmlspecialchars($_POST['new_prod_description']);
  //  echo "new product name: " . $prod_name . "<br/>";
  //  echo "new product price: " . $prod_price . "<br/>";
   // echo "new product descriptiion: " . $prod_description . "<br/>";
//echo $input_name;
try {

$DBH = new PDO("mysql:host=$servername;dbname=shop", $username, $password);
$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
# UH-OH! Typed DELECT instead of SELECT!
//echo "connect done";
} catch (PDOException $e) {
echo "I'm sorry, Dave. I'm afraid I can't do that.";
file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
}

    $cata_name = $DBH->prepare("SELECT * FROM categories ");// echo "00";
    $cata_name->execute();

    $the_cate_id=0;
    while ($result = $cata_name->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
        if($prod_cate==$result['name']) {
            $the_cate_id = $result['catid'];
            break;
        }
    }

$prod_name = $DBH->prepare("SELECT * FROM products ");// echo "00";
$prod_name->execute();

   $new_id=1000;
while ($resulti = $prod_name->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
    if($new_id!=$resulti['pid']) {
        $dd=1;
        break;
    }
    //echo "lala: ".$resulti['catid'];
    $new_id++;
}

echo "new product id: " . $new_id . "<br/>";
echo "new product cate_id: " . $the_cate_id . "<br/>";
echo "new product name: " . $prod_namei . "<br/>";
echo "new product price: " . $prod_pricei . "<br/>";
echo "new product description: " . $prod_description . "<br/>";
$do_add = "INSERT INTO products (pid,catid,name,price,description,image_link) VALUES ($new_id,$the_cate_id,'$prod_namei',$prod_pricei,'$prod_description','$target_file') ";
$DBH->exec($do_add);
//$do_add->execute();
echo "Add done!"."<br/>";

}
echo "Click <a href='/products_mng.php'>Here </a> to go back.";}