<!DOCTYPE html>
    <head></head>
    <body>
        <?php
            session_start();
            $uploaded=false;
            $dbconn = pg_connect("host=localhost dbname=forum port=5432 user=postgres password=Stella")
                    or die( 'Could not connect: ' . pg_last_error());
            if(!(isset($_POST["signupButton"] ) ) ) {
                header ( " Location : index.html" );

            }
            else {
                $email = $_POST["inputEmail"];
                $_SESSION['username'] = "$email";

                $q1= 'SELECT * from utente where email= $1';
                $result=pg_query_params($dbconn, $q1, array($email));

                if($line=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                    ?>

                    <script type="text/javascript">
                    var ris2 = confirm ("Spiacente, l'email indicata risulta già essere associata ad un account.");
                    if(ris2 === true)
                    {
                        location.href = '../login/login.php';
                    }
                    else
                    {
                        location.href = 'index.html';
                    }
                </script>

                <?php
                }
                else {
                    $nome = $_POST["inputName"] ;
                    $pawd = md5($_POST["inputPassword"]) ;

                    $upload_dir=getcwd().DIRECTORY_SEPARATOR.'/uploads';

                    if($_FILES["inputImage"]["error"]==UPLOAD_ERR_OK){
                        $temp_name=$_FILES["inputImage"]["tmp_name"];
                        $name=basename($_FILES["inputImage"]["name"]);
                        $save_path=$upload_dir.$name;
                        move_uploaded_file($temp_name,$save_path);
                        $uploaded=true;
                    }

                    if($uploaded){
                        $fh=fopen($save_path,'rb');
                        $fbytes=fread($fh,filesize($save_path));
        
                        if($dbconn){
                            $query="call save_product_photo($1,$2)";
                            $email = $_POST['inputEmail'];
                            $res=pg_query_params($dbconn,$query,array(base64_encode($fbytes),"$email"));
                            if($res){
                                echo 'saved'.strlen(base64_encode($fbytes));
                            }
                        }
                    } 

                    $livello = 0;
                    
                    $q2 = 'INSERT into utente values ($1,$2,$3,$4)' ;
                    $data = pg_query_params($dbconn, $q2, array($email,$nome,$pawd,$livello) ) ;
                    if($data){
                        ?>
                
                        <script type="text/javascript">
                            var ris2 = confirm ("Ti stai per registrare! Confermi di voler proseguire?");
                            if(ris2 === true)
                            {
                                location.href = '../home/home.php';
                            }
                            else
                            {
                                location.href = 'index.html';
                            }
                        </script>
        
        
        
                        <?php
                        
                    }
                }
            }
        ?>
    </body>
</html>