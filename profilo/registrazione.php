<html>
    <head></head>
    <body>
        <?php
        session_start();
        $uploaded=false;
        $dbconn = pg_connect("host=localhost dbname=registrazione port=5432 user=donia password=diag")
                or die( 'Could not connect: ' . pg_last_error());
        if(!(isset($_POST["signupButton"] ) ) ) {
            header ( " Location : index.html" );

        }else {

            $email = $_POST["inputEmail"];
            $_SESSION['username'] = "$email";



            $q1= 'SELECT * from utente where email= $1';
            $result=pg_query_params($dbconn, $q1, array($email));

            if($line=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                echo "<h1> Spiacente, l'email indicata risulta già essere associata ad un account.</h1>
                    <a href = ../login/login.html> Clicca qui per il login </a>";
                }

       else {
                $nome = $_POST["inputName"] ;
                $pawd = md5($_POST["inputPassword"]) ;


                $upload_dir=getcwd().DIRECTORY_SEPARATOR.'/uploads';
                if($_FILES["inputImage"]["error"]==UPLOAD_ERR_PK){
                    $temp_name=$_FILES["inputImage"]["tmp_name"];
                    $name=basename($_FILES["inputImage"]["name"]);
                    $save_path=$$$upload_dir.$name;
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
                $cookies = $_POST["cookies"] ;
                $q2 = 'INSERT into utente values ($1,$2,$3,$4,$5,$6)' ;
                $data = pg_query_params($dbconn, $q2, array($email,$nome,$pawd,$immagine,$cookies,$livello) ) ;
                    if($data){
                        echo "<h1> Registrazione completata<br/></h1>";
                        header("Location: ../home/index.html");
                        
                    }
                }
            }
        ?>
    </body>
</html>