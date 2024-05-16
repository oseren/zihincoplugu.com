<?php include "../include/config.php"; ?>
<?php include "../../include/commentsFunc.php"; ?>

<?php 

$action = $_POST["action"];

if(!empty($_POST["action"])) {
    switch ($action) {
        case 'add':

            if (!(strlen(trim($_POST["message"])) < 12)) {

                $name = $_POST["name"];
                $email = $_POST["email"];
                $message = $_POST["message"];

                if(strlen($name) < 3 || strlen($name)>50){
                    $errorMessage ="İsim 3 ve 50 karakter arası olmalıdır.";
                    echo "<script>
                    $('.errorName').html('<font color=\"red\">$errorMessage</font>').show();
                    setTimeout(function(){
                        $('.errorName').fadeOut('slow');
                    }, 3000);
                 </script>";
                    $error[] = 'İsim 3 ve 50 karakter arası olmalıdır.';
                } 

                if(!preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,})$/i", $email)) {
                    $errorMessage ="Geçersiz mail türü (username@gmail.com)";
                    echo "<script>
                    $('.errorEmail').html('<font color=\"red\">$errorMessage</font>').show();
                    setTimeout(function(){
                        $('.errorEmail').fadeOut('slow');
                    }, 3000);
                 </script>";
                    $error[] = 'Geçersiz mail türü (username@gmail.com)';
                  }

                if (!isset($error)) {
                    $blogID = $_POST["blogID"];
                    $msg=htmlentities($message);
                    $parentID=0;
                    $status=0; 

                    $sql = $config -> prepare("INSERT INTO comments(content,blogID,status,name,email,parentID) Values(?,?,?,?,?,?)");
                    $sql -> bind_param("ssssss",$msg,$blogID,$status,$name,$email,$parentID);
                    $sql -> execute();

                    $last_id = $config->insert_id;

                    if ($last_id) {
                        $sql2 = $config -> prepare("SELECT * FROM comments WHERE id=?");
                        $sql2 -> bind_param("s",$last_id);
                        $sql2 -> execute();
                        $rows = $sql2 -> get_result();
                        
                        foreach ($rows as $key) {

                            if ($key["name"]!='') {
                                $unamo=$key["name"];
                            } else {
                                $unamo='Anonymous ';
                            } 
                        }
                    }
                }
             
            } 
            break;
        
        case 'addr':
            if (!(strlen(trim($_POST["messager"]))) < 12) {

                $name = $_POST["namer"];
                $email = $_POST["emailr"];
                $message = $_POST["messager"];

                if(strlen($name) < 3 || strlen($name)>50){
                    $error[] = 'İsim 3 ve 50 karakter arası olmalıdır.';
                } 

                if(!preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,})$/i", $email)) {
                    $error[] = 'Geçersiz mail türü (username@gmail.com)';
                  }

                if (!isset($error)) {
                    $blogID = $_POST["blogIDr"];
                    $parentID = $_POST["parentIDr"];
                    $msg=htmlentities($message);
                    $status=0;

                    $sql3 = $config -> prepare("INSERT INTO comments(content,blogID,status,name,email,parentID) Values(?,?,?,?,?,?)");
                    $sql3 -> bind_param("ssssss",$msg,$blogID,$status,$name,$email,$parentID);
                    $sql3 -> execute();

                    $last_id = $config->insert_id;

                    if ($last_id) {
                        $sql4 = $config -> prepare("SELECT * FROM comments WHERE id=?");
                        $sql4 -> bind_param("s",$last_id);
                        $sql4 -> execute();
                        $rows = $sql4 -> get_result();

                        foreach ($rows as $key) {
                            ?>

                            <?php
                                echo '
                                    <li class="comment" style="margin: 12.5px 0 0 -40px">
                                        <div class="vcard bio">
                                            <img src="admin/profiles/default_profile_photo.jpg" alt="Image placeholder">
                                        </div>
                                        <div class="comment-body">

                                        <h3>'.$key["name"].'</h3> 

                                        <div class="meta">'.time_elapsed_string($key["submitDate"]).'</div>
                                            <p>'.$key["content"].'</p>

                                            <p><a class="reply" id="reply_<?=$key["id"]?>Yanıtla</a></p>

                                        </div>
                                    </li>';
                            ?>
                            <?php
                        }
                    }
                }
            }
            break;

        case 'adminaddr':
            if (!(strlen(trim($_POST["messager"]))) < 12) {

                $name = $_POST["namer"];
                $email = $_POST["emailr"];
                $message = $_POST["messager"];

                    $blogID = $_POST["blogIDr"];
                    $parentID = $_POST["parentIDr"];
                    $msg=htmlentities($message);
                    $status=1;
                    $adminComment=1;

                    $sql3 = $config -> prepare("INSERT INTO comments(content,blogID,status,name,email,parentID,adminComment) Values(?,?,?,?,?,?,?)");
                    $sql3 -> bind_param("sssssss",$msg,$blogID,$status,$name,$email,$parentID,$adminComment);
                    $sql3 -> execute();

                    $last_id = $config->insert_id;

                    if ($last_id) {
                        $sql4 = $config -> prepare("SELECT * FROM comments WHERE id=?");
                        $sql4 -> bind_param("s",$last_id);
                        $sql4 -> execute();
                        $rows = $sql4 -> get_result();

                        foreach ($rows as $key) {
                            ?>

                            <?php
                                echo '
                                    <li class="comment" style="margin: 12.5px 0 0 -40px">
                                        <div class="vcard bio">
                                            <img src="profiles/default_profile_photo.jpg" alt="Image placeholder">
                                        </div>
                                        <div class="comment-body">

                                        <h3>'.$key["name"].' <span class="meta" style="color: #a4c639; vertical-align: middle;"> Yazar </span></h3>

                                        <div class="meta">'.time_elapsed_string($key["submitDate"]).'</div>
                                            <p>'.$key["content"].'</p>

                                        </div>
                                    </li>';
                            ?>
                            <?php
                        }
                    }
            }
            break;

        default:
            break;
    }
}

?>