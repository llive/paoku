<?php defined('IN_IA') or exit('Access Denied');?><div class="fui-navbar">
    <a href="<?php  echo mobileUrl('merchmanage')?>" class="external nav-item <?php  if($_W['routes']=='merchmanage') { ?>active<?php  } ?>">
        <span class="icon icon-home"></span>
        <span class="label">工作台</span>
    </a>

   
    <a href="<?php  echo mobileUrl('merchmanage/goods')?>" class="external nav-item <?php  if($_W['controller']=='goods') { ?>active<?php  } ?>">
        <span class="icon icon-goods"></span>
        <span class="label">商品</span>
    </a>

    <a href="<?php  echo mobileUrl('merchmanage/order', array('status'=>1))?>" class="external nav-item <?php  if($_W['controller']=='order') { ?>active<?php  } ?>">
        <span class="icon icon-rejectedorder"></span>
        <span class="label">订单</span>
    </a>

    <a href="<?php  echo mobileUrl('merchmanage/apply/manage')?>" class="external nav-item <?php  if($_W['controller']=='apply') { ?>active<?php  } ?>">
        <span class="icon icon-home"></span>
        <span class="label">结算</span>
    </a>
    

    <a href="<?php  echo mobileUrl('merchmanage/shop')?>" class="external nav-item <?php  if($_W['controller']=='shop') { ?>active<?php  } ?>">
        <span class="icon icon-set"></span>
        <span class="label">设置</span>
    </a>
</div>
