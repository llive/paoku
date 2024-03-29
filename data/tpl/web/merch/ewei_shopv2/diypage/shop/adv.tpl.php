<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">当前位置：<span class="text-primary">启动广告管理</span></div>

<div class="page-content">

    <form action="" method="post">
        <div class="page-toolbar">
            <div class="col-sm-4">
                <?php if(mcv('diypage.shop.adv.add')) { ?>
                    <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('diypage/shop/adv/add')?>"><i class="fa fa-plus"></i> 新建启动广告</a>
                <?php  } ?>
            </div>

            <div class="col-sm-4 pull-right">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入广告标题进行搜索">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"> 搜索</button>
                    </span>
                </div>
            </div>
        </div>

        <?php  if(empty($list)) { ?>
            <div class="panel panel-default">
                <div class="panel-body empty-data">未查询到<?php  if(!empty($_GPC['keyword'])) { ?>"<?php  echo $_GPC['keyword'];?>"<?php  } ?>相关全屏广告!</div>
            </div>
        <?php  } else { ?>
            <div class="page-table-header">
                <input type="checkbox">
                <div class="btn-group">
                    <?php if(mcv('diypage.shop.adv.delete')) { ?>
                    <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要批量删除?" data-href="<?php  echo webUrl('diypage/shop/adv/delete')?>" disabled="disabled">
                        <span data-toggle="tooltip" data-placement="top" data-original-title="删除"><i class="icow icow-shanchu1"></i> 批量删除</span>
                    </button>
                    <?php  } ?>
                </div>
            </div>
            <table class="table table-hover table-responsive">
                <thead>
                <tr>
                    <th style="width:25px;"></th>
                    <th>广告名称</th>
                    <th style="width: 80px; text-align: center;">状态</th>
                    <th style="width: 100px;">创建时间</th>
                    <th style="width: 100px;">最后修改时间</th>
                    <th style="width: 70px">操作</th>
                </tr>
                </thead>
                <tbody>
                    <?php  if(is_array($list)) { foreach($list as $item) { ?>
                        <tr>
                            <td>
                                <input type="checkbox" value="<?php  echo $item['id'];?>">
                            </td>
                            <td><?php  echo $item['name'];?></td>
                            <td style="text-align: center;">
                                <?php  if(!empty($item['status'])) { ?>
                                <label class="label label-primary">已启用</label>
                                <?php  } else { ?>
                                <label class="label label-default">未启用</label>
                                <?php  } ?>
                            </td>
                            <td><?php  echo date('Y-m-d', $item['createtime'])?><br><?php  echo date('H:i:s', $item['createtime'])?></td>
                            <td><?php  echo date('Y-m-d', $item['lastedittime'])?><br><?php  echo date('H:i:s', $item['lastedittime'])?></td>
                            <td>
                                <?php if(mcv('diypage.shop.adv.edit')) { ?>
                                <a class="btn btn-op btn-operation" href="<?php  echo webUrl('diypage/shop/adv/edit', array('id'=>$item['id']))?>">
                                    <span data-toggle="tooltip" data-placement="top" data-original-title="编辑"><i class="icow icow-bianji2"></i></span>
                                </a>
                                <?php  } ?>
                                <?php if(mcv('diypage.shop.adv.delete')) { ?>
                                <a class="btn btn-op btn-operation" data-toggle="ajaxRemove" href="<?php  echo webUrl('diypage/shop/adv/delete', array('id'=>$item['id']))?>" data-confirm="确定要删除该菜单吗？">
                                    <span data-toggle="tooltip" data-placement="top" data-original-title="删除"><i class="icow icow-shanchu1"></i></span>
                                </a>
                                <?php  } ?>
                            </td>
                        </tr>
                    <?php  } } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td colspan="2">
                            <div class="btn-group">
                                <?php if(mcv('diypage.shop.adv.delete')) { ?>
                                <button class="btn btn-default btn-sm btn-operation" type="button" data-toggle="batch-remove" data-confirm="确认要批量删除?" data-href="<?php  echo webUrl('diypage/shop/adv/delete')?>" disabled="disabled">
                                    <span data-toggle="tooltip" data-placement="top" data-original-title="删除"><i class="icow icow-shanchu1"></i> 批量删除</span>
                                </button>
                                <?php  } ?>
                            </div>
                        </td>
                        <td colspan="3" style="text-align: right">
                            <?php  echo $pager;?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        <?php  } ?>

    </form>
</div>



<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->