<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
    <tbody>
        <tr>
            <td align="center">
                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-left:20px;margin-right:20px">
                    <tbody>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td style="font-family:'Open Sans',Arial,sans-serif;font-size:18px;font-weight:bold;color:#3498db"> Bạn vừa tạo thành công tài khoản tại <?=baseUrl?> </td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td style="font-family:'Open Sans',Arial,sans-serif;font-size:13px;color:#7f8c8d;line-height:24px"> 
                            Email đăng nhập: 
                            <strong><?=$post['email'];?></strong>
                            <br> Mật khẩu: <strong><?=$_POST['password'];?></strong>
                            <br> Vui lòng nhấn vào <a href="<?=baseUrl?>modules/action.php?do=confirmRegister&code=<?=$post['code']?>" target="_blank" style="color:red"><b>đây<b></a> để xác nhận.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>