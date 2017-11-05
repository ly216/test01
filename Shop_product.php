<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Liu Yuxin's Shop</title>
    <link href="CSS_host.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="shop_list.js"></script>

</head>

<body onload="upload_page()">
<table class="home_title"> <tr><td> <p style="font-size:30px;color:#FF0">   welcomme to Yuxin's Shop </p> </td><td>


        </td></tr></table>

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
                echo ">>   "."<a href='#'>".$_GET['name_qury']."</a>";
            }
            ?>

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

<table class="home_product_main" id="product_table_main"  >
    <tr height="250">
        <td width="70%" >
            <img src=<?php echo $_GET['img_link_qury']; ?> height='70%' width="80%">
        </td>
        <td width="30%">
            Name: <?php echo $_GET['name_qury']?>
            <br/><br/>
            Price: <?php echo $_GET['price_qury']?>
        </td>
    </tr>
    <tr height="50">
        <td width="70%" >
            <strong>Description</strong><br/>
            <?php echo $_GET['Description']?>
        </td>
        <td width="30%">
           <input type="button" onclick='add_to_cart(<?php echo $_GET['prod_id']; ?>)' value="Add to cart"/>
        </td>
    </tr>
</table>
</body>

</html>