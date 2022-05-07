<html>
    <head></head>
    <body>
        <?php
        $dbconn = pg_connect( "host=localhost port=5433 dbname=Registrazione user=postgres password=password ")
            or die( 'Could not connect: ' . pg_last_error());
        if ( !( isset( $_POST [ ' registrationButton ' ] ) ) ) {
            header ( " Location : ../index.html" );
        }else {
            $email = $_POST [ ' inputEmail ' ] ;
            $q1= "select ∗ from utente where email= $1";
            $result=pg_query_params($dbconn, $q1, array($email));
            if($line=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                echo "<h1> Sorry, you are already a registered user </h1>
                    <a href = ../login/index.html> Click here to login </a>";
                }
            else {
                $nome = $_POST [ ' inputName ' ] ;
                $password = md5( $_POST [ ' inputPassword ' ] ) ;
                $q2 = " insert into utente values ( $1 , $2 , $3 , $4 , $5 ) " ;
                $data = pg_query_params ( $dbconn, $q2, array ( $email, $nome, $password ) ) ;
                    if( $data ) {
                        echo "<h1> Registrazione completata<br/></h1>";
                        echo "<a href = ../Welcome.php? name=$nome>Premi qui per inziare ad utilizzare il sito web </a>";
                    }
                }
            }
        ?>
    </body>
</html>