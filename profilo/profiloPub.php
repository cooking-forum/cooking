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
        <form action="" method="POST" ENCTYPE="multipart/form-data">
        <?php
            session_start();
            $uploaded=false;
            $save_path='';
           


            $dbconn = pg_connect("host=localhost dbname=forum port=5432 user=postgres password=Stella")
                or die( 'Could not connect: ' . pg_last_error());
           
        ?>

        <div class="header">
            
            
            <li><a href="../home/home.php"> <img class="tastohome" src="../immagini/tastohome.jpg"></a></li>
            <h1> Game of Fork </h1>   
        </div>
        

        <div >
            <div class="sinistra" style="float: left; text-align: justify; width:50%;">
                
                <?php
                $save_path = 'images/images_2.jpg'; 
                if($dbconn){

                    $email=$_GET['name'];
                    $q1 = 'SELECT * from utente where email= $1';
                    $result = pg_query_params($dbconn, $q1, array($email));
                    $line=pg_fetch_array($result, null, PGSQL_ASSOC);

                    $q3 = 'SELECT * from fotoutenti where added_by = $1';
                    $result1 = pg_query_params($dbconn, $q3, array($email));
                    $line2=pg_fetch_array($result1, null, PGSQL_ASSOC);
                    
                    $id = $line2['id'];
                    
                      
                    $q2=  'SELECT * from getimage($1)';
                    $res = pg_query_params($dbconn, $q2, array($id));

                
                    

                    if($res){

                        $img = pg_fetch_object($res);
                        $imgdata =$img->imgdata;
                        $imgdata = substr($imgdata, 2);
                        $bin = hex2bin($imgdata);
                        file_put_contents($save_path, base64_decode($bin));



                    }
                }
                    

                    ?>
                
                
                <div>
                <img  style='width:200px; height:200px;' src="<?php 
                echo $save_path;
                ?>">
            </div>
            
                <br> 
                Nome Utente:
                <div class="pro">
                    
                    <?php
                        $nome=$line['nome'];
                        echo "$nome";
                    ?>
                    <br>
                </div>
                <br>
                Email:
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
            Livello: 
                <?php
                     $email=$_SESSION['username'];
                     $q4=pg_query("SELECT SUM(likes) as l from ricetta where utente='$email'");
                     $row=pg_fetch_assoc($q4);
                     $sum=$row['l'];
                     if($sum>5){
                         echo 'Medio';
                     }else if($sum>10){
                         echo 'Esperto';
                     }else{
                         echo 'Principiante';
                     }
                ?>
                <br>
                Numero Ricette: 

                <?php
                $email=$_SESSION['username'];
                $q5="SELECT * from ricetta where utente='$email'";
                $res=pg_query($q5);
                $count=pg_num_rows($res);
                echo $count;

                ?>
            </div>
        </div>
    

        <div class="container" >
            <ul id="griglia">





            <?php

            $uploaded=false;
            $save_path='';           

                
                $query = 'SELECT * from ricetta where utente = $1';    
                $result = pg_query_params($dbconn,$query,array($email));

                    while($row=pg_fetch_assoc($result)){
                        
                    
                        $nomer=$row['nomer'];

                        $q4 = 'SELECT * from fotoricette where added_by = $1';
                        $result1 = pg_query_params($dbconn, $q4, array($nomer));
                        $line=pg_fetch_array($result1, null, PGSQL_ASSOC);
                    
                        $id = $line['id'];
                        $save_path = "images/".$nomer.".jpg";
                    
                    
                      
                        $q5=  'SELECT * from get_image($1)';
                        $res = pg_query_params($dbconn, $q5, array($id));

                
                    

                        if($res){

                            $img = pg_fetch_object($res);
                            $imgdata =$img->imgdata;
                            $imgdata = substr($imgdata, 2);
                            $bin = hex2bin($imgdata);
                            file_put_contents($save_path,base64_decode($bin));

                        }  
                        
            
                        echo "<li>"."<a href='../ricetta/ricetta.php?name=$nomer'>"."<img  class='imgw200' src=".$save_path.">"."<br>".$nomer."</a>"."</li>";
                       
                   
                    }
                
                    

                ?>






            </ul>

        </div>
    
    

    </body>
</html>