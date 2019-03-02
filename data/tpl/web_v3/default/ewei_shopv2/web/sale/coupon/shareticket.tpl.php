<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type="text/css">
    .table_kf {display: none;}
    .table_kf.active {display: table-row-group;}
</style>
<div class="page-header">
    当前位置：<span class="text-primary">分享发券</span>
</div>
<div class="page-content">
    <div class="page-toolbar">
        <span class=''>
        <?php if(cv('sale.gift.add')) { ?>
        <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('sale/coupon/shareticket/add',array('type'=>$type))?>"><i class='fa fa-plus'></i> 添加活动</a>
        <?php  } ?>
    </span>
    </div>
    <ul class="nav nav-arrow-next nav-tabs" id="myTab">
        <li class="active" style="position: relative;">
            <a href="<?php  echo webUrl('sale/coupon/shareticket')?>">分享发券</a>
            <span style="position:absolute;right: 9px;top: -7px;"><img src="../addons/ewei_shopv2/static/images/new.png" alt="" ></span>
        </li>
        <li style="position: relative;">
            <a href="<?php  echo webUrl('sale/coupon/setticket')?>">新人发券</a>
            <span style="position:absolute;right: 9px;top: -7px;"><img src="../addons/ewei_shopv2/static/images/new.png" alt="" ></span>
        </li>
        <li>
            <a href="<?php  echo webUrl('sale/coupon/sendtask')?>">满额送券</a>
        </li>
        <li >
            <a href="<?php  echo webUrl('sale/coupon/goodssend')?>">购物送券</a>
        </li>
        <li >
            <a href="<?php  echo webUrl('sale/coupon/usesendtask')?>">用券送券</a>
        </li>

    </ul>
    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">
        <input type='hidden' id='tab' name='type' value="<?php  echo $_GPC['type'];?>"/>
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r"  value="sale.sendticket.share" />


    </form>
    <form action="" method="post">
        <?php  if(count($gifts)>0) { ?>
        <table class="table table-hover table-responsive">
            <thead class="navbar-inner">

            <tr>
                <th style="width:60px;text-align:center;">排序</th>
                <th>分享名称</th>
                <th style="width:80px;">发送条件</th>
                <th style="width:80px;">活动状态</th>
                <th  style="width:90px;" >开关状态</th>
                <th style="width:75px;text-align: center;">操作</th>
            </tr>
            </thead>
            <tbody class=" table_kf <?php  if($_GPC['type']=='all' || empty($_GPC['type'])) { ?>active<?php  } ?>" id="tab_all"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('sale/coupon/shareticket/list', TEMPLATE_INCLUDEPATH)) : (include template('sale/coupon/shareticket/list', TEMPLATE_INCLUDEPATH));?></tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right"><?php  echo $pager;?></td>
                </tr>
            </tfoot>
        </table>
        <?php  } else { ?>
        <div class='panel panel-default'>
            <div class='panel-body' style='text-align: center;padding:30px;'>
                暂时没有任何分享活动!
            </div>
        </div>
        <?php  } ?>
    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->