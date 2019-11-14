<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-lg control-label">上级分销商</label>
    <div class="col-sm-9 col-xs-12">
        <input type="hidden" value="<?php  echo $member['agentid'];?>" id='agentid' name='adata[agentid]' class="form-control"  />

        <?php if(cv('commission.agent.changeagent')) { ?>

        
        <div class='form-control-static'>
            <?php  if(!empty($parentagent)) { ?><img  style="width:100px;height:100px;border:1px solid #ccc;padding:1px" src="<?php  echo $parentagent['avatar'];?>"/><?php  } else { ?>无<?php  } ?>
        </div>
        

        <?php  } else { ?>
        <div class='form-control-static'>
            <input type="hidden" value="<?php  echo $member['agentid'];?>" id='agentid' name='adata[agentid]' class="form-control"  />
            <?php  if(!empty($parentagent)) { ?><img  style="width:100px;height:100px;border:1px solid #ccc;padding:1px" src="<?php  echo tomedia($parentagent['avatar'])?>"/><?php  } else { ?>无<?php  } ?>
        </div>
        <?php  } ?>

    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">是否固定上级</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('commission.agent.changeagent')) { ?>
        
        <input type='hidden' name='adata[fixagentid]' value='<?php  echo $member['fixagentid'];?>' />
        <div class='form-control-static'><?php  if($member['fixagentid']==1) { ?>是<?php  } else { ?>否<?php  } ?></div>
        
        <?php  } else { ?>
        <input type='hidden' name='adata[fixagentid]' value='<?php  echo $member['fixagentid'];?>' />
        <div class='form-control-static'><?php  if($member['fixagentid']==1) { ?>是<?php  } else { ?>否<?php  } ?></div>
        <?php  } ?>

    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">分销商等级</label>
    <div class="col-sm-9 col-xs-12">
        
        <input type="hidden" name="adata[agentlevel]" class="form-control" value="<?php  echo $member['agentlevel'];?>"  />

        <?php  if(empty($member['agentlevel'])) { ?>
        <?php echo empty($plugin_com_set['levelname'])?'普通等级':$plugin_com_set['levelname']?>
        <?php  } else { ?>
        <?php  echo pdo_fetchcolumn('select levelname from '.tablename('ewei_shop_commission_level').' where id=:id limit 1',array(':id'=>$member['agentlevel']))?>
        <?php  } ?>
        
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">累计佣金</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'> <?php  echo $member['commission_total'];?></div>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label">已打款佣金</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'> <?php  echo $member['commission_pay'];?></div>
    </div>
</div>
<?php  if($member['agenttime']!='1970-01-01 08:00') { ?>
<div class="form-group">
    <label class="col-lg control-label">成为分销商时间</label>
    <div class="col-sm-9 col-xs-12">
        <div class='form-control-static'><?php  echo $member['agenttime'];?></div>
    </div>
</div>
<?php  } ?>
<div class="form-group">
    <label class="col-lg control-label">分销商权限</label>
    <div class="col-sm-9 col-xs-12">
        
        <input type='hidden' name='adata[isagent]' value='<?php  echo $member['isagent'];?>' />
        <div class='form-control-static'><?php  if($member['isagent']==1) { ?>是<?php  } else { ?>否<?php  } ?></div>
        

    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">审核通过</label>
    <div class="col-sm-9 col-xs-12">
        
        <input type='hidden' name='adata[status]' value='<?php  echo $member['status'];?>' />
        <div class='form-control-static'><?php  if($member['status']==1) { ?>是<?php  } else { ?>否<?php  } ?></div>
        
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">强制不自动升级</label>
    <div class="col-sm-9 col-xs-12">
        
        <input type="hidden" name="adata[agentnotupgrade]" class="form-control" value="<?php  echo $member['agentnotupgrade'];?>"  />
        <div class='form-control-static'><?php  if($member['agentnotupgrade']==1) { ?>强制不自动升级<?php  } else { ?>允许自动升级<?php  } ?></div>
        
    </div>
</div>

<div class="form-group">
    <label class="col-lg control-label">自选商品</label>
    <div class="col-sm-9 col-xs-12">
        
        <input type="hidden" name="adata[agentselectgoods]" class="form-control" value="<?php  echo $member['agentselectgoods'];?>"  />
        <div class='form-control-static'><?php  if($member['agentnotselectgoods']==1) { ?>
            强制禁止
            <?php  } else if($member['agentselectgoods']==2) { ?>
            强制允许
            <?php  } else { ?>
            <?php  if($plugin_com_set['select_goods']==1) { ?>系统允许<?php  } else { ?>系统禁止<?php  } ?>
            <?php  } ?></div>
        
    </div>
</div>

<?php  if($diyform_flag_commission == 1) { ?>
    <div class='form-group-title'>自定义表单信息</div>

    <?php  $datas = iunserializer($member['diycommissiondata'])?>
    <?php  if(is_array($cfields)) { foreach($cfields as $key => $value) { ?>
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


<script language='javascript'>

    function search_members() {
        if ($.trim($('#search-kwd-notice').val()) == '') {
            Tip.focus('#search-kwd-notice', '请输入关键词');
            return;
        }
        $("#module-menus-notice").html("正在搜索....")
        $.get('<?php  echo webUrl('commission/agent/query')?>', {
            keyword: $.trim($('#search-kwd-notice').val()), 'op': 'query', selfid: "<?php  echo $id;?>"
        }, function (dat) {
            $('#module-menus-notice').html(dat);
        });
    }
    function select_member(o) {
        $("#agentid").val(o.id);
        $("#parentagentavatar").show();
        $("#parentagentavatar").find('img').attr('src', o.avatar);
        $("#parentagent").val(o.nickname + "/" + o.realname + "/" + o.mobile);
        $("#modal-module-menus-notice .close").click();
    }
    function chooseAgent() {
        popwin = $('#modal-module-menus-notice').modal();
    }
    function clearAgent() {
        tip.confirm("确定清除上级分销商吗？(保存后生效)", function () {
            $('#agentid').val('');
            $('#parentagent').val('');
            $('#parentagentavatar').hide();
        });
    }

</script>