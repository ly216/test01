<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liu Yuxin's Shop</title>
    <link href="CSS_host.css" rel="stylesheet" type="text/css">
</head>
<body>


<?php
$servername='localhost';
$username='root';
$password='Ttt246810';
$dbuser='shop';
try {

    $DBH = new PDO("mysql:host=$servername;dbname=shop", $username, $password);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo "connect done";
} catch (PDOException $e) {
    echo "I'm sorry, Dave. I'm afraid I can't do that.";
    file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
}
$cata_name = $DBH->prepare("SELECT * FROM categories ");// echo "00";
$cata_name->execute();
$counter=0;
$name_list=array();
$cate_id_list=array();
while ($result = $cata_name->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
    // echo "<option value=$result['name']>$result['name']</option>";
    //echo $result['name'];
    array_push($name_list,$result['name']);
    array_push($cate_id_list,$result['catid']);
}

$get_category=$_GET['catalog'];
if(!$get_category) $get_category=$cate_id_list[0];
$the_cate_id=intval($get_category);
$prod_list = $DBH->prepare("SELECT * FROM products WHERE catid=$the_cate_id ");
$prod_list->execute();
?>


<div id="product_position">
            <ul class="table1">

                <?php

                $j=0;
                while ($result = $prod_list->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
                    echo "<li>"."<table width='68px' height='88px'>"."<tr weith='100%' height='40px'>"."<td>";
                    echo "<a href='Shop_product.php?img_link_qury=".$result['image_link']."&name_qury=".$result['name']."&price_qury=".$result['price']."&Description=".$result['description']."&catalog=".$cate_id_list[$j]."&cataname=".$name_list[$j]."'>";
                    echo "<img width='40px' height='60px' src='".$result['image_link']."'/>"."</a>"."</td>"."</tr>";

                    echo "<tr width='100%'>"."<td width='40%'>";
                    echo "<input type='button' value='To cart'/>"."</td>";
                    echo "<td width='60%'> Name: ".$result['name']."\nPrice: ".$result['price']."$"."</td>"."</tr>"."</table>"."</li>";
                    $j++;
                }
                ?>

            </ul>
</div>

</body>
</html>
