<?php defined('IN_IA') or exit('Access Denied');?><div class='alert alert-primary'>
            幻灯片设置 <small>幻灯片图片尺寸建议 640*320  拖动改变位置</small>
        </div>
		 

			<div class="form-group">
                            
				<div class="col-sm-12">
					<table class="table">
						<thead>
						<th style="width:60px;"></th>
						<th  style="width:400px;">图片</th>
						<th  style="width:300px;">链接</th>
						<th>操作</th>
						</thead>
						<tbody id="tbody">
							<?php  if(is_array($advs)) { foreach($advs as $adv) { ?>
							<tr class="adv-item">
								<td><a href="javascript:;" class="btn btn-default btn-sm btn-move"><i class="fa fa-arrows"></i></a></td>
								<td>
									<div class="input-group img-item">
										<div class="input-group-addon">
											<img src="<?php  echo tomedia($adv['img'])?>" style="height:100%;width:50px" />
										</div>
										<input type="text" class="form-control" name="adv_img[]" value="<?php  echo $adv['img'];?>" />
										<div class="input-group-btn">
											<button type="button" class="btn btn-default btn-select-pic">选择图片</button>
										</div>
									</div>
								</td>
								<td><input type="text" class="form-control" name="adv_url[]" value="<?php  echo $adv['url'];?>"/></td>
								<td><button type="button" class="btn btn-danger  btn-sm" onclick="removeAdv(this)"><i class="fa fa-remove"></i></button>

								</td>
							</tr>
							<?php  } } ?>
						</tbody>
						<tbody>
							<tr>
								<td colspan="4"><button type="button" class="btn btn-default  btn-sm" onclick="addAdv()"><i class="fa fa-plus"></i> 添加幻灯片</button></td>
							</tr>
					</table>
					
				</div>
			</div>	
 
 
 
<!--NDAwMDA5NzgyNw==-->