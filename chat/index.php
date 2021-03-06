<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" /> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <script src="chat.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="application/javascript" src="../bootstrap/js/bootstrap.min.js"></script> 
    <title>Forum Cucina</title>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $(".bottone").mouseenter(function(){
                $(".bottone").css("background-color", "rgb(243, 151, 75)");
             });
             $(".bottone").mouseleave(function(){
                 $(".bottone").css("background-color", "rgb(245, 198, 179)");
             });
             $(".btn").mouseenter(function(){
              $(".btn").css("background-color", "rgb(243, 151, 75)");
                $(".btn").css("border-color", "rgb(231, 123, 34)");
                $(".btn").css("color", "#000000");

             });
             $(".btn").mouseleave(function(){
                 $(".btn").css("background-color", "rgb(245, 198, 179)");
             });
             
             
        });
    </script>
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
    <a class="btn " href="../profilo/profilo.php" role="button">
      Profilo Utente
    </a>
    <h1> Game of Fork </h1>   
  </div>

  <div class="sinistra">
    <nav> 
      <ul>
        <li><a href="../chat/index.php"> FORUM </a>
          
        </li>
        <li><a href="../home/home.php"> Home </a></li>
        <li><a href="#"> Cosa vuoi cucinare? <i class="bi bi-caret-down-fill"> </i></a>
          <ul>
            <li><a href="../home/tipo.php?name=antipasti">Antipasti </a></li>
            <li><a href="../home/tipo.php?name=primi"> Primi </a></li>
            <li><a href="../home/tipo.php?name=secondi"> Secondi </a></li>
            <li><a href="../home/tipo.php?name=contorni"> Contorni </a></li>
            <li><a href="../home/tipo.php?name=dolci"> Dolci </a></li>
          </ul>
        <li><a href="../chisiamo/index.html"> Chi Siamo </a></li>
        <li><a href="../ricette/form-ricette.html"> Crea Ricetta </a></li>
      </ul>
    </nav>
  </div>

 <div class="destra">
    <form action="" method="post" name="myForm" onSubmit="return validaForm()">
      <div class="sc">
        BENVENUTO O BENTORNATO NEL FORUM
          <div class="contenitore">
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
                }
                else {
                  $utente=$row['utente'];
                  
                  echo "<div class='utente' >" ."<div class='nome'>". "<a href='../profilo/profiloPub.php?name=$utente'>".$utente."</a>"."</div>"."<div class='mess2'>". $row['testo']."</div>". "</div>";
                  echo "<br>";
                }
              }
            ?>
            </div>
          </div>
          <br>

          <input class="areatesto " type="text" name="inputText"  placeholder="Inizia una conversazione" />
          <input  class="bottone" type="submit" name="invia" value="Invia"  class="bi bi-send-fill" /> 

          <br>
          <br>
    </form>
  </div>  
</div> 
      
</body>
</html>