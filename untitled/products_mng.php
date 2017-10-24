
/**
 * Created by PhpStorm.
 * User: liuyuxin
 * Date: 2017/10/16
 * Time: 下午9:38
 */
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories management </title>
</head>
<body>
<fieldset>
    <legend>Products ADD</legend>
    <form id="products_add" method="POST" action="products_add.php" enctype="multipart/form-data" >
        <label for="products_add_input">Select a categories *</label>
        <div><!--<select id="cate_delete_input"  name="delete_name"  >  -->
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
            $cata_name = $DBH->prepare("SELECT name FROM categories ");// echo "00";
            $cata_name->execute();
            $counter=0;
            $name_list=array();
            while ($result = $cata_name->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
                // echo "<option value=$result['name']>$result['name']</option>";
                //echo $result['name'];
                array_push($name_list,$result['name']);
            }
            ?>
            <select id="products_add_input"  name="select_categories"  >
                <?php
                $i=0;
                while($i<count($name_list)){
                    echo "<option value=".$name_list[$i].">".$name_list[$i]."</option>";
                    $i++;
                }
                ?>

            </select>
        </div>
            <label for="products_add_name">New Product Name *</label>
            <div><input id="products_add_name" type="text" name="new_prod_name" required="true"   /></div>
            <label for="products_add_price">Price in HK dolars *</label>
            <div><input id="products_add_price" type="text" name="new_prod_price" required="true"  pattern="^[+-]?([0-9]*\.?[0-9]+|[0-9]+\.?[0-9]*)([eE][+-]?[0-9]+)?$" />
        </div>
        <label for="products_add_image">Upload a image for new product *</label>
        <div><input type="file" id="new_prod_image"  name="new_prod_image" required="true" enctype="multipart/form-data"  />Only jpg. jpeg. or png. <=2M</div>
            <label for="products_add_description">Descrition * </label>
        <div><textarea id="products_add_description"  name="new_prod_description" required="true" rows="20" cols="80"></textarea></div>

        <input type="submit" value="ADD"/>
    </form>
</fieldset>
<fieldset>
    <legend>Products ID Search for Deleting or Updating</legend>
    <form id="product_delete" method="POST" action="" enctype="multipart/form-data" >
        <label for="products_add_input">Select a category whose product deleted:*</label>
        <div><!--<select id="cate_delete_input"  name="delete_name"  >  -->
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
            $cata_name = $DBH->prepare("SELECT name FROM categories ");// echo "00";
            $cata_name->execute();
            $counter=0;
            $name_list=array();
            while ($result = $cata_name->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
                // echo "<option value=$result['name']>$result['name']</option>";
                //echo $result['name'];
                array_push($name_list,$result['name']);
            }
            ?>
            <select id="products_delete_input"  name="select_categories2"  >
                <?php
                $i=0;
                while($i<count($name_list)){
                    echo "<option value=".$name_list[$i].">".$name_list[$i]."</option>";
                    $i++;
                }
                ?>

            </select>
        </div>
        <div>  <input type="submit" value="show products"></div>
        <div>
        <?php
            if($_POST["select_categories2"]) {
                $get_cata_name=$_POST['select_categories2'];
                echo "<table style='border: solid 1px black'>";
                echo "<tr><th> pid </th><th> catid </th><th> price </th><th> name </th></tr>";

                class TableRows extends RecursiveIteratorIterator
                {
                    function __construct($it)
                    {
                        parent::__construct($it, self::LEAVES_ONLY);
                    }

                    function current()
                    {
                        return "<td style='width:150px;border:1px solid black;'>" . parent::current() . "</td>";
                    }

                    function beginChildren()
                    {
                        echo "<tr>";
                    }

                    function endChildren()
                    {
                        echo "</tr>" . "\n";
                    }
                }
                $servername='localhost';
                $username='root';
                $password='Ttt246810';
                $dbuser='shop';
                $conn = new PDO("mysql:host=$servername;dbname=shop", $username, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $catName_=$_POST['select_categories2'];
                $cata_name3 = $conn->prepare("SELECT * FROM categories ");// echo "00";
                $cata_name3->execute();
                $catid_="null";
                while ($result3 = $cata_name3->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
                    echo $result3['name'];
                    if ($result3['name']==$get_cata_name) {
                        $catid_=$result3['catid'];
                        break;
                    }
                }

               // echo $catid_;
                $stmt = $conn->prepare("SELECT pid,catid,price,name FROM products WHERE catid=$catid_");$stmt->execute();
                $result3 = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
                    echo $v;}
                $conn = null;
                echo "</table>";
            }//end post
            ?>
        </div>
    </form>
</fieldset>
<fieldset>
    <legend> Product Delete</legend>
     <form id="do_product_delete" name="do_product_delete" action="products_delete.php" enctype="multipart/form-data" method="POST">
         <label for="deleted_id"> Input the product ID to delete</label>
         <div>
           <input id="deleted_id" required="true" name="deleted_id" pattern="^[1-9]\d*$"/>
             <input type="submit" value="delete"/>
       </div>
     </form>
</fieldset>

<fieldset>
    <legend> Product Update</legend>
        <form id="do_product_update" name="do_product_update" action="products_update.php" enctype="multipart/form-data" method="POST">
            <label for="update_product_id"> Input the product ID to update</label>
            <div>
                <input  id="update_product_id" required="true" name="update_product_id" pattern="^[1-9]\d*$" /></div>
            <label for="cate_update_input">Check the categories ID if you want: *</label>
            <div><!--<select id="cate_delete_input"  name="delete_name"  >  -->
                <?php
                $servername='localhost';
                $username='root';
                $password='Ttt246810';
                $dbuser='shop';
                try {

                    $DBH2 = new PDO("mysql:host=$servername;dbname=shop", $username, $password);
                    $DBH2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    //echo "connect done";
                } catch (PDOException $e) {
                    echo "I'm sorry, Dave. I'm afraid I can't do that.";
                    file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
                }
                $cata_name2 = $DBH2->prepare("SELECT * FROM categories ");// echo "00";
                $cata_name2->execute();
                $counter=0;
                $name_id_list=array();
                while ($result2 = $cata_name2->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
                    // echo "<option value=$result['name']>$result['name']</option>";
                    //echo $result['name'];
                    array_push($name_id_list,$result2['name']."-".$result2['catid']);
                }
                ?>
                <select id="cate_update_input"  name="update_name"  >
                    <?php
                    $i=0;
                    while($i<count($name_id_list)){
                        echo "<option value=".$name_id_list[$i].">".$name_id_list[$i]."</option>";
                        $i++;
                    }
                    ?>

                </select>
            </div>
            <label for="update_cat_id"> Might change the catetory ID: </label>
            <div>
                <input  id="update_cat_id" name="update_cat_id" pattern="^[1-9]\d*$" /></div>
            <label for="update_name"> Might change the product name: </label>
            <div>
                <input  id="update_name" name="update_name"  /></div>
            <label for="update_price"> Might change the product price: </label>
            <div>
                <input  id="update_price" name="update_price" pattern="^[0-9]+\.?[0-9]*$" /></div>
            <label for="update_description">Might change the product descrition * </label>
            <div><textarea id="update_description"  name="update_description"  rows="20" cols="80"></textarea></div>
            <label for="update_prod_image">Might reload a image for updating:</label>
            <div><input type="file" id="update_prod_image"  name="update_prod_image"  enctype="multipart/form-data"  />Only jpg. jpeg. or png. <=2M</div>
            <div>
                <input type="submit" value="update"/>
            </div>
        </form>
</fieldset>
</body>
</html>