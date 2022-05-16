
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" /> 
    <link rel="stylesheet" href="style.css" /> 
    <title>Forum Cucina</title>
    </head>
    <body>
        <form action="" method="post" ENCTYPE="multipart/form-data">
        <?php
            session_start();
            $uploaded=false;
            $save_path='';

            


            if (!isset($_SESSION['username'])) {
                header('Location:login.php');
                exit;
            }


            $dbconn = pg_connect("host=localhost dbname=registrazione port=5432 user=donia password=diag")
                or die( 'Could not connect: ' . pg_last_error());
           
        ?>

        <div class="header">
            <button class="btn btn-primary btn-lg" name="logoutBtn">Logout</button>
            
            <li><a href="../home/index.html"> <img class="tastohome" src="immagini/tastohome.jpg"></a></li>
            <h1> Game of Fork </h1>   
        </div>
        <?php
            if(isset($_POST['logoutBtn'])){
                unset($_SESSION['username']);
                session_destroy(); 
                header("Location: ../index.html"); 
            }


        ?>

        <div >
            <div class="sinistra" style="float: left; text-align: justify; width:50%;">
                
                <?php
                $save_path = 'images\\images_2.jpeg'; 
                if($dbconn){
                    $email=$_SESSION['username'];
                    $q1 = 'SELECT * from utente where email= $1';
                    $result = pg_query_params($dbconn, $q1, array($email));
                    $line=pg_fetch_array($result, null, PGSQL_ASSOC);

                    $q3 = 'SELECT * from productphotos where added_by = $1';
                    $result1 = pg_query_params($dbconn, $q3, array($email));
                    $line2=pg_fetch_array($result1, null, PGSQL_ASSOC);
                    
                    $id = $line2['id'];

                      
                    $q2=  'SELECT * from getimage($2)';
                    $res = pg_query_params($dbconn, $q2, array($id));

                
                    

                    if($res){

                        $img = pg_fetch_object($res);
                        $imgdata =$img->imgdata;
                        $imgdata = substr($imgdata, 2);
                        $bin = hex2bin($imgdata);
                        file_put_contents($save_path,base64_decode($bin));



                    }
                }
                    

                    ?>
                
                
                <div>
                <img  style='width:200px; height:200px;' src="<?php if(strlen($save_path)>0){
                    echo $save_path;
                }
                ?>">
            </div>
            
                <br> 
                Nome Utente
                <div class="pro">
                    
                    <?php
                        $nome=$line['nome'];
                        echo "$nome";
                    ?>
                    <br>
                </div>
                <br>
                
                <div class="em">
                    <?php
                        
                        echo "$email";
                    ?>
                </div>
                <br>
                <br>
                <br>            
            </div>
            <br>
            <br>
            <div class="destra" style="float: right; text-align: justify; width: 40%;">
                
                <?php
                    $livello=$line['livello'];
                    echo "$livello";
                ?>
                <br>
                Numero Ricette
            </div>
        </div>
    

        <div class="container" >
            <ul id="griglia">
                <li ><a href="#"><img class="imgw200" src="../home/immagini/suppli.jpg" > <br>SUPPLI </a></li>
                <li> <a href="#"> <img  class="imgw200" src="../home/immagini/Lasagna.jpg" ><br>  LASAGNA </a></li>
                <li> <a href="#"> <img class="imgw200" src="../home/immagini/salmone-in-crosta.jpg" ><br> SALMONE IN CROSTA </a></li>
                <li> <a href="#"> <img class="imgw200" src="../home/immagini/Zucchine-ripiene.jpg" ><br>  ZUCCHINE RIPIENE</a></li>
                <li> <a href="#"> <img class="imgw200" src="../home/immagini/torta-ricotta-e-spinaci.jpg"><br>  TORTA RUSTICA </a></li> 
            </ul>

        </div>
    
    

    </body>
</html>