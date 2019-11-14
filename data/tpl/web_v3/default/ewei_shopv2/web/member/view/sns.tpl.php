<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-lg control-label">社区等级</label>
    <div class="col-sm-9 col-xs-12">
        
        <input type="hidden" name="snsdata[level]" class="form-control" value="<?php  echo $sns_member['level'];?>"  />

        <?php  if(empty($member['aagentlevel'])) { ?>
        <?php echo empty($plugin_sns_set['levelname'])?'默认等级':$plugin_sns_set['levelname']?>
        <?php  } else { ?>
        <?php  echo pdo_fetchcolumn('select levelname from '.tablename('ewei_shop_sns_level').' where id=:id limit 1',array(':id'=>$sns_member['level']))?>
        <?php  } ?>
        
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">话题数</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php  echo $sns_member['postcount'];?></div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">评论数</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php  echo $sns_member['replycount'];?></div>
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">社区卡路里</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php  echo $sns_member['credit'];?></div>
    </div>
</div>


<div class="form-group">
    <label class="col-lg control-label">注册时间</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php  echo date('Y-m-d H:i:s',$sns_member['createtime'])?></div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">强制不自动升级</label>
    <div class="col-sm-9 col-xs-12">
        
        <input type="hidden" name="snsdata[notupgrade]" class="form-control" value="<?php  echo $member['notupgrade'];?>"  />
        <div class='form-control-static'><?php  if($sns_member['notupgrade']==1) { ?>强制不自动升级<?php  } else { ?>允许自动升级<?php  } ?></div>
        
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">黑名单</label>
    <div class="col-sm-9 col-xs-12">
        
        <div class='form-control-static'><?php  if($sns_member['isblack']==1) { ?>是<?php  } else { ?>否<?php  } ?></div>
        
    </div>
</div>
