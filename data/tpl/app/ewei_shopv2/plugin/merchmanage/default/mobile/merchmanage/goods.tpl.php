<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('merchmanage/common', TEMPLATE_INCLUDEPATH)) : (include template('merchmanage/common', TEMPLATE_INCLUDEPATH));?>

<div class='fui-page fui-page-current'>
    <div class="fui-header fui-header-success">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">商品管理</div>
        <div class="fui-header-right">
            <a class="btn-more batch-hide">更多</a>
            <a class="batch-cancel batch-item">取消</a>
        </div>
    </div>
    <!-- 顶部tab -->
    <div id="tab" class="fui-tab fui-tab-success fixed">
        <a class="active" data-status="sale">出售中</a>
        <a data-status="out">已售罄</a>
        <a data-status="stock">仓库中</a>
        <a data-status="cycle">回收站</a>
    </div>
    <div class='fui-content navbar'>

        <!-- 搜索框 -->
        <div class="fui-searchbar bar">
            <div class="searchbar center">
                <input type="submit" class="searchbar-cancel searchbtn" value="搜索" />
                <div class="search-input">
                    <i class="icon icon-search"></i>
                    <input type="search" placeholder="输入关键字..." class="search" id="keywords" />
                </div>
            </div>
        </div>

        <!-- 商品列表 -->
        <div class="fui-list-group nomargin container"></div>

        <div class="fui-title center" id="content-more">加载更多</div>
        <div class="fui-title center hide" id="content-empty">没有数据</div>
        <div class="fui-title center hide" id="content-nomore">没有更多了</div>
    </div>

    <div class="head-menu-mask"></div>
    <div class="head-menu">
       
        <a class="batch-btn"><i class="icon icon-squarecheck"></i> 批量管理</a>
        
            <a class="external" href="<?php  echo mobileUrl('merchmanage/goods/add')?>"><i class="icon icon-add3"></i> 添加商品</a>
        
    </div>

    <div class="fui-footer batch-item">
        <div class="fui-list noclick">
            <div class="fui-list-media">
                <label class="checkbox-inline checkall">
                    <input type="checkbox" name="checkbox" class="fui-radio fui-radio-success " />&nbsp;全选</label>
            </div>
            <div class="fui-list-inner">
            </div>
           
                <div class="fui-list-angle hide batch-putoff">
                    <div class="btn btn-sm btn-success btn-goods-batch" data-action="status" data-status="0">批量下架</div>
                </div>
                <div class="fui-list-angle hide batch-puton">
                    <div class="btn btn-sm btn-success btn-goods-batch" data-action="status" data-status="1">批量上架</div>
                </div>
            
                <div class="fui-list-angle hide batch-delete">
                    <div class="btn btn-sm btn-danger btn-goods-batch" data-action="delete">批量删除</div>
                </div>
            
                <div class="fui-list-angle hide batch-restore">
                    <div class="btn btn-sm btn-danger btn-goods-batch" data-action="restore">批量还原</div>
                </div>
            
        </div>
    </div>

    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('merchmanage/_tpl/goods', TEMPLATE_INCLUDEPATH)) : (include template('merchmanage/_tpl/goods', TEMPLATE_INCLUDEPATH));?>

    <script type="text/javascript" src="../addons/ewei_shopv2/plugin/merchmanage/static/js/init.js?v=<?php  echo time()?>"></script>
    <script language="javascript">
        require(['../addons/ewei_shopv2/plugin/merchmanage/static/js/goods.js'],function(modal){
            modal.initList();
        });
    </script>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('merchmanage/_menu', TEMPLATE_INCLUDEPATH)) : (include template('merchmanage/_menu', TEMPLATE_INCLUDEPATH));?>