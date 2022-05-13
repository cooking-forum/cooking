<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
    <?php
        $dbconn = pg_connect("host=postgresql_database port=5432 dbname=test user=admin password=admin1234")
                        or die("Impossibile connettersi: " . pg_last_error());
        
        if(!(isset($_POST["submitButton"] ) ) ) {
            header ( " Location : form-ricette.html" );
        }
        else {
            $ricetta = $_POST['nomeRicetta'];
            $q1 = "SELECT * from ricetta where nome-ricetta = $ricetta";
            $result = pg_query_params($dbconn, $q1, array($ricetta));
            if ($line=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                echo "<h1> Una ricetta con lo stesso nome è già stata inserita! Prova a aggiungere un commento sotto al post <h1>";
            }
            else {
                $nome = $_POST["nomeRicetta"];
                $auto = $_POST["nomeAutore"];
                $proc = $_POST["procedimento"];
                $foto = $_POST["caricaFoto"];
                $q2 = "INSERT into ricetta values ($1, $2, $3, $4)";
                $data2 = pg_query_params($dbconn, $q2, array($nome, $auto, $proc, $foto) ) ;

                $count = substr_count($html,'<td>')/4;

                for ($i = 0; $i < $count; $i++) {
                    $nome = $_POST["nomeRicetta"];
                    $ingr = $_POST["ingrediente"];
                    $nume = $_POST["numero"];
                    $unit = $_POST["unita"];
                    $q3 = "INSERT into ingrediente values ($5, $6, $7, $8)";
                    $data3 = pg_query_params($dbconn, $q3, array($ingr, $nume, $unit) ) ;
                }
              
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