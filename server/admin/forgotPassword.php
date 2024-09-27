<?php
  include_once ("../config.php");
  include_once ("../modules/control.php");
  $message = false;
  if (isset($_GET['code']) && $_GET['code'] !== '') {
    $codeP = $_GET['code'];
    $findCode = $db->alone_data_where("user", "code", $codeP);
    if (!$findCode)
      die();

    if (count($_POST) && isset($_POST['password']) && isset($_POST['password_confirm'])) {
      $checkFailed = false;
      if (empty($_POST['password'])) {
        $message = "Mật khẩu không được để trống!";
        $checkFailed = true;
      }

      if ($_POST['password'] !== $_POST['password_confirm']) {
        $message = "Mật khẩu không trùng khớp!";
        $checkFailed = true;
      }

      if (!$checkFailed) {
        $password = md5($_POST['password']);

        $doUpdate = $db->updateRow("user", ["password" => $password, "code" => md5(time())], "code", $codeP);
        if ($doUpdate) {
          header("Location: ". baseUrl.'admin');
        }
      }
    }
  } else {
    die();
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Thay đổi mật khẩu</title>

  <!-- Custom fonts for this template-->
  <link href="new-template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="new-template/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Thay đổi mật khẩu</h1>
                  </div>
                  <?php if ($message): ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $message ?>
                    </div>
                  <?php endif ?>
                  <form class="user" method="POST">
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Nhập mật khẩu..." name="password">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Nhập lại mật khẩu.." name="password_confirm">
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Thay đổi Mật khẩu
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="login.php">Bạn đã có tài khoản? Đăng nhập!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="new-template/vendor/jquery/jquery.min.js"></script>
  <script src="new-template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="new-template/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="new-template/js/sb-admin-2.min.js"></script>

</body>

</html>
