<?php 
function getCommentsWithArray($blogID, $parentID = 0, $user_tree_array = '') {
    global $config;

    if (!is_array($user_tree_array)) {
        $user_tree_array = array();
    }
    
    $checkQuery = $config->prepare("SELECT comments.content, comments.status, comments.id, comments.parentID, comments.submitDate, comments.name, comments.adminComment
        FROM comments WHERE comments.blogID=? AND comments.parentID =? AND comments.status=? ORDER by comments.id DESC");
    $status = 1;
    $checkQuery->bind_param("sss", $blogID, $parentID, $status);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult) {
        while($result = mysqli_fetch_assoc($checkResult)) {
            $user_tree_array[] = array("id" => $result["id"]
                                    , "content" => $result["content"]
                                    , "parentID" => $result["parentID"]
                                    , "name" => $result["name"]
                                    , "adminComment" => $result["adminComment"]
                                    , "submitDate" => $result["submitDate"]);

            $user_tree_array = getCommentsWithArray($blogID, $result["id"], $user_tree_array);
        }
    }
    return $user_tree_array;
}

function getCommentsWithArrayForAdmin($blogID, $parentID = 0, $user_tree_array = '') {
    global $config;

    if (!is_array($user_tree_array)) {
        $user_tree_array = array();
    }
    
    $checkQuery = $config->prepare("SELECT comments.content, comments.status, comments.id, comments.parentID, comments.submitDate, comments.name, comments.adminComment
        FROM comments WHERE comments.blogID=? AND comments.parentID =? ORDER by comments.id DESC");
    $checkQuery->bind_param("ss", $blogID, $parentID);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult) {
        while($result = mysqli_fetch_assoc($checkResult)) {
            $user_tree_array[] = array("id" => $result["id"]
                                    , "content" => $result["content"]
                                    , "parentID" => $result["parentID"]
                                    , "name" => $result["name"]
                                    , "status" => $result["status"]
                                    , "adminComment" => $result["adminComment"]
                                    , "submitDate" => $result["submitDate"]);

            $user_tree_array = getCommentsWithArrayForAdmin($blogID, $result["id"], $user_tree_array);
        }
    }
    return $user_tree_array;
}

function commentsBuildTree(array &$elements, $parentId = 0) {
    $branch = array();

    foreach ($elements as &$element) {
        if ($element['parentID'] == $parentId) {
            $children = commentsBuildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
            unset($element);
        }
    }

    return $branch;
}

function commentsTree($comments) {
    $tree = commentsBuildTree($comments);
    return $tree;
}

function printComments($comments, $id) {
    foreach ($comments as $key) {
?>
        <li class="comment">
            <div class="vcard bio">
                <img src="admin/profiles/default_profile_photo.jpg" alt="Image placeholder">
            </div>
            <div class="comment-body">
                <h3> <?=$key["name"]?> <?= ($key["adminComment"]=="1")? '<span class="meta" style="color: #a4c639; vertical-align: middle;"> Yazar </span>':''; ?></h3>
                <div class="meta"> <?=time_elapsed_string($key["submitDate"])?> </div>
                <p> <?=$key["content"]?> </p>
                <p><a class="reply add_comment reply_cm cm_reply" id="reply_<?=$key["id"]?>" onclick="reply_form('<?=$key['id']?>','<?=$id?>')">Yanıtla</a></p>
                <div class="comment-list-boxr">
                    <div class="reply_area" id="reply_area_<?=$key["id"]?>"></div>
                    <div class="message-wrapcm-<?=$key["id"]?>"></div>
                </div>
            </div>

            <?php if (isset($key['children'])) { ?>
                <ul class="children">
                    <?php printComments($key['children'], $id); ?>
                </ul>
            <?php } ?>
        </li>
<?php
    }
}


function printCommentsForAdmin($comments, $id) {
    if (!empty($comments)) {
        ?>
        <input type="hidden" name="username" id="username" value="<?=$_SESSION["userdata"][1]?>">
        <input type="hidden" name="email" id="email" value="<?=$_SESSION["userdata"][3]?>">
        <?php
        foreach ($comments as $key) { ?>

            <li class="comment">
                <div class="vcard bio">
                    <img src="profiles/default_profile_photo.jpg" alt="Image placeholder">
                </div>
                <div class="comment-body">
                    <h3> <?=$key["name"]?> <?= ($key["adminComment"]=="1")? '<span class="meta" style="color: #a4c639; vertical-align: middle;"> Yazar </span>':''; ?></h3>
                    <div class="meta"> <?=time_elapsed_string($key["submitDate"]) ?> </div>
                    <p> <?=$key["content"]?> </p>
                    <p>
                        <div style="display: flex">

                        <?php 
                        if ($key["status"] == 0) { ?>
                            <a href="../admin/controller/comments_controller.php?islem=confirm&bid=<?=$id?>&cid=<?=$key["id"]?>" id="confirm_<?=$key["id"]?>" class="btn bg-gradient-success btn-sm">Onayla</a>
                        <?php
                        }
                        ?>

                        <?php 
                        if ($key["status"] == 1) { ?>
                            <a class="btn btn-info btn-sm" id="reply_<?=$key["id"]?>" onclick="reply_form('<?=$key['id']?>','<?=$id?>')">Yanıtla</a>
                        <?php
                        }
                        ?>
                    
                            <form class="ml-1" id="delete_<?=$key["id"]?>" action="../admin/controller/comments_controller.php"
                                method="POST"
                                 onsubmit="return confirm('Silmek istediğine emin misin?')">

                                <input type="hidden" name="bid"
                                    value="<?= $id?>">

                                <input type="hidden" name="cid"
                                    value="<?= $key["id"] ?>">

                                <input type="hidden" name="islem"
                                    value="delete">

                                <input type="submit" value="Sil"
                                    class="btn btn-sm btn-danger">
                            </form>
                        </div>

                    </p>
                    <div class="comment-list-boxr">
                        <div class="reply_area" id="reply_area_<?=$key["id"]?>"></div>
                        <div class="message-wrapcm-<?=$key["id"]?>"></div>
                    </div>
                </div>
                
                <?php if (isset($key['children'])) { ?>
    
                    <ul class="children">
                        <?php printCommentsForAdmin($key['children'], $id); ?>
                    </ul>
    
                <?php } ?>
    
            </li>
    
        <?php 
        }
    } else {
        ?>

        <div class="callout" style="border-left: 0px">
            <h4 style="text-align: center">Herhangi bir veri bulunamadı
             </h4>
        </div>
        
        <?php      
    }
}

function countComments($blogID) {
    global $config;

    $sql = $config->prepare("SELECT count(*) as count FROM comments WHERE blogID=? AND status!=0");
    $sql->bind_param("s", $blogID);
    $sql->execute();
    $result = $sql->get_result();
    $rowCount = $result->fetch_assoc()["count"];

    return $rowCount;
}

function time_elapsed_string($datetime, $full = false) {
    date_default_timezone_set('Europe/Istanbul');
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $w = floor($diff->d / 7);
    $diff->d -= $w * 7;
    $string = ['y' => 'Yıl','m' => 'Ay','w' => 'Hafta','d' => 'Gün','h' => 'Saat','i' => 'Dakika','s' => 'Saniye'];
    foreach ($string as $k => &$v) {
        if ($k == 'w' && $w) {
            $v = $w . ' Hafta' . ($w > 1 ? '' : '');
        } else if (isset($diff->$k) && $diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' Önce' : 'Az Önce';
}
?>

