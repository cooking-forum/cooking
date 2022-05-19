<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
    <?php
        session_start();
        $utente=$_SESSION['username'];
       

        $dbconn = pg_connect("host=localhost port=5432 dbname=registrazione user=donia password=diag")
                        or die("Impossibile connettersi: " . pg_last_error());

        if(!(isset($_POST["submitButton"] ) ) ) {
            header ( " Location : form-ricette.html" );
        }
        else {
            $nomer = $_POST["nomeRicetta"];
            $q1 = 'SELECT * from ricetta where nomer=$1';
            $result = pg_query_params($dbconn, $q1, array($nomer));
            if ($line=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                echo "<h1> Una ricetta con lo stesso nome è già stata inserita! Prova a aggiungere un commento sotto al post <h1>";
            }
            else {
                
                $tipo = $_POST["tipo"];
                $proc = $_POST["procedimento"];
                $ingr = $_POST["ingredienti"];
                


                // foto
                $upload_dir=getcwd().DIRECTORY_SEPARATOR.'/uploads';
                if($_FILES["caricaFoto"]["error"]==UPLOAD_ERR_OK){
                    $temp_name=$_FILES["caricaFoto"]["tmp_name"];
                    $name=basename($_FILES["caricaFoto"]["name"]);
                    $save_path=$upload_dir.$name;
                    move_uploaded_file($temp_name,$save_path);
                    $uploaded=true;
    
                }
                if($uploaded){
                    $fh=fopen($save_path,'rb');
                    $fbytes=fread($fh,filesize($save_path));
    
                    if($dbconn){
                        $query="call save_fotoricette($1,$2)";
                        $res=pg_query_params($dbconn,$query,array(base64_encode($fbytes),"$nomer"));
                        if($res){
                            echo 'saved'.strlen(base64_encode($fbytes));
                        }
                    }
                }
                




                $q2 = 'INSERT into ricetta values ($1,$2,$3,$4,$5)' ;
                $data2 = pg_query_params($dbconn, $q2, array($nomer,$utente,$tipo,$proc,$ingr));

                if ($data2) {
                    echo "Ricetta inserita con successo!!";
                }
                
                
              
            }
        }
    
    ?>
    
    
</body>
</html>