<?php
//upload
$uploaded=false;
$save_path='';
if(isset($_POST['retrieve']) && $_POST['retrieve']=='Retrieve'){
    $save_path='images\\images_2.jpeg';
    $conn=pg_connect('host=localhost port=5432 dbname=products user=postgres password=Stella');
        if($conn){
            $query= 'select * from getimage($1)';
            $res=pg_query_params($conn,$query,array(3));
            if($res){
                $img=pg_fetch_object($res);
                $imgdata=$img->imgdata;
                $imgdata=substr($imgdata,2);
                $bin=hex2bin($imgdata);
                file_put_contents($save_path,base64_decode($bin));
            }

}
}


if(isset($_POST['save']) && $_POST['save']=='Save'){
    $upload_dir=getcwd().DIRECTORY_SEPARATOR.'/uploads';
    if($_FILES['img']['error']==UPLOAD_ERR_OK){
        $temp_name=$_FILES['img']['tmp_name'];
        $name=basename($_FILES['img']['name']);
        $save_path=$upload_dir.$name;
        move_uploaded_file($temp_name,$save_path);
        $uploaded=true;
    }
    if($uploaded){
        $fh=fopen($save_path,'rb');
        $fbytes=fread($fh,filesize($save_path));

        //pg code
        $conn=pg_connect('host=localhost port=5432 dbname=products user=postgres password=Stella');
        if($conn){
            $query=" call save_product_photo($1,$2)";
            $res=pg_query_params($conn,$query,array(base64_encode($fbytes),'username'));
            if($res){
                echo 'saved'.strlen(base64_encode($fbytes));
                
            }
        }
    }
    

}

?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="img" />
            <input type="submit" name="save" value="Save" />
            <input type="submit" name="retrieve" value="Retrieve" />
        </form>   
            <div>
                <img  style='width:200px; height:200px;' src="<?php if(strlen($save_path)>0){
                    echo $save_path;
                }
                ?>"
            </div>

    </body>
</html>