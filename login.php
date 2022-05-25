<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css" />
    <script type="application/javascript" src="../js/bootstrap.js"></script>
    <script src="loginCheck.js"></script>
    <title>Login</title>
</head>
<body>
    <?php
        session_start();
        
        $dbconn = pg_connect("host=localhost dbname=registrazione port=5432 user=donia password=diag") or die("Impossibile connettersi: " . pg_last_error());
        
        if(isset($_POST['accessButton'])){
            $email = $_POST['inputEmail'];
            $_SESSION['username']= $email;
            $pwd = $_POST['inputPassword'];
            $password = md5($pwd);

            if(isset($_POST['remember'])){
                $remember=$_POST['remember'];
            }else{
                $remember=null;
            }


            $q1 = "SELECT * from utente where email= $1 ";
            $result = pg_query_params($dbconn, $q1, array($email));
            
            if (!($line=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                echo "<h1> Non sei registrato! Clicca </h1> <a href=../registrazione/registrazione.html> QUI </a> <h1> per registrarti! <h1>";
            }

            if($line){
                if($remember!=null){
                    setcookie("login[username]",$email,time()+604800);
                    setcookie("login[password]",$pwd,time()+604800);
                }
                header("Location : ../home/home.php");
                
                $q2 = "SELECT * from utente where email = $1 and pawd = $2";
                $result = pg_query_params($dbconn, $q2, array($email, $password));
                if (!($line=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                    echo "<h1> La password inserita è errata! Clicca </h1> <a href=login.html> QUI </a> <h1> per registrarti! <h1>";
                }
            
            }
        }
        ?>
        


    <div class="header">
        <h1 class="h1"> Game of Fork </h1>   
    </div>
  
    <br>

    <div class="column left"> 
        <form action="login.php" method="POST" class="form-login" name="myLogin" onSubmit="checkLogin()">
            <h2 class="h2"> Inserisci le tue credenziali! </h1>
            <label for="email" class="label"> indirizzo email </label>
            <input type="text" name="inputEmail" class="form-input" value="<?php if(isset($_COOKIE['login'])){echo $_COOKIE['login']['username'];}; ?>" placeholder="email" required autofocus >
            <br>
            <br>
            <label for="password" class="label"> password </label> 
            <input type="password" name="inputPassword" class="form-input" value="<?php if(isset($_COOKIE['login'])){echo $_COOKIE['login']['password'];}; ?>" placeholder="password" required > 

            <br>
            <br>
            
             <div id="remember" class="mb-3">
                <input type="checkbox" name="remember" value="remember" <?php if(isset($_COOKIE['login'])){ echo 'checked';}; ?> >
                <label for="remember">Remember me</label>
            </div>
            <br>
            <br>

            
            <button class="btn" type="submit" name="accessButton" > Accedi </button>
            <button class="btn" type="reset" name="resetButton"> Reset </button>
        </form>
    </div>

    <div class="img">
        <img src="../Foto/bf58cea0-991d-4793-88f3-83202fb989c0.jpeg">
    </div>


        
        
        

    
    </body>
</html>