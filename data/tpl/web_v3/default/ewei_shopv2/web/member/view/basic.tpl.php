<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-lg control-label">粉丝</label>
    <div class="col-sm-9 col-xs-12">
        <img class="radius50" src="<?php  echo $member['avatar'];?>" style='width:50px;height:50px;padding:1px;border:1px solid #ccc' onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"/>
        <?php  if(strexists($member['openid'],'sns_wa')) { ?><i class="icow icow-xiaochengxu" style="color: #7586db;vertical-align: middle;" data-toggle="tooltip" data-placement="bottom" data-original-title="来源: 小程序"></i><?php  } ?>
        <?php  if(strexists($member['openid'],'sns_qq')||strexists($member['openid'],'sns_wx')||strexists($member['openid'],'wap_user')) { ?><i class="icow icow-app" style="color: #44abf7;vertical-align: middle;" data-toggle="tooltip" data-placement="bottom" data-original-title="来源: 全网通(<?php  if(strexists($member['openid'],'wap_user')) { ?>手机号注册<?php  } else { ?>APP<?php  } ?>)"></i><?php  } ?>
        <?php  echo $member['nickname'];?>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">OPENID</label>
    <div class="col-sm-9 col-xs-12">
        <div class="form-control-static js-clip text-primary" data-url='<?php  echo $member['openid'];?>'><?php  echo $member['openid'];?></div>
</div>
</div>
<div class="form-group">
    <label class="col-lg control-label">会员等级</label>
    <div class="col-sm-9 col-xs-12">
        
        <div class='form-control-static'>
            <?php  if(empty($member['level'])) { ?>
            <?php echo empty($shop['levelname'])?'普通会员':$shop['levelname']?>
            <?php  } else { ?>
            <?php  echo pdo_fetchcolumn('select levelname from '.tablename('ewei_shop_member_level').' where id=:id limit 1',array(':id'=>$member['level']))?>
            <?php  } ?>
        </div>
        
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">标签组</label>
    <div class="col-sm-9 col-xs-12">
        
        <div class='form-control-static'>
            <?php  if(empty($member['groupid'])) { ?>
            无标签组
            <?php  } else { ?>
            <?php  echo pdo_fetchcolumn('select groupname from '.tablename('ewei_shop_member_group').' where id=:id limit 1',array(':id'=>$member['groupid']))?>
            <?php  } ?>
        </div>
        
    </div>
</div>


<div class="form-group">
    <label class="col-lg control-label">真实姓名</label>
    <div class="col-sm-9 col-xs-12">
        
        <div class='form-control-static'><?php  echo $member['realname'];?></div>
        
    </div>
</div>

<?php  if(!$openbind) { ?>
<div class="form-group">
    <label class="col-lg control-label">手机号</label>
    <div class="col-sm-9 col-xs-12">
        
        <div class='form-control-static'><?php  echo $member['mobile'];?></div>
        
    </div>
</div>
<?php  } ?>

<div class="form-group">
    <label class="col-lg control-label">微信号</label>
    <div class="col-sm-9 col-xs-12">
        
        <div class='form-control-static'><?php  echo $member['weixin'];?></div>
        
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">卡路里上限</label>
    <div class="col-sm-9">


        <span class="input-group">

            <label class="radio-inline"><input type="radio" class="btn-maxcredit" value="0" <?php  if(empty($member['diymaxcredit'])) { ?>checked<?php  } ?> <?php if(cv('finance.recharge.credit1')) { ?> name="data[diymaxcredit]" <?php  } else { ?>disabled<?php  } ?>>读取系统设置</label>
            <label class="radio-inline"><input type="radio" class="btn-maxcredit" value="1" <?php  if(!empty($member['diymaxcredit'])) { ?>checked<?php  } ?> <?php if(cv('finance.recharge.credit1')) { ?> name="data[diymaxcredit]" <?php  } else { ?>disabled<?php  } ?>>自定义</label>


            <input type="number" class="form-control  maxcreditinput input-sm" value="<?php  echo intval($member['maxcredit'])?>" style="margin-left:5px;float: right; display: <?php  if(empty($member['diymaxcredit'])) { ?>none<?php  } else { ?>inline-block<?php  } ?>; width: 150px;" <?php if(cv('finance.recharge.credit1')) { ?> name="data[maxcredit]" <?php  } else { ?>disabled<?php  } ?>>
            </span>


        <?php if(cv('finance.recharge.credit1')) { ?>
        <span class='help-block text-danger'>会员卡路里上限，0为不限制(后台手动充值不限制，已持有卡路里不限制，保存后生效)</span>
        <?php  } ?>
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">卡路里</label>
    <div class="col-sm-3">
        <div class='form-control-static'><?php  echo $member['credit1'];?>
            <a class="text-primary " data-toggle='ajaxModal' href="<?php  echo webUrl('finance/recharge', array('type'=>'credit1','id'=>$member['id']))?>" style="padding-left: 5px;">充值</a>
        </div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">余额</label>
    <div class="col-sm-3">
        <div class='form-control-static'><?php  echo $member['credit2'];?>
            <?php if(cv('finance.recharge.credit2')) { ?>
                <a class="text-primary " data-toggle='ajaxModal' href="<?php  echo webUrl('finance/recharge', array('type'=>'credit2','id'=>$member['id']))?>" style="padding-left: 5px;">充值</a>
            <?php  } ?>
        </div>
    </div>
