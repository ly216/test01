<?php
if($_POST){
    $uemail=$_POST['new_email'];
    $uname=$_POST['new_uname'];
    $upassword=$_POST['new_password'];
    $sure_password=$_POST['sure_password'];

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
    echo $uemail;
    $cata_name = $DBH->prepare("SELECT * FROM users  ORDER BY uid ASC ");
    $cata_name->execute();
    $find_email=0;
    $cata_name3 = $DBH->prepare("SELECT * FROM users ORDER BY uid ASC ");
    $cata_name3->execute();
    while ($result3=$cata_name3->fetch(PDO::FETCH_ASSOC))
    {
        echo $result3['uid'];
    }
    while ($result=$cata_name->fetch(PDO::FETCH_ASSOC))
    {
        if($uemail==$result['uemail'])
        {
            $find_email=1;
            break;
        }
    }
    if($find_email==1)
    {
        echo "you have already sing up with this email: ".$umail;
    }
    else if($upassword!=$sure_password)
    {
        echo "The passwords aren't comparable. Please confirm you passcord";
    }
    else
    {
        $new_uid=100000000;
        $cata_namei = $DBH->prepare("SELECT * FROM users ORDER BY uid ASC");// echo "00";
        $cata_namei->execute();
        while ($resulti = $cata_namei->fetch(PDO::FETCH_ASSOC)) { //echo $result['name'];

            if ($new_uid != $resulti['uid']) {
                break;
            }

            $new_uid++;
        }
        $usalt=mt_rand();

        //echo $upassword.stirng($uslat);
        $uhashcode=hash_hmac('sha1', $upassword, $usalt);
        $add_new_user=$DBH->prepare("INSERT INTO users (uid,uname,uemail,uhashcode,usalt,upiority) VALUES ($new_uid,'$uname','$uemail','$uhashcode',$usalt,2)");
        $add_new_user->execute();
        echo "You have created the account successfully!"."</br>";
        echo "<table>"."<tr>"."<td>"."e-mail: "."</td><td>".$uemail."</td>"."</tr>";
        echo "<tr>"."<td>"."User Name: "."</td><td>".$uname."</td></tr>";
        echo "<tr>"."<td>"."User ID: "."</td><td>".$new_uid."</td></tr>"."</table>";
    }
    echo "Click <a href='signUp.html'> here </a>to go back.";
    echo "Click <a href='Shop_host.php'> here </a>to go to host page.";
}
?>