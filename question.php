<?php include "admin/include/config.php"; ?>
<?php include "admin/func.php"; ?>

<?php 

$sqlQuestion = $config -> prepare("SELECT id,question,answer FROM questions WHERE answer IS NOT NULL");
$sqlQuestion -> execute();
$rowQuestion = $sqlQuestion -> get_result();

$sqlQuestionText = $config -> prepare("SELECT questionText FROM main");
$sqlQuestionText -> execute();
$rowQuestionText = $sqlQuestionText -> get_result();
$questionText = $rowQuestionText -> fetch_assoc();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="og:type" content="website" />
    <meta name="og:title" content="Zihnini Boşalt • <?=$dataname["websitename"]?>" />
    <meta name="og:image" content="https://localhost/story/<?=$dataname["favicon"]?>" />
    <meta name="og:description" content="<?=$questionText["questionText"]?>" />

    <title>Zihnini Boşalt • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="<?=$dataname["favicon"]?>">

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">

    <script src="js/question_scripts.js"></script>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <!-- Header area start -->
    <?php include("include/header.php"); ?>

    <div class="site-hero py-5 bg-light mb-5">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-12 text-center">
                    <h1 class="text-black mb-0">Zihnini Boşalt</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">

            <div class="row mb-5 border-bottom">


                <div class="col-lg-9 border-right">

                    <div class="question-form">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="İsim"
                                        autocomplete="off" required>
                                    <div class="errorName"></div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                        autocomplete="off" required>
                                    <div class="errorEmail"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea name="question" id="question" cols="30" rows="5" class="form-control"
                                placeholder="Soracağınız soruyu yazın..." autocomplete="off" required></textarea>
                            <div class="errorMessage"></div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" value="Soru Sor" class="btn btn-primary btn-md"
                                onClick="askAQuestion(this)">
                        </div>
                    </div>

                </div>

                <div class="col-lg-3">
                    <h6><?=$questionText["questionText"]?></h6>
                </div>


            </div>

            <div class="row pb-5 mb-5">
                <div class="col-lg-12">
                    <div class="custom-accordion" id="accordion_1">
                        <?php 
                    if (mysqli_num_rows($rowQuestion) != 0) {
                        while($questions = mysqli_fetch_assoc($rowQuestion)) { ?>
                        <div class="accordion-item">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#question<?=$questions["id"]?>" aria-expanded="false"
                                    aria-controls="question<?=$questions["id"]?>">
                                    <?=$questions["question"]?>
                                </button>
                            </h2>
                            <div id="question<?=$questions["id"]?>" class="collapse" aria-labelledby="answer<?=$questions["id"]?>"
                                data-parent="#accordion_1">
                                <div class="accordion-body">
                                    <?=$questions["answer"]?>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    } else { ?> 
                        <div class="accordion-item">
                            <div class="accordion-body h5 text-center" style="border-radius: 5px">
                                Daha önceden hiç bir soru sorulmamış, ilk soruyu sen sor
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="overlayer"></div>
    <div class="loader">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Footer area start -->
    <?php include("include/footer.php"); ?>


</body>

</html>