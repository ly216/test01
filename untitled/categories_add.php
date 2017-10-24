<?php
/**
 * Created by PhpStorm.
 * User: liuyuxin
 * Date: 2017/10/15
 * Time: 下午6:33
 */

$servername='localhost';
$username='root';
$password='Ttt246810';
$dbuser='shop';
if($_POST) {
# connect to the database
    $input_name = htmlspecialchars($_POST['new_cata_name']);
    //echo $input_name;
    try {

        $DBH = new PDO("mysql:host=$servername;dbname=shop", $username, $password);
        $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        # UH-OH! Typed DELECT instead of SELECT!





       } catch (PDOException $e) {
        echo "I'm sorry, Dave. I'm afraid I can't do that.";
        file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
    }


    $cata_name = $DBH->prepare("SELECT * FROM categories ");// echo "00";
    $cata_name->execute();
    //echo "11";
    $findit = 0;
    $new_id=100;
    //echo "22";
    while ($result = $cata_name->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];
        if ($result['name']) $findit++;
        if ($input_name == $result['name']) {
            $findit = 0;
            break;
        }
    }
    $dd=0;
    $cata_namei = $DBH->prepare("SELECT * FROM categories ");// echo "00";
    $cata_namei->execute();
    while ($resulti = $cata_namei->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];

        if($new_id!=$resulti['catid']) {
            $dd=1;
            break;
        }
        //echo "lala: ".$resulti['catid'];
        $new_id++;
    }
    //if($dd==0) $new_id++;
    if ($findit == 0) {
        echo "Fail:Already existing in the table.";
    } else {/*
        $sql = "SELECT COUNT(*) FROM categories";
        $res = $DBH->query($sql);
        $findit = $res->fetchColumn();
        $new_id = intval($findit + 100);*/
        //echo "\nsize: ".$findit;
        echo "new id: " . $new_id . "<br/>";
        $do_add = "INSERT INTO categories (catid,name) VALUES ($new_id,'$input_name') ";
        $DBH->exec($do_add);
        //$do_add->execute();
        echo "Add done!"."<br/>";
    }
}
echo "Click <a href='/categories_mng.php'>Here </a> to go back.";