<form class="contactAjax" action="contact">
    <p class="name">
      <input type="hidden" name="lang" value="<?php echo $lang; ?>">
      <input type="hidden" name="gmail" value="<?php echo $infoPage->gmail; ?>">
      <input class="form-control" name="title" type="text" placeholder="Họ tên" id="name" />
    </p>

    <p class="email">
      <input class="form-control" name="email" type="text" id="email" placeholder="Email" />
    </p>
    <p class="text">
      <input class="form-control" name="phone" type="text" placeholder="Số điện thoại" />
    </p>
    <p class="text">
      <input class="form-control" name="address" type="text" placeholder="Địa chỉ của bạn" />
    </p>
    <p class="text">
      <textarea type="text" placeholder="Nội dung tin nhắn" class="md-textarea"></textarea>
    </p>
    <?php
      /*showCaptcha();*/
    ?>
    <div class="submit">
      <input type="submit" value="GỬI TIN NHẮN"  class="form-control btn btn-primary"/>
    </div>
</form>