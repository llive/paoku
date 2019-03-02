<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary"><?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>问题 <small><?php  if(!empty($item['id'])) { ?>修改【<?php  echo $item['title'];?>】<?php  } ?></small></span>
</div>
<div class="page-content">
    <form  <?php if( ce('qa.question' ,$item) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data" >

                <div class="form-group">
                    <label class="col-lg control-label">排序</label>
                    <div class="col-sm-10 col-xs-12">
                        <?php if( ce('qa.question' ,$item) ) { ?>
                        	<input type="text" name="displayorder" class="form-control" value="<?php  echo $item['displayorder'];?>" />
                        <?php  } else { ?>
                        	<div class='form-control-static'><?php  echo $item['displayorder'];?></div>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg control-label must">问题标题</label>
                    <div class="col-sm-10 col-xs-12">
                        <?php if( ce('qa.question' ,$item) ) { ?>
                        <input type="text" name="title" class="form-control" value="<?php  echo $item['title'];?>" data-rule-required="true" />
                        <?php  } else { ?>
                        <div class='form-control-static'><?php  echo $item['title'];?></div>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg control-label">问题关键字</label>
                    <div class="col-sm-10 col-xs-12">
                        <?php if( ce('qa.question' ,$item) ) { ?>
                        <input type="text" name="keywords" class="form-control" value="<?php  echo $item['keywords'];?>" />
                        <div class="help-block">问题关键字提供更精准的搜索推送服务, 并非入口关键字, 多个请以半角逗号隔开</div>
                        <?php  } else { ?>
                        <div class='form-control-static'><?php  echo $item['keywords'];?></div>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg control-label must">问题内容</label>
                    <div class="col-sm-10 col-xs-12">
                        <?php if( ce('qa.question' ,$item) ) { ?>
                        <?php  echo tpl_ueditor('content',$item['content'],array('height'=>'400'))?>
                        <?php  } else { ?>
                        <textarea id='questioncontent' style='display:none;'><?php  echo $item['content'];?></textarea>
                        <a href='javascript:preview_html("#questioncontent")' class="btn btn-default">查看内容</a>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg control-label">问题分类</label>
                    <div class="col-sm-10 col-xs-12">
                        <?php if( ce('qa.question' ,$item) ) { ?>
                        <select name="cate" class="form-control" data-rule-required="true" >
                            <?php  if(is_array($category)) { foreach($category as $cate) { ?>
                            <option value="<?php  echo $cate['id'];?>" <?php  if($cate['id']==$item['cate']) { ?>selected<?php  } ?>><?php  echo $cate['name'];?></option>
                            <?php  } } ?>
                        </select>
                        <?php  } else { ?>
                        <div class='form-control-static'>
                            <?php  if(is_array($category)) { foreach($category as $cate) { ?>
                                <?php  if($cate['id']==$item['cate']) { ?>
                                    <?php  echo $cate['name'];?>
                                <?php  } ?>
                            <?php  } } ?>
                        </div>
                        <?php  } ?>
                    </div>
                </div>
                <div class="form-group">
                        <label class="col-lg control-label">是否推荐</label>
                        <div class="col-sm-10 col-xs-12">
                             <?php if( ce('qa.goods' ,$item) ) { ?>
                            <label class="radio-inline">
                                <input type="radio" name='isrecommand' value="1" <?php  if($item['isrecommand']==1) { ?>checked<?php  } ?> /> 是
                            </label>
	                            <label class="radio-inline">
	                                <input type="radio" name='isrecommand' value="0" <?php  if(empty($item['isrecommand'])) { ?>checked<?php  } ?> /> 否
	                            </label>
                             <?php  } else { ?>
                             	<div class='form-control-static'><?php  if(empty($item['isrecommand'])) { ?>是<?php  } else { ?>否<?php  } ?></div>
                             <?php  } ?>
                        </div>
                    </div>
                
                <div class="form-group">
                    <label class="col-lg control-label">是否显示</label>
                    <div class="col-sm-10 col-xs-12">
                        <?php if( ce('qa.question' ,$item) ) { ?>
                        <label class='radio-inline'>
                            <input type='radio' name='status' value=1' <?php  if($item['status']==1) { ?>checked<?php  } ?> /> 是
                        </label>
	                        <label class='radio-inline'>
	                            <input type='radio' name='status' value=0' <?php  if($item['status']==0) { ?>checked<?php  } ?> /> 否
	                        </label>
                        <?php  } else { ?>
                        	<div class='form-control-static'><?php  if(empty($item['status'])) { ?>否<?php  } else { ?>是<?php  } ?></div>
                        <?php  } ?>
                    </div>
                </div>

                <div class="form-group"></div>
                <div class="form-group">
                    <label class="col-lg control-label"></label>
                    <div class="col-sm-10 col-xs-12">
                         <?php if( ce('qa.question' ,$item) ) { ?>
                            <input type="submit" value="提交" class="btn btn-primary"  />
                        <?php  } ?>
                       <input type="button" name="back" onclick='history.back()' <?php if(cv('qa.question.add|qa.question.edit')) { ?>style='margin-left:10px;'<?php  } ?> value="返回列表" class="btn btn-default" />
                    </div>
                </div>

 

    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>


<!--4000097827-->