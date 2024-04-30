<?php include "../include/config.php"; ?>
<?php 

$action = $_POST["action"];

if (!empty($_POST["action"])) {
    switch ($action) {
        case 'like':

            if (isset($_POST["blogID"])) {

                $blogID = $_POST["blogID"];

                $check_query = $config->prepare("SELECT blog_id FROM blog WHERE blog_id = ?");
                $check_query->bind_param("s", $blogID);
                $check_query->execute();
                $check_result = $check_query->get_result();

                if ($check_result->num_rows > 0) {
                    if (!isset($_COOKIE["likes"])) {
                        $blog_ids = array();
                    } else {
                        $blog_ids = json_decode($_COOKIE['likes'], true);
                
                    }
                    
                
                    if(isset($blogID)) {
                        if(!in_array($blogID, $blog_ids)) {
                            $blog_ids[] = $blogID;
                
                            $demo = $config->prepare("UPDATE blog SET likes=likes+1 WHERE blog_id=?");
                            $demo->bind_param("s", $blogID);
                            $demo->execute();
                    
                        }
                    
                        setcookie('likes', json_encode($blog_ids), time() + (86400 * 30), '/');
                    }
                }


            }
            break;
        
        case 'unlike':

            if (isset($_POST["blogID"])) {

                $blogID = $_POST["blogID"];

                if (!isset($_COOKIE["likes"])) {
                    $blog_ids = array();
                } else {
                    $blog_ids = json_decode($_COOKIE['likes'], true);
            
                }
            
                if(isset($blogID)) {

                    $index = array_search($blogID, $blog_ids);
                    if ($index !== false) {
                        unset($blog_ids[$index]);

                        $blog_ids = array_values($blog_ids);
    
                        $demo = $config->prepare("UPDATE blog SET likes=likes-1 WHERE blog_id=?");
                        $demo->bind_param("s", $blogID);
                        $demo->execute();
                    }
                
                    setcookie('likes', json_encode($blog_ids), time() + (86400 * 30), '/'); 
                }

            }
            break;

        default:
            break;
    }
}

?>