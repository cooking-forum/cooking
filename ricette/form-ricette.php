<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
    <?php
        session_start();
        $utente=$_SESSION['username'];
       

        $dbconn = pg_connect("host=localhost port=5432 dbname=forum user=postgres password=Stella")
                        or die("Impossibile connettersi: " . pg_last_error());

        if(!(isset($_POST["submitButton"] ) ) ) {
            header ( " Location : form-ricette.html" );
        }
        else {
            $nomer = $_POST["nomeRicetta"];
            $q1 = 'SELECT * from ricetta where nomer=$1';

            $result = pg_query_params($dbconn, $q1, array($nomer));
            if ($line=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                ?>
                    <script type="text/javascript">
                        window.alert("Una ricetta con lo stesso nome è già stata inserita! Prova a aggiungere un commento sotto alla ricetta");
                        location.href = '<?php echo  " ../ricetta/ricetta.php?name=$nomer" ;?>';
                    </script>  
                    <?php
                    
            }
            else {
                
                $tipo = $_POST["tipo"];
                $tempoP = $_POST["tempoP"];
                $proc = $_POST["procedimento"];
                $ingr = $_POST["ingredienti"];
                $likes=0;


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
                             'saved'.strlen(base64_encode($fbytes));
                        }
                    }
                }
                




                $q2 = 'INSERT into ricetta values ($1,$2,$3,$4,$5,$6,$7)' ;
                $data2 = pg_query_params($dbconn, $q2, array($nomer,$utente,$tipo,$proc,$ingr,$likes,$tempoP));

                if ($data2) {

                    ?>

                    <script type="text/javascript">
                            var ris2 = confirm ("Ricetta inserita con successo! Confermi di voler proseguire?");
                            if(ris2 === true)
                            {
                                location.href = '../home/home.php';
                            }
                            else
                            {
                                location.href = 'form-ricette.html';
                            }
                    </script>

                    <?php
                }
                
                
              
            }
        }
    
    ?>
    
    
</body>
</html>