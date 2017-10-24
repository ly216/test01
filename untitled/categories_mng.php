<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories management </title>
</head>
<body>
<fieldset>
    <legend>Categories ADD</legend>
    <form id="categories_add" method="POST" action="categories_add.php" >
        <label for="cate_add_input">New category name *</label>
        <div><input id="cate_add_input" type="text" name="new_cata_name" required="true"   />
        </div>
        <input type="submit" value="ADD"/>
    </form>
</fieldset>

<fieldset>
    <legend>Categories Delete</legend>
    <form id="categories_delete" method="POST" action="categories_delete.php" >
        <label for="cate_delete_input">Select one to delete *</label>
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
            <select id="cate_delete_input"  name="delete_name"  >
                <?php
                $i=0;
                while($i<count($name_list)){
                    echo "<option value=".$name_list[$i].">".$name_list[$i]."</option>";
                    $i++;
                }
                ?>

            </select>
        </div>
        <input type="submit" value="Delete"/>
    </form>
</fieldset>

<fieldset>
    <legend>Categories Update</legend>
    <form id="categories_update" method="POST" action="categories_update.php" >
        <label for="cate_update_input">Check the categories ID and name, then modify the name *</label>
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
        <div>
            <label for="cate_update_input">Input the Categories ID whose name you want to modify: *</label>
            <input id="cate_update_id" name="update_id" maxlength="3" minlength="3"/>
        </div>
        <div>
            <label for="cate_update_input">Input the name to update: *</label>
            <input id="cate_update_name" name="update_name" maxlength="20" />
        </div>
        <input type="submit" value="Update"/>
    </form>
</fieldset>
</body>
</html>