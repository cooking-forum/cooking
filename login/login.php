<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css" />
    <script type="application/javascript" src="../js/bootstrap.js"></script>
    <script src="loginCheck.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="application/javascript" src="../bootstrap/js/bootstrap.min.js"></script> 
    <title>Forum Cucina</title>
    
    <script type="text/javascript">
        $(document).ready(function(){
            
             $("#su").mouseenter(function(){
              $("#su").css("background-color", "rgb(243, 151, 75)");
                $("#su").css("border-color", "rgb(231, 123, 34)");
                $("#su").css("color", "#000000");

             });
             $("#su").mouseleave(function(){
                 $("#su").css("background-color", "rgb(245, 198, 179)");
             });
             $("#re").mouseenter(function(){
              $("#re").css("background-color", "rgb(243, 151, 75)");
                $("#re").css("border-color", "rgb(231, 123, 34)");
                $("#re").css("color", "#000000");

             });
             $("#re").mouseleave(function(){
                 $("#re").css("background-color", "rgb(245, 198, 179)");
             });
             
             
        });
    </script>
</head>
<body>
    <?php
        session_start();
        $dbconn = pg_connect("host=localhost dbname=forum port=5432 user=postgres password=Stella") or die("Impossibile connettersi: " . pg_last_error());
        
        if(isset($_POST['accessButton'])){
            $email = $_POST['inputEmail'];
            $pwd = $_POST['inputPassword'];

            if(isset($_POST['remember'])){ $remember=$_POST['remember']; }
            else { $remember=null; }

            $q1 = "SELECT * from utente where email= $1 ";
            $result = pg_query_params($dbconn, $q1, array($email));
            
            if (!($line=pg_fetch_array($result, null, PGSQL_ASSOC))) {

                ?>
                <script type="text/javascript">
                    var ris2 = confirm ("Non sei registrato!");
                    if(ris2 === true)
                    {
                        location.href = '../registrazione/index.html';
                    }
                    else
                    {
                        location.href = 'login.php';
                    }
                </script>
            <?php
            }

            else{
                $password = md5($_POST['inputPassword']);
                $_SESSION['username']= "$email";
                $q2 = "SELECT * from utente where email = $1 and pawd = $2";
                $result = pg_query_params($dbconn, $q2, array($email, $password));
                if (!($line=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                    ?>
                     <script type="text/javascript">
                        window.alert("La password inserita è errata");
                    </script>   
                    <?php
                }
                else{
                    if($remember!=null){
                        setcookie("login[username]",$email,time()+604800);
                        setcookie("login[password]",$pwd,time()+604800);
                    }
                    else{
                        setcookie("login[username]",$email,time()-604800);
                        setcookie("login[password]",$pwd,time()-604800);
                    }
                    $_SESSION['username']= "$email";
                    header("Location:../home/home.php");
                }
               
            }
        }
    ?>
    <div class="header">
        <h1 class="h1"> Game of Fork </h1>   
    </div>
  
    <br>

    <div class="centralBox"> 
        <form action="login.php" method="POST" class="form-login" name="myLogin" onSubmit="checkLogin()">
            <h2 class="h2"> Inserisci le tue credenziali! </h2>
            <label for="email" class="label"> Indirizzo email </label>
            <input type="text" name="inputEmail" class="form-input" value="<?php if(isset($_COOKIE['login'])){echo $_COOKIE['login']['username'];}; ?>" placeholder="email" required autofocus >
            
            <br>
            <label for="password" class="label"> Password </label> 
            <input type="password" name="inputPassword" class="form-input" value="<?php if(isset($_COOKIE['login'])){echo $_COOKIE['login']['password'];}; ?>" placeholder="password" required > 

           
            <br>
            <br>
             <div id="remember" class="mb-3">
                <input type="checkbox" name="remember" value="remember" <?php if(isset($_COOKIE['login'])){ echo 'checked';}; ?> >
                <label for="remember"> Remember me </label>
            </div>
            
            <br>

            <button class="btn" id="su" type="submit" name="accessButton" > Accedi </button>
            <button class="btn" id="re" type="reset" name="resetButton"> Reset </button>
        </form>
    </div>
</body>
</html>