<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('merchmanage/common', TEMPLATE_INCLUDEPATH)) : (include template('merchmanage/common', TEMPLATE_INCLUDEPATH));?>

<div class='fui-page fui-page-current'>
    <div class="fui-header fui-header-success">
        <div class="fui-header-left">
            <?php  if($goshop) { ?>
                <a class="back external" href="<?php  echo mobileUrl()?>">商城</a>
            <?php  } ?>
        </div>
        <div class="title">用户登录</div>
        <div class="fui-header-right"></div>
    </div>
    <div class='fui-content page-login'>

        <div class="panel-logo">
            <img src="<?php  echo $logo;?>" />
        </div>
        <div class="panel-login">
            <div class="fui-cell-group fui-cell-group-o">
                <div class="fui-cell">
                    <div class="fui-cell-info">
                        <input type="text" placeholder="请输入用户名" class="fui-input" id="username" />
                    </div>
                </div>
                <div class="fui-cell">
                    <div class="fui-cell-info">
                        <input type="password" placeholder="请输入密码" class="fui-input" id="password" />
                    </div>
                </div>
            </div>
            <div class="btn btn-success block btn-submit" data-type="" id="btn-submit">登录</div>
        </div>
    </div>

    <script language="javascript">
        require(['../addons/ewei_shopv2/plugin/merchmanage/static/js/base.js'],function(modal){
            modal.initLogin({backurl:"<?php  echo $backurl;?>"});
        });
    </script>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>