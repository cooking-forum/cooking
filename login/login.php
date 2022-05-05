<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
    <?php
        $dbconn = pg_connect("host=localhost port=5500 dbname=Utenti user=postgres password=SiCucina_Utenti") or die("Impossibile connettersi: " . pg_last_error());
        
        if (!(isset($_POST['accessButton']))) { header("Location: ../")}

        if ($dbconn) {
                $email = $_POST['inputEmail'];
                $q1 = "select * from utente where email= $1";
                $result = pg_query_params($dbconn, $q1, array($email));
                if (!($line=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                    echo "<h1> Non sei registrato! Clicca </h1>
                        <a href=../registrazione/registrazione.html> QUI </a> <h1> per registrarti! <h1>";
                }
                else {
                    $password = md5($_POST['inputPassword']);
                    $q2 = "select * from utente where email = $1 and paswd = $2";
                    $result = pg_query_params($dbconn, $q2, array($email,$password));
                    if (!($line=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                        echo "<h1> La password inserita è errata! Clicca </h1>
                            <a href=login.html> QUI </a> <h1> per registrarti! <h1>";
                    }
                    else {
                        $nome = $line['nome'];
                        echo "<a href=../welcome.php?name=$nome> Premi qui </a>
                            per inziare ad utilizzare il sito web";
                    }
                }
            }
    ?>

    
</body>
</html>