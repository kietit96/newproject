<?php
  include_once ("../config.php");
  include_once ("../modules/control.php");
  $message = false;
  if($_POST){
    if (isset($_POST['user']) && $_POST['user'] !== '') {
      $userP = $_POST['user'];
      setcookie('forgotemail', $userP, time() + 36000000000,'/');
      $message = "Đã có một email gửi đến bạn, để thay đổi mật khẩu. Vui lòng kiểm tra!";
    }
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
                    <h1 class="h4 text-gray-900 mb-2">Quên mật khẩu?</h1>
                    <p class="mb-4">Chúng tôi hiểu, chỉ là chuyện nhỏ. Chỉ cần nhập địa chỉ email của bạn dưới đây và chúng tôi sẽ gửi cho bạn một liên kết để đặt lại mật khẩu của bạn!</p>
                  </div>
                  <?php if ($message): ?>
                    <div class="alert alert-success" role="alert">
                      <?php echo $message ?>
                    </div>
                  <?php endif ?>
                  <form class="user" method="POST">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Nhập tài khoản email..." name="user">
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

  <?php if ($message): ?>
    <script type="text/javascript">
      $(function(){
        $.ajax({
          'url': '../modules/action.php?do=forgotpassword'
        }).done(function( data ) {
            console.log('forgotemail updated!');
        });
      })
    </script>
  <?php endif ?>

</body>

</html>
