<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
    <?php
        session_start();
        
        $dbconn = pg_connect("host=localhost dbname=forum port=5432 user=postgres password=Stella") or die("Impossibile connettersi: " . pg_last_error());
        
        if (!(isset($_POST['accessButton']))) { header("Location: ../home/index.html"); }
        else {
            $email = $_POST['inputEmail'];
            $q1 = "SELECT * from utente where email= $1";
            $result = pg_query_params($dbconn, $q1, array($email));
            if (!($line=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                echo "<h1> Non sei registrato! Clicca </h1> <a href=../registrazione/registrazione.html> QUI </a> <h1> per registrarti! <h1>";
            }
            else {
                $password = md5($_POST['inputPassword']);
                $q2 = "SELECT * from utente where email = $1 and pawd = $2";
                $result = pg_query_params($dbconn, $q2, array($email, $password));
                if (!($line=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                    echo "<h1> La password inserita è errata! Clicca </h1> <a href=login.html> QUI </a> <h1> per registrarti! <h1>";
                }
                else {
                    $nome=$line['nome'];
                    $_SESSION['username']= "$email";
                    header("Location: ../home/home.php");
                    //echo "<a href = ../home/index.html>Premi qui per andare al tuo profilo utente </a>";
                }
            }
        }
    ?>

    
</body>
</html>