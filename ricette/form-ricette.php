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
            $ricetta = $_POST["nomeRicetta"];
            $q1 = "SELECT * from ricetta where nomer = $ricetta";
            $result = pg_query_params($dbconn, $q1, array($ricetta));
            if ($line=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                echo "<h1> Una ricetta con lo stesso nome è già stata inserita! Prova a aggiungere un commento sotto al post <h1>";
            }
            else {
                $autore = $_POST["nomeAutore"];
                $proc = $_POST["procedimento"];
                $tipo = $_POST["tipo"];
                // $foto = $_POST["caricaFoto"];
                $q2 = "INSERT into ricetta (utente, nomer, procedimento, tipologia) values ('$autore', '$ricetta', '$proc', '$tipo')";
                $data2 = pg_query($dbconn, $q2);

                if ($data2) {
                    echo "<h1> Ricetta inserita con successo!! <br></h1>";
                }
                
                $ingr = $_POST["ingrediente1"];
                $nume = $_POST["numero1"];
                $unit = $_POST["unita1"];
                $q3 = "INSERT into ingrediente (ricetta, nomei, quantita, unita) values ('$ricetta', '$ingr', '$nume', '$unit')";
                $data3 = pg_query($dbconn, $q3);
            
                if ($data3) {
                    echo "<h1> ingredienti inseriti con successo!! <br></h1>";
                }
            }
        }
    ?>
    
    
</body>
</html>

