<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" /> 
    <link rel="stylesheet" href="style.css" /> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="application/javascript" src="../bootstrap/js/bootstrap.min.js"></script> 
    <title>Forum Cucina</title>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#in").mouseenter(function(){
                $("#in").css("background-color", "rgb(243, 151, 75)");
                $("#in").css("border-color", "rgb(231, 123, 34)");
                $("#in").css("color", "#000000");

             });
             $("#in").mouseleave(function(){
                 $("#in").css("background-color", "rgb(245, 198, 179)");
                
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

        if(isset($_POST['DeleteBtn'])){
            ?>
            <script type="text/javascript">
            var ris2 = confirm ("Sicuro di voler cancellare la ricetta?");
            if(ris2 === true)
            {
                location.href = '../home/home.php';
            }
            else
            {
                location.href = 'ricetta.php';
            }
    </script>
            <?php
            $email=$_SESSION["username"];
            $nomer = $_GET['name'];
            $que="SELECT * from ricetta where utente=$1 and nomer=$2";
            $resu=pg_query_params($dbconn, $que, array($email,$nomer));

            if($line1=pg_fetch_array($resu, null, PGSQL_ASSOC)) {
                $eliminar= "DELETE FROM ricetta where nomer = '$nomer'";
                $r4=pg_query($eliminar);
                $eliminaf= "DELETE FROM fotoricette where added_by = '$nomer'";
                $r5=pg_query($eliminaf);
            }           
            
        }
    ?>

    <form action="" method="POST" ENCTYPE="multipart/form-data">

        <div class="header">
            <a class="btn" href="../profilo/profilo.php" role="button">
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
                    <li><a href="#"> Chi Siamo </a></li>
                    <li><a href="../ricette/form-ricette.html"> Crea Ricetta </a></li>
                </ul>
            </nav>
        </div>

        <div class="destra">
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
                    $save_path = "images/".$id.".jpg";
                            
                                
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
                        
            <div class="fb">
                <img  class="cibo" src="<?php echo $save_path; ?>">
                <br>
                <?php 
                $email=$_SESSION["username"];
                $nomer = $_GET['name'];
                $q="SELECT * from likes where utente=$1 and ricetta=$2 ";
                $r=pg_query_params($dbconn, $q, array($email,$nomer));
                if($line=pg_fetch_array($r, null, PGSQL_ASSOC)) {
                    echo "<button  class='button' id='but' name='likeButton' > <i class='bi bi-chat-left-heart-fill'></i> MI PIACE </button>";
                }
                else{
                    echo  "<button  class='button' id='but' name='likeButton' > <i class='bi bi-chat-left-heart'></i> Lascia un mi piace se ti è piaciuta la ricetta </button>";
                }
                

            ?>

            </div>
           
           
           
            <div class="littleBox">
                <h3> Autore </h3>
                <div class="box">
                    <?php
                        $q1 = 'SELECT * from ricetta where nomer = $1';
                        $result1 = pg_query_params($dbconn, $q1, array($nomer));
                        $line=pg_fetch_array($result1, null, PGSQL_ASSOC);
                        $utente = $line['utente'];
                        echo "<li>"."<a href='../profilo/profiloPub.php?name=$utente'>".$utente."</a>"."</li>";


                    ?>
                </div>
                <div>
                <?php 
                if($utente==$email){
                            echo "<button class='bot' name='DeleteBtn'> Elimina Ricetta</button>";
                         }
                ?>
                </div>
                
                <h3> Tempo di preparazione </h3>
                <div class="box">
                    <?php
                        $tempoP = $line['tempoP'];
                        echo "$tempoP" ;
                    ?>
                </div>

                <h3> Ingredienti </h3>
            <div class="box">
                <?php
                    $ingredienti = $line['ingredienti'];
                    echo "$ingredienti" ;
                ?>
            </div>
            </div>



            

            
           
            <br>
            <h3> Descrizione </h3>
            <div class="des">   
                <?php
                    $descrizione = $line['procedimento'];
                    echo "$descrizione";
                ?> 
            </div>

            

           

            <div class="comm" >
                <h3> Commenti </h3>
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
                                        }
                                    }
                                    else { echo "<div class='nessuno'> Nessuno ha commentato la ricetta </div>"; }                  
                                ?>
                            </div>
                        </div>
                        <br>
                        <input class="areatesto " type="text" name="inputText"style="float: center; " placeholder="Inizia una conversazione" />
                        <input class="bottone" id="in" type="submit" name="invia" value="Invia"  class="bi bi-send-fill"   /> 
                    </div>
                </form>
            </div> 

        </div>

        
    </form>

   
</body>
</html>