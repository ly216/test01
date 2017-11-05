<?php
/**
 * Created by PhpStorm.
 * User: liuyuxin
 * Date: 2017/11/5
 * Time: 下午11:02
 */
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

$the_id=intval($_GET['q']);
$prod_list = $DBH->prepare("SELECT * FROM products WHERE pid");
$prod_list->execute();
while ($result = $prod_list->fetch(PDO::FETCH_ASSOC))
{
    if($result['pid']==$the_id)
    {
        $myObj[$result['name']]=$result['price'];
        $myObj[$_GET['q']]=$_GET['qnt'];
        echo json_encode($myObj);
        break;
    }
}
?>