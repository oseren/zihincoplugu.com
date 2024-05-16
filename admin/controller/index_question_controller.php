<?php include "../include/config.php"; ?>

<?php 

if (!empty($_POST["question"]) && !empty($_POST["name"]) && !empty($_POST["email"])) {

    if (!(strlen(trim($_POST["question"])) < 12)) {
        $question = $_POST["question"];
        $name = $_POST["name"];
        $email = $_POST["email"];

        $sql = $config -> prepare("INSERT INTO questions(question,name,email) Values(?,?,?)");
        $sql -> bind_param("sss",$question,$name,$email);
        $sql -> execute();
    
    }

}
?>