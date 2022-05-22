<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" /> 
    <link rel="stylesheet" href="style.css" /> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title>Forum Cucina</title>
</head>
<body>
    <form action="" method="POST" ENCTYPE="multipart/form-data">

    <div class="header">
        <a class="btn btn-primary btn-lg" href="../profilo/profilo.php" role="button">
            Profilo Utente
        </a>
        <h1> Game of Fork </h1>   
    </div>

    <div class="sinistra" style="float: left; text-align: justify; width:20%;">
        <nav> 
            <ul>
                <li><a href="#"> FORUM  <i class="bi bi-caret-down-fill" style="float:right"> </i></a>
                    
                    <ul>
                        <li><a href="#"> Partecipa ad una conversazione</a></li>
                        <li><a href="#"> Inizia una chat </a></li>
                    </ul>
                </li>
                <li><a href="#"> Home </a></li>
                <li><a href="#"> Antipasti <i class="bi bi-caret-down-fill" style="float:right"> </i></a>
                    <ul>
                        <li><a href="#">Freddi</a></li>
                        <li><a href="#"> Caldi </a></li>
                    </ul>
                </li>
                <li><a href="#"> Primi </a></li>
                <li><a href="#"> Secondi <i class="bi bi-caret-down-fill" style="float:right"> </i></a>
                    <ul>
                    <li><a href="#">Freddi</a></li>
                    <li><a href="#"> Caldi </a></li>
                    </ul>
                </li>
                <li><a href="#"> Contorni </a></li>
                <li><a href="#"> Dolci </a></li>
                <li><a href="#"> Chi Siamo </a></li>
                <li><a href="#"> Crea Ricetta </a></li>
            </ul>
        </nav>

    </div>

    <div class="destra" style="float: right; text-align: justify; width: 70%;">
    <?php
        session_start();
        $email = $_SESSION['username'];
        

        $dbconn = pg_connect("host=localhost dbname=registrazione port=5432 user=donia password=diag")
                     or die( 'Could not connect: ' . pg_last_error());
       
       
       ?>


       <h2> 
            <?php
                $nomer = $_GET['name'];
                echo "$nomer";
            ?>   
        </h2>  


    

       <?php
            $uploaded=false;
            $save_path='';

            $q2 = 'SELECT * from fotoricette where added_by = $1';
            $result = pg_query_params($dbconn, $q2, array($nomer));
            $line2=pg_fetch_array($result, null, PGSQL_ASSOC);
                    
            $id = $line2['id'];
            $save_path = "images/".$nomer.".jpeg";
                    
                        
            $q3=  'SELECT * from get_image($1)';
            $res = pg_query_params($dbconn, $q3, array($id));

            if($res){

                $img = pg_fetch_object($res);
                $imgdata =$img->imgdata;
                $imgdata = substr($imgdata, 2);
                $bin = hex2bin($imgdata);
                file_put_contents($save_path,base64_decode($bin));

            }  
            ?>
                        
            <div>
            <img  class="cibo" src="<?php 
            echo $save_path;
            ?>">
            </div>
                        
       
       
       
       
       <br>Autore
       <?php

            $q1 = 'SELECT * from ricetta where nomer = $1';
            $result1 = pg_query_params($dbconn, $q1, array($nomer));
            $line=pg_fetch_array($result1, null, PGSQL_ASSOC);
    
            $utente = $line['utente'];
            echo "$utente";
        ?>
       <br>
       <br>
       <br>
       Ingredienti
       <div class="box">
           <?php
                 $ingredienti = $line['ingredienti'];
                 echo "$ingredienti" ;
           ?>
          
           <br>
           
           <br>
           
           <br>
           
       </div>
       
       <br> 
     
       <div class="des">

             Descrizione
            <?php
                 $descrizione = $line['procedimento'];
                 echo "$descrizione";
            ?>
    
        
       </div>

       Commenti
       <div class="com">
        Alessia: Bravissima Anna
        <br>
        Luca: Che schifo la cipolla
        <br>
        Arianna: Luca cambia ricetta!!
        <br>
        Stella: Concordo con Luca :)
        
    </div>


       
    </div>
    
</body>
</html>