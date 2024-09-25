<div class="buttonCart">
    <a onclick="addCart(<?=$data->id ?>,'[data-id=<?=$data->id?>] img')" <?=linkMenu($menuShop); ?> >
      <i class="fa fa-money"></i> Mua ngay
    </a>
    <a onclick="addCart(<?=$data->id ?>,'[data-id=<?=$data->id?>] img')">
      <i class="fa fa-cart-plus"></i> Thêm vào giỏ hàng
    </a>
</div>