<div class="modal fade has-loading" id="modal-register" tabindex="-1">
    <div class="modal-dialog">
        <form class="contactAjax" action="register">
            <div class="card">
                <div class="card-block">
                    <div class="form-header red">
                        <h3><i class="fa fa-user-plus"></i> Đăng Ký</h3>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-user prefix"></i>
                        <input required type="text" id="form3" class="form-control" name="title" placeholder="">
                        <label for="form3">Họ tên</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-phone prefix"></i>
                        <input required type="text" id="form1" class="form-control" name="phone">
                        <label for="form1">Số điện thoại</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-envelope prefix"></i>
                        <input required type="text" id="form2" class="form-control" name="email">
                        <label for="form2">Email</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-lock prefix"></i>
                        <input required type="password" id="form4" class="form-control" name="password">
                        <label for="form4">Mật khẩu</label>
                    </div>
                    <div class="md-form">
                        <i class="fa fa-lock prefix"></i>
                        <input required type="password" id="form5" class="form-control" name="passwordCheck">
                        <label for="form5">Nhập lại mật khẩu</label>
                    </div>
                    <div class="md-form">
                        <center>
                            <button type="submit" class="btn btn-danger">Đăng ký</button>
                            <p>
                                <a onclick="$('#modal-register').modal('hide');"  data-toggle="modal" data-target="#modal-login" class="text-info">Đăng nhập</a> nếu bạn có tài khoản !
                            </p>
                        </center>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade has-loading" id="modal-login" tabindex="-1">
    <div class="modal-dialog">
        <form class="contactAjax" action="login">
        <div class="card">
            <div class="card-block">
                <div class="form-header blue">
                    <h3><i class="fa fa-user"></i> Đăng nhập</h3>
                </div>
                <div class="md-form">
                    <i class="fa fa-envelope prefix"></i>
                    <input required type="text" id="form2" class="form-control" name="email">
                    <label for="form2">Email</label>
                </div>

                <div class="md-form">
                    <i class="fa fa-lock prefix"></i>
                    <input required type="password" id="form4" class="form-control" name="password">
                    <label for="form4">Mật khẩu</label>
                </div>
                <div class="md-form">
                    <center>
                        <button type="submit" class="btn btn-info">Đăng nhập</button>
                        <p>
                            <a onclick="$('#modal-login').modal('hide');" data-toggle="modal" data-target="#modal-register" class="text-danger">Đăng ký</a> nếu bạn chưa có tài khoản !
                        </p>
                    </center>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>