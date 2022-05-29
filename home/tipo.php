<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" /> 
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" /> 
    <link rel="stylesheet" href="style.css" /> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="application/javascript" src="../bootstrap/js/bootstrap.min.js"></script> 
    <title>Forum Cucina</title>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $("#b").mouseenter(function(){
                $("#b").css("background-color", "rgb(243, 151, 75)");
             });
             $("#b").mouseleave(function(){
                 $("#b").css("background-color", "rgb(245, 198, 179)");
             });
             
        });
    </script>
</head>
<body >
    
   
  
    <div class="header">
        
        <a class="btn " id="b" name="profiloBtn" href="../profilo/profilo.php" role="button">
            Profilo Utente
        </a>
        <h1> Game of Fork </h1>   
    </div>
   

    <div class="sinistra" >
        <nav> 
            <ul>
                <li><a href="../chat/index.php"> FORUM </a></li>
                <li><a href="../home/home.php"> Home </a></li>
                <li><a href="#"> Cosa vuoi cucinare? <i class="bi bi-caret-down-fill" > </i></a>
                    <ul>
                        <li><a href="tipo.php?name=antipasti">Antipasti </a></li>
                        <li><a href="tipo.php?name=primi"> Primi </a></li>
                        <li><a href="tipo.php?name=secondi"> Secondi </a></li>
                        <li><a href="tipo.php?name=contorni"> Contorni </a></li>
                        <li><a href="tipo.php?name=dolci"> Dolci </a></li>
                    </ul>
               
                <li><a href="#"> Chi Siamo </a></li>
                <li><a href="../ricette/form-ricette.html"> Crea Ricetta </a></li>
            </ul>
        </nav>
        
    </div>


    <div class="ok" >
        <form class="modulo-ricerca" action="" method="post" >
            <input id="search" type="text" name="inputTesto" placeholder="Cerca una ricetta..." required>
            <input id="submit" type="submit" name="researchButton" value="CERCA">
    </form>
   <!-- <form action="" method="POST" ENCTYPE="multipart/form-data"> -->
    <div id="contenitore" >
       <ul id="griglia">


           
           <?php

                session_start();
                $email = $_SESSION['username'];
                $uploaded=false;
                $save_path='';

                $dbconn = pg_connect("host=localhost dbname=forum port=5432 user=postgres password=Stella")
                        or die( 'Could not connect: ' . pg_last_error());

                
                    if(isset($_POST['researchButton'])){
                        $testo=$_POST['inputTesto'];
                        
                        $result = pg_query($dbconn, "SELECT * FROM ricetta where where (LOWER(nomer) SIMILAR TO LOWER('%($testo)%')) OR  (LOWER(ingredienti) SIMILAR TO LOWER('%($testo)%') )");
                        $trovati=pg_num_rows($result);
                        if($trovati>0){


                        while($row=pg_fetch_assoc($result)){
                         
                        
                            $nomer=$row['nomer'];
    
                            $q3 = 'SELECT * from fotoricette where added_by = $1';
                            $result1 = pg_query_params($dbconn, $q3, array($nomer));
                            $line2=pg_fetch_array($result1, null, PGSQL_ASSOC);
                        
                            $id = $line2['id'];
                            $save_path = "images/".$id.".jpg";
                        
                            
                            $q2=  'SELECT * from get_image($1)';
                            $res = pg_query_params($dbconn, $q2, array($id));
    
                    
                        
    
                            if($res){
    
                                $img = pg_fetch_object($res);
                                $imgdata =$img->imgdata;
                                $imgdata = substr($imgdata, 2);
                                $bin = hex2bin($imgdata);
                                file_put_contents($save_path,base64_decode($bin));
                                
    
                            }  
                            
                            echo "<li>"."<a href='../ricetta/ricetta.php?name=$nomer'>"."<img  class='imgw200' src=".$save_path.">"."<br>".$nomer."</a>"."</li>";
                        }
                        
                           
                       
                    }else{
                            echo "Al momento non sono state pubblicate ricette con questo titolo";
                        }

                    }else{
                    
                    


                    $tipo = $_GET['name'];
                    

                    $q1='SELECT * FROM ricetta where tipo=$1';
                    $result = pg_query_params($dbconn,$q1,array($tipo));


                    while($row=pg_fetch_assoc($result)){
                         
                        
                        $nomer=$row['nomer'];
                        $likes=$row['likes'];

                        $q3 = 'SELECT * from fotoricette where added_by = $1';
                        $result1 = pg_query_params($dbconn, $q3, array($nomer));
                        $line2=pg_fetch_array($result1, null, PGSQL_ASSOC);
                    
                        $id = $line2['id'];
                        $save_path = "images/".$id.".jpg";
                    
                        
                        $q2=  'SELECT * from get_image($1)';
                        $res = pg_query_params($dbconn, $q2, array($id));

                
                    

                        if($res){

                            $img = pg_fetch_object($res);
                            $imgdata =$img->imgdata;
                            $imgdata = substr($imgdata, 2);
                            $bin = hex2bin($imgdata);
                            file_put_contents($save_path,base64_decode($bin));
                            

                        }  
                        
                        echo "<li>";
                        echo "<a href='../ricetta/ricetta.php?name=$nomer'>"."<img  class='imgw200' src=".$save_path.">"."<br>".$nomer. "</a>"."<br>";
                        echo "<div class=box> Like: ". $likes  ."</div> ";
                        echo "</li>";
                        
                       
                   
                    }
                }
                
                    

                ?>
           
           
           
          
        

       </ul>
     </div>
       
    </div>
                
</body>
</html>