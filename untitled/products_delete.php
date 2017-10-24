<?php
/**
 * Created by PhpStorm.
 * User: liuyuxin
 * Date: 2017/10/21
 * Time: 下午1:14
 */
$servername='localhost';
$username='root';
$password='Ttt246810';
$dbuser='shop';
if($_POST['deleted_id'])
{
    try {

        $DBH = new PDO("mysql:host=$servername;dbname=shop", $username, $password);

        $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        # UH-OH! Typed DELECT instead of SELECT!
        //echo "connect done";
    } catch (PDOException $e) {
        echo "I'm sorry, Dave. I'm afraid I can't do that.";
        file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
    }



    $get_prod_id=intval($_POST['deleted_id']);
    $deleted_imge_link="";
    // echo $input_name;
    $cata_name = $DBH->prepare("SELECT * FROM products ");// echo "00";
    $cata_name->execute();

    while ($result = $cata_name->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];

        if ($get_prod_id == $result['pid']) {
          $deleted_imge_link=$result['image_link'];
            break;
        }
    }
    //echo "the deleted link: ".$deleted_imge_link;
    unlink("/var/www/html/".$deleted_imge_link);

    $delete_exe ="DELETE FROM products WHERE pid=$get_prod_id";//echo "33";
    $DBH->exec($delete_exe);

    echo "Delete the products, the deleted id is : ".$get_prod_id." done"."<br/>";

}
echo "Click <a href='/products_mng.php'>Here </a> to go back.";
?>