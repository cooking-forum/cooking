<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
    <?php
        $dbconn = pg_connect("host=localhost port=5432 dbname=Ricette user=postgres password=SiCucina_Ricette")
                        or die("Impossibile connettersi: " . pg_last_error());
        
        if(!(isset($_POST["submitButton"] ) ) ) {
            header ( " Location : form_ricette.html" );
        }
        else {
            $ricetta = $_POST['nomeRicetta'];
            $q1 = "SELECT * from ricetta where nome_ricetta = $ricetta";
            $result = pg_query_params($dbconn, $q1, array($ricetta));
            if ($line=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                echo "<h1> Una ricetta con lo stesso nome è già stata inserita! Prova a aggiungere un commento sotto al post <h1>";
            }
            else {
                $nome = $_POST["nomeRicetta"];
                $auto = $_POST["nomeAutore"];
                $ingr = $_POST["ingrediente"];
                $nume = $_POST["numero"];
                $unit = $_POST["unita"];
                $proc = $_POST["procedimento"];
                $foto = $_POST["caricaFoto"];
                $q2 = "INSERT into ricetta values ($1, $2, $6, $7)";
                $data2 = pg_query_params($dbconn, $q2, array($nome, $auto, $proc, $foto) ) ;
                $q3 = "INSERT into ingrediente values ($3, $4, $5)";
                $data3 = pg_query_params($dbconn, $q3, array($ingr, $nume, $unit) ) ;

                if($data2 && $data3){
                    echo "<h1> Ricetta inserita con successo!! <br></h1>";
                    $nome = $line["nome"];
                    echo "<a href = Welcome.php? name=$nome> Premi qui per inziare ad utilizzare il sito web </a>";
                }
            }
        }

    ?>

    
</body>
</html>