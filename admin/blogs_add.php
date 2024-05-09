<?php include("include/config.php"); ?>
<?php include("session.php"); ?>
<?php include("func.php"); ?>
<?php checkSession(); ?>

<?php 
if (isset($_SESSION['userdata'])) {
	$author_id = $_SESSION['userdata']['0'];
}

$sql1 = $config -> prepare("SELECT * FROM categories");
$sql1 -> execute();
$row1 = $sql1 -> get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Blog Yaz • <?=$dataname["websitename"]?></title>
    <link rel="shortcut icon" href="../<?=$dataname["favicon"]?>">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">

    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

    <script src="plugins/tinymce/tinymce.min.js" referrerpolicy="origin"></script>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include("include/navbar.php"); ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <?php include("include/sidebar.php"); ?>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">


                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Blog Ekleme Sayfası</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">

                                <form action="controller/blogs_controller.php" method="post" enctype="multipart/form-data">

                                    <div class="row">
                                        <div class="col-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Blog Başlığı</label>
                                                <input type="text" class="form-control" name="blog_title"
                                                    placeholder="Blog Başlığı" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Blog İçeriği</label>

                                                <textarea class="form-control" rows="3" name="blog_body" id="classic"
                                                    required>

                                                </textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select class="form-control select2 select2-hidden-accessible"
                                                    data-minimum-results-for-search="Infinity" style="width: 100%;"
                                                    data-select2-id="1" tabindex="-1" aria-hidden="true" name="category"
                                                    required>

                                                    <option value="">Kategori Seçin</option>

                                                    <?php 
                                                    while ($cats = mysqli_fetch_assoc($row1)) { ?>
                                                    <option value="<?= $cats['cat_id'] ?>"><?= $cats['cat_name'] ?>
                                                    </option>
                                                    <?php
                                                    }
                                                ?>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Blog Fotoğrafı</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="blog_image">
                                                        <label class="custom-file-label" for="exampleInputFile">Dosya
                                                            Seç</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <input type="submit" value="Kaydet" class="btn btn-primary">
                                    <input type="hidden" name="islem" value="add">

                                </form>

                            </div>
                        </div>

                    </div>
                </section>
            </div>

            <script src="plugins/jquery/jquery.min.js"></script>
            <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
            
            <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
            
            <script src="plugins/select2/js/select2.full.min.js"></script>
            
            <script src="dist/js/adminlte.min.js"></script>
            
            <script src="plugins/toastr/toastr.min.js"></script>

            <?php 
            if (!empty($_SESSION["msg"])) {
                $toast_message = $_SESSION["msg"][0];
                $toast = $_SESSION["msg"][1];
                echo "<script type='text/javascript'>$toast('$toast_message')</script>";
            }
            unset($_SESSION['msg']);
            ?>

            <script>
            const image_upload = (blobInfo, progress) => new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', 'imagepost.php');

                xhr.upload.onprogress = (e) => {
                    progress(e.loaded / e.total * 100);
                };

                xhr.onload = () => {
                    if (xhr.status === 403) {
                        reject({
                            message: 'HTTP Error: ' + xhr.status,
                            remove: true
                        });
                        return;
                    }

                    if (xhr.status < 200 || xhr.status >= 300) {
                        reject('HTTP Error: ' + xhr.status);
                        return;
                    }

                    const json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        reject('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    resolve(json.location);
                };

                xhr.onerror = () => {
                    reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());

                xhr.send(formData);
            });

            // codesample
            const editorConfig = {
                selector: 'textarea#classic',
                automatic_uploads: true,
                relative_urls: false,
                document_base_url: 'http://localhost/story/admin/', 
                width: "100%",
                height: 600,
                resize: false,
                autosave_ask_before_unload: false,
                images_upload_handler: image_upload,
                powerpaste_allow_local_images: true,
                plugins: [
                    'advlist', 'autolink', 'fullscreen', 'help',
                    'image', 'editimage', 'tinydrive', 'lists', 'link', 'media', 'preview',
                    'searchreplace', 'table', 'visualblocks', 'wordcount'
                ],
                toolbar: 'undo redo | blocks fontsize | bold italic underline strikethrough | outdent indent | forecolor backcolor | align bullist numlist | image media link',
                spellchecker_dialog: true,
                spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
                block_formats: 'Paragraph=p; Header 1=h1; Header 2=h2; Header 3=h3; Header 4=h4; Header 5=h5; Header 6=h6',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
            };

            tinymce.init(editorConfig);
            </script>

            <script>
            $(function() {
                $('.select2').select2()

            });

            $(function() {
                bsCustomFileInput.init();
            });
            </script>
</body>

</html>