<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
    <?php
        $dbconn = pg_connect("host=postgresql_database port=5432 dbname=test user=admin password=admin1234")
        or die("Impossibile connettersi: " . pg_last_error());

        if(!$dbconn) {
            echo "ERRORE : impossibile connettersi al database!";
        }
        else {
            $rice = $_POST['nomeRicetta'];
            $ingr = $_POST['ingrediente1'];
            $quan = $_POST['numero1'];
            $unit = $_POST['unita1'];

            $query = "INSERT INTO  ingrediente (ricetta, nomei, quantita, unita) VALUES ('$rice', '$ingr', '$quan', '$unit')";
            $result = pg_query($dbconn, $query);
        }

        header("Location: form-ricette.html");

        pg_close($dbconn);

    ?>
    
    
</body>
</html>

