<?php
/**
 * Created by PhpStorm.
 * User: liuyuxin
 * Date: 2017/10/22
 * Time: 下午5:02
 */

if($get_cat_id!="")
{
    $new_cat_id=intval($get_cat_id);
    $do_update_cat_id=$DBH->prepare("UPDATE products SET cat_id=$new_cat_id WHERE pid=$get_prod_id");
    $do_update_cat_id->execute();
}
if($get_prod_name!="")
{
    $do_update_name=$DBH->prepare("UPDATE products SET name='$get_prod_name' WHERE pid=$get_prod_id");
    $do_update_name->execute();
}
if($get_prod_price!=""){
    $new_prod_price=intval($get_prod_price);
    $do_update_price=$DBH->prepare("UPDATE products SET price=$new_prod_price WHERE pid=$get_prod_id");
    $do_update_price->execute();
}
if($get_prod_description!="")
{
    $do_update_description=$DBH->prepare("UPDATE products SET description='$get_prod_description' WHERE pid=$get_prod_id");
    $do_update_description->execute();
}
if($get_prod_img_name!="")
{
    //delete the old image on server;
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

    //add a new image;
    $target_file="image/";
    $is_valid_image=1;
    if(isset($_FILES['new_prod_image'])) {
        $uploaddir = '/var/www/html/image/';
        $uploadfile = $uploaddir . basename($_FILES['new_prod_image']['name']);
        $target_file="image/".basename($_FILES['new_prod_image']['name']);
        //echo "type: ".$_FILES['new_prod_image']['type'];

        $file_ext=strtolower(end(explode('.',$_FILES['new_prod_image']['name'])));
        $expensions= array("jpeg","jpg","png");
        if(in_array($file_ext,$expensions)=== false){
            $is_valid_image=0;
            echo "Invalid image: please upload jpg,jpeg or png image"."<br/>";
        }
        else {
            echo '<pre>';
            if (move_uploaded_file($_FILES['new_prod_image']['tmp_name'], $uploadfile)) {
                echo "File is valid, and was successfully uploaded.\n";
            } else {
                echo "Possible file upload attack!\n";
            }

            // echo 'Here is some more debugging info:';
            //print_r($_FILES);

            print "</pre>";
        }
    }

    //add to the product table
    if($is_valid_image) {
        $new_link = "image/".$get_prod_img_name;
        $do_update_img_link = $DBH->prepare("UPDATE products SET image_link='$new_link' WHERE pid=$get_prod_id");
        $do_update_img_link->execute();
    }
    else{
        echo "Updating image failed: only jpg. jpeg. and png. are allwed!";
    }
}