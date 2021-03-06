<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" /> 
    <link rel="stylesheet" href="style.css" /> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="application/javascript" src="../bootstrap/js/bootstrap.min.js"></script> 
    <title>Forum Cucina</title>

    <script type="text/javascript">
        $(document).ready(function(){
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
    <form action="" method="POST" ENCTYPE="multipart/form-data">
    <?php
        session_start();
        $uploaded=false;
        $save_path='';

        if (!isset($_SESSION['username'])) {
            header('Location:login.php');
            exit;
        }

        $dbconn = pg_connect("host=localhost dbname=forum port=5432 user=postgres password=Stella")
            or die( 'Could not connect: ' . pg_last_error());
        
    ?>

    <div class="header">
        <button class="btn btn-primary" name="logoutBtn">Logout</button>
        
        <li><a href="../home/home.php"> <img class="tastohome" src="../immagini/tastohome.jpg"></a></li>
        <h1> Game of Fork </h1>   
    </div>
    <?php
        if(isset($_POST['logoutBtn'])){
            unset($_SESSION['username']);
            
            session_destroy(); 
            header("Location: ../paginainiziale/index.html"); 
        }
    ?>

    <div class="sinistra">
        <?php
            $save_path = 'images/images_2.jpg'; 
            if($dbconn){
                $email=$_SESSION['username'];
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
            <img  class="cibo" src="<?php echo $save_path; ?>">
        </div>
        
        <label class="label"> Nome Utente </label>
        <div class="pro">
            <?php
                $nome=$line['nome'];
                echo "$nome";
            ?>
        </div>
        <br>

        <label class="label"> Email </label>
        <div class="em">
            <?php
                echo "$email";
            ?>
        </div> 
        <br>           
        
        <label class="label"> Livello: 
        
            <?php
                $email=$_SESSION['username'];
                $q4=pg_query("SELECT SUM(likes) as l from ricetta where utente='$email'");
                $row=pg_fetch_assoc($q4);
                $sum=$row['l'];
                if ($sum>5) { echo 'Medio'; }
                else if ($sum>10) { echo 'Esperto'; }
                else { echo 'Principiante'; }
            ?>
        </label> 
        <br>
        <label class="label"> Numero Ricette: 
        
            <?php
                $email=$_SESSION['username'];
                $q5="SELECT * from ricetta where utente='$email'";
                $res=pg_query($q5);
                $count=pg_num_rows($res);
                echo $count;
            ?>
        </label>
    </div>
    

    <div class="contenitore">
        <ul id="griglia">
            <?php
                $uploaded=false;
                $save_path='';           
                $query = 'SELECT * from ricetta where utente = $1';    
                $result = pg_query_params($dbconn,$query,array($email));

                while($row=pg_fetch_assoc($result)){
                    $nomer=$row['nomer'];
                    $likes=$row['likes'];

                    $q6 = 'SELECT * from fotoricette where added_by = $1';
                    $result1 = pg_query_params($dbconn, $q6, array($nomer));
                    $line=pg_fetch_array($result1, null, PGSQL_ASSOC);
                
                    $id = $line['id'];
                    $save_path = "images/".$id.".jpg";
        
                    $q7=  'SELECT * from get_image($1)';
                    $res = pg_query_params($dbconn, $q7, array($id));

                    if($res){
                        $img = pg_fetch_object($res);
                        $imgdata =$img->imgdata;
                        $imgdata = substr($imgdata, 2);
                        $bin = hex2bin($imgdata);
                        file_put_contents($save_path,base64_decode($bin));
                    }  
        
                    echo "<li>";
                    echo "<a href='../ricetta/ricetta.php?name=$nomer'>"."<img  class='imgw200' src=" . $save_path .">"."<br>".$nomer. "</a>"."<br>";
                    echo "<div class=box> Like: ". $likes  ."</div> ";
                    echo "</li>";
                }
            ?>

<li> <a href="../ricette/form-ricette.html"> <img class="addImg" src="../immagini/plusar.png"> <br>Crea la tua ricetta</a> </li>
        </ul>
    </div>
</body>
</html>
