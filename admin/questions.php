<?php include("include/config.php"); ?>
<?php include("session.php"); ?>
<?php include("func.php"); ?>
<?php checkSession(); ?>

<?php 
if (isset($_SESSION['userdata'])) {
  $userID=$_SESSION['userdata']['0'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Soru Yönetimi • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="../<?=$dataname["favicon"]?>">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <script src="dist/js/questionAnswer_scripts.js"></script>

    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

    <link rel="stylesheet" href="dist/css/adminlte.min.css">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <?php include("include/navbar.php"); ?>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <?php include("include/sidebar.php"); ?>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">

                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">

                                <div class="card">
                                    <div class="card-header d-flex p-0">
                                        <h3 class="card-title p-3">Soru Kontrol Sistemi</h3>
                                        <ul class="nav nav-pills ml-auto p-2">
                                            <li class="nav-item"><a class="nav-link active" href="#tab_1"
                                                    data-toggle="tab">Cevaplanmamış Sorular</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Tüm
                                                    Sorular</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">

                                            <div class="tab-pane active" id="tab_1">

                                                <?php 
                                                
                                                $sqlPendingApproval = $config -> prepare("SELECT * FROM questions WHERE answer IS NULL ORDER BY submitDate DESC");
                                                $sqlPendingApproval -> execute();
                                                $rowsPendingApproval = $sqlPendingApproval -> get_result();

                                                $currentSubmitDate = null;
                                                ?>

                                                <?php 
                                                
                                                if (mysqli_num_rows($rowsPendingApproval) != 0) { ?>
                                                <div class="timeline timeline-inverse">
                                                    <?php 
                                                    while ($resultPA = mysqli_fetch_assoc($rowsPendingApproval)) {
                                                        $varSubmitDate = month_to_turkish(date('M d Y',strtotime($resultPA['submitDate'])));

                                                        if ($varSubmitDate !== $currentSubmitDate) {
                                                            $currentSubmitDate = $varSubmitDate;
                                                    ?>

                                                    <div class="time-label">
                                                        <span class="bg-danger">
                                                            <?= $currentSubmitDate ?>
                                                        </span>
                                                    </div>

                                                    <?php
                                                        }
                                                    ?>

                                                    <div>
                                                        <i class="fas fa-question bg-warning"></i>
                                                        <div class="timeline-item">
                                                            <span
                                                                class="time"><?= month_to_turkish(date('M d Y',strtotime($resultPA['submitDate']))) ?>
                                                            </span>
                                                            <h3 class="timeline-header">
                                                                <a><?=$resultPA["name"]?></a> adlı kişi bir soru sordu
                                                            </h3>
                                                            <div class="timeline-body">
                                                                <?=$resultPA["question"]?>
                                                            </div>
                                                            <div class="timeline-footer" style="display: flex;">

                                                                <?php 
                                                            if ($resultPA["answer"] == NULL) {
                                                            ?>

                                                                <a class="btn btn-info btn-sm mr-1"
                                                                    id="answer_<?=$resultPA["id"]?>"
                                                                    onclick="answer_form('<?=$resultPA['id']?>')">Yanıtla</a>

                                                                <?php
                                                            }
                                                            ?>

                                                                <?php
                                                                if ($_SESSION["userdata"]["2"] == 1) { ?>

                                                                <form id="delete_<?=$resultPA["id"]?>"
                                                                    action="controller/question_controller.php"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Silmek istediğine emin misin?')">

                                                                    <input type="hidden" name="id"
                                                                        value="<?= $resultPA['id'] ?>">

                                                                    <input type="submit" name="islem" value="Sil"
                                                                        class="btn btn-sm btn-danger">
                                                                </form>

                                                                <?php } ?>

                                                                <div class="answer-box">
                                                                    <div class="answer_area"
                                                                        id="answer_area_<?=$resultPA["id"]?>"></div>
                                                                </div>


                                                            </div>
                                                        </div>

                                                        <div class="message-wrapcm-<?=$resultPA["id"]?>"></div>
                                                    </div>

                                                    <?php
                                                    } 
                                                    ?>
                                                    <div>
                                                        <i class="far fa-clock bg-gray"></i>
                                                    </div>

                                                </div>

                                                <?php
                                                } else { 
                                                    ?>

                                                <div class="callout" style="border-left: 0px">
                                                    <h4 style="text-align: center">Herhangi bir veri bulunamadı
                                                    </h4>
                                                </div>

                                                <?php
                                                }
                                                ?>

                                            </div>

                                            <div class="tab-pane" id="tab_2">

                                                <table id="example3" class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>İsim</th>
                                                            <th>Email</th>
                                                            <th>Soru</th>
                                                            <th>Cevabın</th>
                                                            <th>Tarih</th>
                                                            <th>İşlemler</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                            <?php 

                                            $sql = $config -> prepare("SELECT * FROM questions ORDER BY submitDate DESC");
                                            $sql -> execute();
                                            $rows = $sql -> get_result();

                                            ?>

                                                        <?php
                                            if ($rows) {
                                                while($result = mysqli_fetch_assoc($rows)) { ?>
                                                        <tr>
                                                            <td> <?= $result['id'] ?> </td>
                                                            <td> <?= $result['name'] ?> </td>
                                                            <td> <?= $result['email'] ?> </td>
                                                            <td> <?= $result['question'] ?> </td>
                                                            <td> <?= ($result["answer"] == NULL)? '<span> Cevap yok </span>':$result["answer"]; ?> </td>
                                                            <td> <?= month_to_turkish(date('M d Y',strtotime($result['submitDate']))) ?>
                                                            </td>
                                                            <td style="width: 125px">

                                                                <div style="display: flex">

                                                                    <?php 

                                                                    if ($result["active"]) { ?>

                                                                    <a href="controller/question_controller.php?islem=active&id=<?= $result['id'] ?>&status=0"
                                                                        class="btn btn-sm btn-warning mr-1">Gizle</a>

                                                                    <?php } else { ?>

                                                                    <a href="controller/question_controller.php?islem=active&id=<?= $result['id'] ?>&status=1"
                                                                        class="btn btn-sm btn-warning mr-1">Göster</a>

                                                                    <?php
                                                                    }
                                                                
                                                                if ($_SESSION["userdata"]["2"] == 1) { ?>

                                                                    <form class=""
                                                                        action="controller/question_controller.php"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Silmek istediğine emin misin?')">

                                                                        <input type="hidden" name="id"
                                                                            value="<?= $result['id'] ?>">

                                                                        <input type="submit" name="islem" value="Sil"
                                                                            class="btn btn-sm btn-danger">
                                                                    </form>

                                                                    <?php } ?>
                                                                </div>
                                                            </td>



                                                        </tr>
                                                        <?php
                                                }
                                            }
                                            ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
            </div>
        </div>
        </section>
    </div>


    <script src="plugins/jquery/jquery.min.js"></script>

    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="plugins/toastr/toastr.min.js"></script>


    <script src="dist/js/adminlte.min.js"></script>

    <?php 
            if (!empty($_SESSION["msg"])) {
                $toast_message = $_SESSION["msg"][0];
                $toast = $_SESSION["msg"][1];
                echo "<script type='text/javascript'>$toast('$toast_message')</script>";
            }
            unset($_SESSION['msg']);
        ?>

    <script>
    $(function() {
        $('#example3').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": true,
            "pageLength": 6,
        });
    });
    </script>

</body>

</html>