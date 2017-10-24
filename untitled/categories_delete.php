<?php
$servername='localhost';
$username='root';
$password='Ttt246810';
$dbuser='shop';
if($_POST) {
# connect to the database
    $input_name = htmlspecialchars($_POST['delete_name']);
    //$input_name=$_POST['delete_name'];
    try {

        $DBH = new PDO("mysql:host=$servername;dbname=shop", $username, $password);

        $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        # UH-OH! Typed DELECT instead of SELECT!
        //echo "connect done";
    } catch (PDOException $e) {
        echo "I'm sorry, Dave. I'm afraid I can't do that.";
        file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
    }

   // echo $input_name;
    $delete_exe ="DELETE FROM categories WHERE name='$input_name'";//echo "33";
    $DBH->exec($delete_exe);

    echo "Delete the categories: ".$input_name." done"."<br/>";
}
echo "Click <a href='/categories_mng.php'>Here </a> to go back.";
    ?>