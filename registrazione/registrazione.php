<html>
    <head></head>
    <body>
        <?php
        $dbconn = pg_connect("host=localhost dbname=registrazione port=5432 user=postgres password=diag");
                //or die( 'Could not connect: ' . pg_last_error());
        if(!(isset($_POST["signupButton"] ) ) ) {
            header ( " Location : index.html" );

        }else {
            $email = $_POST["inputEmail"] ;
            $q1= 'SELECT * from utente where email= $1';
            $result=pg_query_params($dbconn, $q1, array($email));
            if($line=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                echo "<h1> Spiacente, l'email indicata risulta già essere associata ad un account.</h1>
                    <a href = ../login/index.html> Clicca qui per il login </a>";
                }
            else {
                $nome = $_POST["inputName"] ;
                $password = md5($_POST["inputPassword"]) ;
                $immagine = $_POST["inputImage"] ;
                $livello = 0;
                $cookies = $_POST["cookies"] ;
                $q2 = 'INSERT into utente values ($1,$2,$3,$4,$5,$6)' ;
                $data = pg_query_params($dbconn, $q2, array($email,$nome,$password,$immagine,$cookies,$livello) ) ;
                    if($data){
                        echo "<h1> Registrazione completata<br/></h1>";
                        $nome = $line["nome"];
                        echo "<a href = Welcome.php? name=$nome >Premi qui per inziare ad utilizzare il sito web </a>";
                    }
                }
            }
        ?>
    </ body>
</ html>