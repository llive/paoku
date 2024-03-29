<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">当前位置：<span class="text-primary">下载对账单</span></div>
<div class="page-content">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <div class="summary_box">
            <div class="summary_title">
                <span class=" title_inner">下载对账单</span>
            </div>
            <div class="summary_lg">
                <p>每日9:00前完成数据更新，当前数据更新至 <?php  echo date('Y-m-d')?></p>
                <p>微信在次日9点启动生成前一天的对账单，建议商户10点后再获取；</p>
                <p>对账单中涉及金额的字段单位为“元”。</p>
                <p>下载账单接口为单日期接口，请尽量保持账单时间段不要过长。</p>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label">账单类型</label>
            <div class="col-sm-9 col-xs-12">
                <label class='radio-inline'>
                    <input type='radio' value='ALL' name='type' checked/> 所有账单
                </label>
                <label class='radio-inline'>
                    <input type='radio' value='SUCCESS' name='type'/> 支付账单
                </label>
                <label class='radio-inline'>
                    <input type='radio' value='REFUND' name='type'/> 退款帐单
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label">数据类型</label>
            <div class="col-sm-9 col-xs-12">
                <label class='radio-inline'>
                    <input type='radio' value='' name='datatype' checked/> 所有账单
                </label>
                <label class='radio-inline'>
                    <input type='radio' value='1' name='datatype'/> 仅商城账单
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label">账单时间</label>
            <div class="col-sm-9 col-xs-12">
                <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d', $starttime),'endtime'=>date('Y-m-d', $endtime)));?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg control-label"></label>
            <div class="col-sm-9 col-xs-12">
                <input type='hidden' name='token' value="<?php  echo $_W['token'];?>"/>
                <input name="submit" type="submit" value="下载对账单" class="btn btn-primary span2">
            </div>
        </div>
    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>