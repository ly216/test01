<?php
/**
 * Created by PhpStorm.
 * User: liuyuxin
 * Date: 2017/10/15
 * Time: 下午5:16
 */
$servername='localhost';
$username='root';
$password='Ttt246810';
$dbuser='shop';
if($_POST) {
# connect to the database
    $input_name = htmlspecialchars($_POST['update_name']);
    $input_id = htmlspecialchars($_POST['update_id']);
    try {

        $DBH = new PDO("mysql:host=$servername;dbname=shop", $username, $password);

        $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        # UH-OH! Typed DELECT instead of SELECT!
        //echo "connect done";
    } catch (PDOException $e) {
        echo "I'm sorry, Dave. I'm afraid I can't do that.";
        file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
    }
    $cata_id = $DBH->prepare("SELECT catid FROM categories ");// echo "00";
    $cata_id->execute();
    $findit = 1;
    //echo "22";
    while ($result = $cata_id->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
        if ($result['catid']) $findit++;
        if ($input_id == $result['catid']) {
            $findit = 0;
            break;
        }
    }
    if ($findit != 0) {
        echo "Fail:Invalid categories ID input";
    }
else {
    $sql = "UPDATE categories SET name='$input_name' WHERE catid=$input_id";
    $DBH->exec($sql);
    echo "Update the categories name: done!";
}
}
echo "<br/>";
echo "Click <a href='/categories_mng.php'>Here </a> to go back.";