</div> <div class="form-group">
    <label class="col-lg control-label">注册时间</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php  echo date("Y-m-d H:i:s",$member['createtime'])?></div>
    </div>
</div>


<?php  if(!empty($member['birthyear'])) { ?>
<div class="form-group">
    <label class="col-lg control-label">出生日期</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php  echo $member['birthyear'];?>-<?php  echo $member['birthmonth'];?>-<?php  echo $member['birthday'];?></div>
    </div>
</div>
<?php  } ?>

<?php  if(!empty($member['idnumber'])) { ?>
<div class="form-group">
    <label class="col-lg control-label">身份证号</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php  echo $member['idnumber'];?></div>
    </div>
</div>
<?php  } ?>

<div class="form-group">
    <label class="col-lg control-label">关注状态</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'>
            <?php  $followed = m('user')->followed($member['openid'])?>
            <?php  if(!$followed) { ?>
            <?php  if(empty($member['uid'])) { ?>
            <label class='label label-default'>未关注</label>
            <?php  } else { ?>
            <label class='label label-warning'>取消关注</label>
            <?php  } ?>
            <?php  } else { ?>
            <label class='label label-success'>已关注</label>
            <?php  } ?>

        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">黑名单</label>
    <div class="col-sm-9 col-xs-12">
        
        <input type='hidden' name='data[isblack]' value='<?php  echo $member['isblack'];?>' />
        <div class='form-control-static'><?php  if($member['isblack']==1) { ?>是<?php  } else { ?>否<?php  } ?></div>
        

    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">备注</label>
    <div class="col-sm-9 col-xs-12">
        
        <div class='form-control-static'><?php  echo $member['content'];?></div>
        
    </div>
</div>


<?php  if($openbind) { ?>
<div class="form-group-title">用户绑定  </div>
    <?php  if(!empty($_W['shopset']['wap']['open'])) { ?>
        <div class="alert alert-danger">以下信息修改后会导致用户无法登录WAP端，如需更改请告知该用户！</div>
    <?php  } ?>

<div class="form-group">
    <label class="col-lg control-label">手机号码</label>
    <div class="col-sm-9 col-xs-12">
        
        <div class='form-control-static'><?php  echo $member['mobile'];?></div>
        
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">绑定手机号</label>
    <div class="col-sm-9 col-xs-12">
        
        <div class="form-control-static"><?php  if(empty($member['mobileverify'])) { ?>未绑定<?php  } else { ?>已绑定<?php  } ?></div>
        
    </div>
</div>


<?php  } ?>

<?php  if($diyform_flag == 1) { ?>
    <div class="form-group-title">自定义表单信息</div>
    <?php  $datas = iunserializer($member['diymemberdata'])?>
    <?php  if(is_array($fields)) { foreach($fields as $key => $value) { ?>
    <div class="form-group">
        <label class="col-lg control-label"><?php  echo $value['tp_name']?></label>
        <div class="col-sm-9 col-xs-12">
            <div class="form-control-static">
                <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('diyform/diyform', TEMPLATE_INCLUDEPATH)) : (include template('diyform/diyform', TEMPLATE_INCLUDEPATH));?>
            </div>
        </div>
    </div>
    <?php  } } ?>
<?php  } ?>

<script type="text/javascript">
    $(function () {
        $(".btn-maxcredit").unbind('click').click(function () {
            var val = $(this).val();
            if(val==1){
                $(".maxcreditinput").css({'display':'inline-block'});
            }else{
                $(".maxcreditinput").css({'display':'none'});
            }
        });
    })
</script>