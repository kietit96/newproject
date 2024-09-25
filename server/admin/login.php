<?php
include_once("../config.php");
include_once("../modules/control.php");
if ($_POST) {
  if ($_POST['password'] !== '' && $_POST['user'] !== '') {
    $userP = $_POST['user'];
    $pass = $_POST['password'];
    setcookie('password', $pass, time() + 43200, '/');
    setcookie('user', $userP, time() + 43200, '/');
    header("Refresh:0");
  }
}

if ($author) {
  $location = '.';
  if (isset($_GET['location'])) {
    $location = $_GET['location'];
  }
  header("Location: " . $location);
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

  <title>Đăng nhập</title>

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
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Chào mừng trở lại!</h1>
                  </div>
                  <form class="user" method="POST">

                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Nhập tài khoản email..." name="user">
                    </div>

                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Mật khẩu" name="password">
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Đăng nhập
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot.php">Quên mật khẩu?</a>
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
  <script src="new-template/vendor/jquery/jquery-3.1.1.min.js"></script>
  <script src="new-template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="new-template/vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="new-template/js/sb-admin-2.min.js"></script>
</body>

</html>