<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liu Yuxin's Shop</title>
    <link href="CSS_host.css" rel="stylesheet" type="text/css">


</head>
<!--
<body  onresize="location.replace(location.href)">
-->
<body>
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
        while ($result = $prod_list->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
            echo "<li>"."<table >"."<tr >"."<td>";
            echo "<a href='Shop_product.php?img_link_qury=".$result['image_link']."&name_qury=".$result['name']."&price_qury=".$result['price']."&Description=".$result['description']."&catalog=".$cate_id_list[$j]."&cataname=".$name_list[$j]."'>";
            echo "<img width='70px' height='60px' src='".$result['image_link']."'/>"."</a>"."</td>"."</tr>";

            echo "<tr '>"."<td >";
            echo "<input type='button' value='To cart'/>"."</td>";
            echo "<td > Name: ".$result['name']."\nPrice: ".$result['price']."$"."</td>"."</tr>"."</table>"."</li>";
            $j++;
        }
        ?>

    </ul>
        </td></tr></table>
<div id="shoppingcart">
    <p>shopping cart</p>
    <ul>
        <li>cat $45</li>
        <li>cola $5.5</li>
        <li>puting $12</li>
        <input type="button" id="check_out_button" value="Check out" align="right"/>
    </ul>

</div>



<div id="php_cate_list" name="php_cate_list" >

</div>
<script type="text/javascript">



</script>


</body>
</html>
