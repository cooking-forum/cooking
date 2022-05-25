<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" /> 
    <link rel="stylesheet" href="style.css" /> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="main.js"></script>
    <title>Forum Cucina</title>
</head>
<body>

<?php
       $dbconn = pg_connect("host=localhost dbname=forum port=5432 user=postgres password=Stella")
       or die( 'Could not connect: ' . pg_last_error());
       $commento='';
      $utente='';
      session_start();
      if(isset($_POST["invia"] ) ) {
        $email=$_SESSION["username"];
        $commento = $_POST["inputText"] ;
        $nomer = $_GET['name'];
        $q1 = "SELECT * from commenti where commento= $2 and utente=$1";
        $res = pg_query_params($dbconn, $q1, array($email,$commento));
       
        $q2 = "INSERT INTO commenti values($1,$2,$3)";
        $data = pg_query_params($dbconn, $q2, array($nomer,$email,$commento) ) ;
      
  }

     if(isset($_POST['likeButton'])){
        $email=$_SESSION["username"];
        $nomer = $_GET['name'];
        $query="SELECT * from likes where utente=$1 and ricetta=$2 ";
        $result=pg_query_params($dbconn, $query, array($email,$nomer));

        if($line=pg_fetch_array($result, null, PGSQL_ASSOC)) {
            
    
            $elimina= "DELETE FROM likes where ricetta ='$nomer'";
            $r1=pg_query($elimina);
            $decr="UPDATE ricetta SET likes=likes-1 where nomer='$nomer' ";
           
            $r2=pg_query($decr);
            
     }
       else {
        
           $inserisci='INSERT into likes values ($1,$2)' ;
           $data = pg_query_params($dbconn, $inserisci, array($email,$nomer) ) ;
           $incr="UPDATE ricetta SET likes=likes+1 where nomer='$nomer'";
           $r3=pg_query($incr);
           
           
           
       }
    }

?>



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
                <li><a href="#"> FORUM <i class="bi bi-caret-down-fill" style="float:right"> </i></a>
                    <ul>
                        <li><a href="#"> Partecipa ad una conversazione</a></li>
                        <li><a href="../chat/index.php"> Inizia una chat </a></li>
                    </ul>
                </li>
                <li><a href="#"> Home </a></li>
                <li><a href="#"> Cosa vuoi cucinare? <i class="bi bi-caret-down-fill" style="float:right"> </i></a>
                    <ul>
                        <li><a href="#"> Antipasti </a></li>
                        <li><a href="#"> Primi </a></li>
                        <li><a href="#"> Secondi </a></li>
                        <li><a href="#"> Contorni </a></li>
                        <li><a href="#"> Dolci </a></li>
                    </ul>
               
                <li><a href="#"> Chi Siamo </a></li>
                <li><a href="../ricette/form-ricette.html"> Crea Ricetta </a></li>
            </ul>
        </nav>
        
    </div>

    <div class="destra" style="float: right; text-align: justify; width: 70%;">
    


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
           
           
            <br>
            <?php 
             $email=$_SESSION["username"];
             $nomer = $_GET['name'];
            $q="SELECT * from likes where utente=$1 and ricetta=$2 ";
            $r=pg_query_params($dbconn, $q, array($email,$nomer));
            if($line=pg_fetch_array($r, null, PGSQL_ASSOC)) {
            echo "<button  class='button' id='but' name='likeButton' > <i class='bi bi-chat-left-heart-fill'></i> MI PIACE </button>";
            }else{
              echo  "<button  class='button' id='but' name='likeButton' > <i class='bi bi-chat-left-heart'></i> Lascia un mi piace se ti è piaciuta la ricetta </button>";
           
            }
            ?>
                        
       
       
       
       
       <br>Autore
       <div class="box">
       <?php

            $q1 = 'SELECT * from ricetta where nomer = $1';
            $result1 = pg_query_params($dbconn, $q1, array($nomer));
            $line=pg_fetch_array($result1, null, PGSQL_ASSOC);
    
            $utente = $line['utente'];
            echo "$utente";
        ?>
       </div>
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
       Descrizione
       <div class="des">

            
            <?php
                 $descrizione = $line['procedimento'];
                 echo "$descrizione";
            ?>
    
        
       </div>

       <div class="comm" >
            COMMENTI
            <form action="" method="post" name="myForm" onSubmit="return func()" hidden>
     
                <div class="sc">
               <div class="con">
            <div class="tabella2">
              
              <?php
               
               $nomer = $_GET['name'];
               $result = pg_query($dbconn,"SELECT utente,commento FROM commenti where (ricetta LIKE '$nomer')");
               $email=$_SESSION["username"];
               $trovati=pg_num_rows($result);
               if($trovati>0){

               while($row=pg_fetch_assoc($result)){
                
                 echo "<div class='utente' style='float:left; margin-left:30px;'>" . $row['utente']."  :  ". $row['commento']."</div>";
                echo '<br>';
                echo '<br>';
              }
            }
              else{
                  echo "Nessuno ha commentato la ricetta";
              }
              
            
                                
              ?>
              </div>
              </div>

              <br>

              <input class="areatesto " type="text" name="inputText"style="float: center; " placeholder="Inizia una conversazione" />
              <input  class="bottone" type="submit" name="invia" value="Invia"  class="bi bi-send-fill"   /> 
              <br>
              <br>
    </form>
</div>  
</div>
    
</body>
</html>