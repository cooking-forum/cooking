<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
    <?php
        $dbconn = pg_connect("host=localhost port=5500 dbname=Ricette user=postgres password=SiCucina_Ricette")
                        or die("Impossibile connettersi: " . pg_last_error());
    
    
        if ($dbconn) {
            $ricetta = $_POST['nomeRicetta'];
            $q1 = "select * from ricetta where nome_ricetta= $ricetta";
            $result = pg_query_params($dbconn, $q1, array($ricetta));
            if (($line=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                echo "<h1> Una ricetta con lo stesso nome è già stata inserita! Prova a aggiungere un commento sotto al post <h1>";
            }
            else {
                echo "Ricetta inserita con successo!";
                }
            }
    ?>

    
</body>
</html>