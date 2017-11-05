<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liu Yuxin's Shop</title>
    <link href="CSS_host.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="shop_list.js"></script>

</head>
<!--
<body  onresize="location.replace(location.href)">
-->
<body onload="upload_page()">
<table class="home_title"> <tr><td> <p style="font-size:30px;color:#FF0">   welcomme to Yuxin's Shop </p> </td>


    </tr></table>

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
$prod_name_list=array();
$prod_id_list=array();
while ($result2 = $prod_list->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
    // echo "<option value=$result['name']>$result['name']</option>";
    //echo $result['name'];
    array_push($prod_name_list,$result2['name']);
    array_push($prod_id_list,$result2['pid']);
}
$prod_list2 = $DBH->prepare("SELECT * FROM products WHERE catid=$the_cate_id ");
$prod_list2->execute();

?>

<table class="home_catagory" id="catagory_table"> <tr class="home_catagory"><td><strong> product catagory</strong></td></tr>
    <?php
    $i=0;
    while($i<count($name_list)){
        echo "<tr class='home_catagory'><td><a href='Shop_host.php?catalog=".$cate_id_list[$i]."&cataname=".$name_list[$i]."'>".$name_list[$i]."</a></td></tr>";
        $i++;
    }
    ?>

</table>
<table class="path" id="path"><tr style="width: 100%"><td> <a href="Shop_host.php">Home </a>
            <?php
            $get_category=$_GET['catalog'];
            if($get_category)
            {
                echo ">>   "."<a href='Shop_host.php?catalog=".$get_category."&cataname=".$_GET['cataname']."'>".$_GET['cataname']."</a>";
            }
            ?>
</td></tr></table>


<table class="home_product" id="product_table"  ><tr><td>
    <ul class="table1">

        <?php

        $j=0;
        while ($result = $prod_list2->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
            echo "<li>"."<table >"."<tr >"."<td>";
            echo "<a href='Shop_product.php?img_link_qury=".$result['image_link']."&name_qury=".$result['name']."&price_qury=".$result['price']."&Description=".$result['description']."&catalog=".$result['catid']."&cataname=".$_GET['cataname']."&prod_id=".$result['pid']."'>";
            echo "<img width='70px' height='60px' src='".$result['image_link']."'/>"."</a>"."</td>"."</tr>";

            echo "<tr>"."<td>";
            $the_prod_id=$result['pid'];
            echo "<input type='button' value='To cart' onclick='add_to_cart($the_prod_id)'/>"."</td>";
            echo "<td > Name: ".$result['name']."\nPrice: ".$result['price']."$"."</td>"."</tr>"."</table>"."</li>";
            $j++;
        }
        ?>

    </ul>
        </td></tr></table>
<div id="shoppingcart">
    <p>shopping cart</p>
    <ul id="host_shopList">
        <li> test </li>
    </ul>
    <ul id="total_price"></ul>
    <ul><li><input type="button" value="recalculate" onclick="show_shop_list()"/></li></ul>
    <input type="hidden" id="money" value="0"/>
</div>



<div id="php_cate_list" name="php_cate_list" >

</div>
<script type="text/javascript">



</script>


</body>
</html>
