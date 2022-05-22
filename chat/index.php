<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" /> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="chat.js"></script>
</head>
<body>


     <?php
       $dbconn = pg_connect("host=localhost dbname=forum port=5432 user=postgres password=Stella")
       or die( 'Could not connect: ' . pg_last_error());
       $testo='';
      $utente='';
      session_start();
      if(isset($_POST["invia"] ) ) {
        $email=$_SESSION["username"];
        $testo = $_POST["inputText"] ;
        $q1 = "SELECT * from chat where testo= $2 and utente=$1";
        $res = pg_query_params($dbconn, $q1, array($email,$testo));
       
        $q2 = "INSERT INTO chat values($1,$2)";
        $data = pg_query_params($dbconn, $q2, array($email,$testo) ) ;
      
  }
?>


    <div class="header">
        <a class="btn btn-primary btn-lg" href="../profilo/profilo.php" role="button">
            Profilo Utente
        </a>
        <h1> Game of Fork </h1>   
    </div>

  <div class="sinistra" style="float: left; text-align: justify; width:20%;">

  <form class="modulo-ricerca" action="cerca.php" style="margin-left: 100px;">
            <input id="search" type="text" placeholder="Cerca una ricetta..." required>
            <input id="submit" type="submit" value="CERCA">
          </form>
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
                <li><a href="#"> Crea Ricetta </a></li>
            </ul>
        </nav>
  </div>


 <div class="destra"  style="float:right; text-align: justify; width:60%;">
     <form action="" method="post" name="myForm" onSubmit="return validaForm()">
       <div class="sc">
            
          BENVENUTO O BENTORNATO NEL FORUM
           <div class="container">
             <div class="tabella2">
              
              <?php
               $db = pg_connect("host=localhost dbname=forum port=5432 user=postgres password=Stella")
               or die( 'Could not connect: ' . pg_last_error());
               $result = pg_query($db,"SELECT * FROM chat");
               $email=$_SESSION["username"];
               
               while($row=pg_fetch_assoc($result)){
                   if($email==$row['utente']){
                    echo "<div class='loggato' >" ."<div class='nome'>". $row['utente']."</div>"."<div class='mess1'>". $row['testo']."</div>". "</div>";
                    echo "<br>";
                   }else{
                 
                 //echo "<tr>";
                 echo "<div class='utente' >" ."<div class='nome'>". $row['utente']."</div>"."<div class='mess2'>". $row['testo']."</div>". "</div>";
                echo "<br>";
              }
            
            }
                                
              ?>
              </div>
            </div>
<br>
<br>

<input class="areatesto " type="text" name="inputText"style="float: center; " placeholder="Inizia una conversazione" />
<input  class="bottone" type="submit" name="invia" value="Invia"  class="bi bi-send-fill" /> 
           
     

     <br>
     <br>
     

</form>
</div>  
            </div> 
      
</body>
</html>