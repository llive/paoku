<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}
require EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';

class Merch_EweiShopV2Page extends AppMobilePage
{
    public function get_list()
    {
        global $_GPC;
        global $_W;
        $merch_plugin = p('merch');
        $merch_data = m('common')->getPluginset('merch');
        $citysel = false;
        $citys = array();
        if ($merch_plugin && $merch_data['is_openmerch']) {
            $data = array();
            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;
            $lat = floatval($_GPC['lat']);
            $lng = floatval($_GPC['lng']);
            $sorttype = intval($_GPC['sorttype']);
            $range = intval($_GPC['range']);
            if (!(empty($_GPC['keyword']))) {
                $data['like'] = array('merchname' => $_GPC['keyword']);
            }
            if (!(empty($_GPC['cateid']))) {
                $data['cateid'] = $_GPC['cateid'];
            }
            $data = array_merge($data, array('status' => 1, 'field' => 'id,uniacid,merchname,mobile,salecate,logo,groupid,cateid,address,tel,lng,lat,reward_type'));
            if (!(empty($sorttype))) {
                $data['orderby'] = array('id' => 'desc');
            }
            $merchuser = $merch_plugin->getMerch($data);
            //print_r($data);print_r($merchuser);pdo_debug();exit;
            $data = array();
            $data = array_merge($data, array('status' => 1, 'orderby' => array('displayorder' => 'desc', 'id' => 'asc')));
            $category = $merch_plugin->getCategory($data);
            if (!(empty($merchuser))) {
                $cate_list = array();
                if (!(empty($category))) {
                    foreach ($category as $k => $v) {
                        $cate_list[$v['id']] = $v;
                    }
                }
                if ($pindex==1){
                    $member=m('member')->getMember($_W['openid']);
                    if (!empty($member['agentid'])){
                        $agent=m('member')->getMember($member['agentid']);
                        $isstore=pdo_getall('ewei_shop_merch_user',array('payopenid'=>$agent['openid']));
                    }
                }
                if (!empty($isstore)){
                    $merchuser=array_merge($isstore,$merchuser);
                }
                foreach ($merchuser as $k => $v) {
                    if (($lat != 0) && ($lng != 0) && !(empty($v['lat'])) && !(empty($v['lng']))) {
                        $distance = m('util')->GetDistance($lat, $lng, $v['lat'], $v['lng'], 2);
                        if ((0 < $range) && ($range < $distance)) {
                            unset($merchuser[$k]);
                            continue;
                        }
                        $merchuser[$k]['distance'] = $distance;
                        if ($distance < 1) $disname = ($distance * 100) . 'm';
                        else $disname = ($distance) . 'km';
                        $merchuser[$k]['disname'] = $disname;
                    } elseif ($range) {
                        unset($merchuser[$k]);
                        continue;
                    } else {
                        $merchuser[$k]['distance'] = 100000;
                        $merchuser[$k]['disname'] = '';
                    }
                    $merchuser[$k]['catename'] = $cate_list[$v['cateid']]['catename'];
                    //$merchuser[$k]['url'] = mobileUrl('merch/map', array('merchid' => $v['id']));
                    //$merchuser[$k]['merch_url'] = mobileUrl('merch', array('merchid' => $v['id']));
                    $merchuser[$k]['logo'] = tomedia($v['logo']);
                    
                    //判断是否有赏金任务
                    if ($v["reward_type"]==0){
                        $merchuser[$k]["is_reward"]=0;
                        $merchuser[$k]["reward_money"]=0;
                    }else{
                        //获取是否有进行中的赏金
                        $reward=pdo_get("ewei_shop_merch_reward",array('is_end'=>0,'merch_id'=>$v["id"]));
//                         var_dump($reward);
                        if ($reward){
                           
                            $merchuser[$k]["is_reward"]=1;
                            //获取赏金
//                             var_dump($v["id"]);
//                             var_dump($v["reward_type"]);
//                             var_dump(m("merch")->reward_money($v["id"],$v["reward_type"]));
                            $merchuser[$k]["reward_money"]=m("merch")->reward_money($v["id"],$v["reward_type"]);
                        }else{
                            $merchuser[$k]["is_reward"]=0;
                            $merchuser[$k]["reward_money"]=0;
                        }
                    }
                }
            }


            //print_r($merchuser);exit;
            $total = count($merchuser);
            if ($sorttype == 0 && !empty($merchuser)) {
                $merchuser = m('util')->multi_array_sort($merchuser, 'distance');
            }
            $start = ($pindex - 1) * $psize;
            if (!(empty($merchuser))) {
                $merchuser = array_slice($merchuser, $start, $psize);
            }
            //增加城市选择
            if (pdo_fieldexists('ewei_shop_merch_user', 'city')) {
                $tmp = pdo_fetchall("select distinct(province),city from " . tablename('ewei_shop_merch_user') . " where uniacid=:uniacid and status=1 order by province,city", array(':uniacid' => $_W['uniacid']));
                if (!empty($tmp)) {
                    $citysel = true;
                    foreach ($tmp as $v) $citys[$v['province']][] = $v['city'];
                    //print_r($citys);exit;
                }
            }
        }
        if (empty($merchuser)) $merchuser = array();
        $disopt = array();
        $disopt[] = array('range' => 1, 'title' => '1KM以内');
        $disopt[] = array('range' => 3, 'title' => '3KM以内');
        $disopt[] = array('range' => 5, 'title' => '5KM以内');
        $disopt[] = array('range' => 10, 'title' => '10KM以内');
        //$disopt[] = array('range'=>20, 'title'=>'20KM以内');
        app_json(array('list' => $merchuser, 'total' => intval($total), 'pagesize' => intval($psize), 'cates' => $category, 'disopt' => $disopt, 'citysel' => $citysel, 'citys' => $citys));
    }

    public function goods_list()
    {
        global $_GPC;
        global $_W;
        $args = array('pagesize' => intval($_GPC['pagesize']), 'page' => intval($_GPC['page']), 'isnew' => trim($_GPC['isnew']), 'ishot' => trim($_GPC['ishot']), 'isrecommand' => trim($_GPC['isrecommand']), 'isdiscount' => trim($_GPC['isdiscount']), 'istime' => trim($_GPC['istime']), 'keywords' => trim($_GPC['keywords']), 'cate' => intval($_GPC['cate']), 'order' => trim($_GPC['order']), 'by' => trim($_GPC['by']));
        //$merch_plugin = p('merch');
        //$merch_data = m('common')->getPluginset('merch');
        //if ($merch_plugin && $merch_data['is_openmerch']) {
        $args['merchid'] = intval($_GPC['id']);
        //}
        //获取商家
        $merchid=intval($_GPC['id']);
        $merch=pdo_get("ewei_shop_merch_user",array('id'=>$merchid));
        $reward=pdo_fetchall("select * from ".tablename("ewei_shop_merch_reward")."where merch_id=:merch_id and type=1 and is_end=0",array(':merch_id'=>$merchid));
        $g=array();
        if (!empty($reward)){
            foreach ($reward as $k=>$v){
                $g[$k]=unserialize($v["goodid"]);
            }
        }
        
        
        if (isset($_GPC['nocommission'])) {
            $args['nocommission'] = intval($_GPC['nocommission']);
        }
        if (!empty($_GPC['isrecommand'])) $args['isrecommand'] = $_GPC['isrecommand'];
        if (!empty($_GPC['isnew'])) $args['isnew'] = $_GPC['isnew'];
        //print_r($args);exit;
        $goods = m('goods')->getList($args);
        $saleout = (!empty($_W['shopset']['shop']['saleout']) ? tomedia($_W['shopset']['shop']['saleout']) : '');
        $goods_list = array();

        if (0 < $goods['total']) {
            $goods_list = $goods['list'];

            foreach ($goods_list as $index => $item) {
                if ($goods_list[$index]['isdiscount']) {
                    if (time() < $goods_list[$index]['isdiscount_time']) {
                        $goods_list[$index]['isdiscount'] = 0;
                    }
                }

                $goods_list[$index]['minprice'] = (double)$goods_list[$index]['minprice'];
                unset($goods_list[$index]['marketprice']);
                unset($goods_list[$index]['productprice']);
                unset($goods_list[$index]['productprice']);
                unset($goods_list[$index]['maxprice']);
                unset($goods_list[$index]['isdiscount_discounts']);
                unset($goods_list[$index]['description']);
                unset($goods_list[$index]['discount_time']);

                if ($item['total'] < 1) {
                    $goods_list[$index]['saleout'] = $saleout;
                }
                //判断赏金
                if ($merch["reward_type"]==0){
                    $goods_list[$index]["reward"]=0;
                }else{
                    if ($merch["reward_type"]==1){
                        if (!empty($g)){
                           
                           if (m("merch")->good($g,$goods_list[$index]["id"])){
                               $goods_list[$index]["reward"]=1;
                           }else{
                               $goods_list[$index]["reward"]=0;
                           }
                           
                       } else{
                           $goods_list[$index]["reward"]=0;
                       }
                        
                        
                    }else{
                        //全部商品
                        $r=pdo_get("ewei_shop_merch_reward",array("merch_id"=>$merchid,"is_end"=>0,"type"=>2));
                        if ($r){
                            $goods_list[$index]["reward"]=1;
                        }else{
                            $goods_list[$index]["reward"]=0;
                        }
                        
                    }
                }
            }
        }
        app_json(array('list' => $goods_list, 'total' => $goods['total'], 'pagesize' => $args['pagesize']));
    }

    public function get_detail()
    {
        global $_W;
        global $_GPC;
        $result = array();
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['id']);

        if (empty($id)) {
            app_error(AppError::$ParamsError);
        }

        $merch_plugin = p('merch');
        $merch_data = m('common')->getPluginset('merch');
        if ($merch_plugin && $merch_data['is_openmerch']) {
            $merch = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where id=:merchid and uniacid=:uniacid Limit 1', array(':uniacid' => $_W['uniacid'], ':merchid' => $id));
            $merch['logo'] = tomedia($merch['logo']);
            $params = array(':merchid' => $id, ':uniacid' => $_W['uniacid']);
            $merch['allgoodsnum'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and merchid=:merchid and status=1', $params);
            $merch['recgoodsnum'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and merchid=:merchid and status=1 and isrecommand=1', $params);
            $merch['newgoodsnum'] = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_goods') . ' where uniacid=:uniacid and merchid=:merchid and status=1 and isnew=1', $params);
            if (file_exists('../addons/ewei_shopv2/storebg.png')) $merch['storebg'] = $_W['siteroot'] . '/addons/ewei_shopv2/storebg.png';
            elseif (!empty($merch_data['regbg'])) $merch['storebg'] = tomedia($merch_data['regbg']);
            else $merch_data['regbg'] = '';
        } else {
            $merch = array();
        }
        app_json(array('merch' => $merch));
    }

    public function intro()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC['id']);
        if (empty($id)) {
            app_error(AppError::$ParamsError);
        }
        $merch_plugin = p('merch');
        $merch_data = m('common')->getPluginset('merch');
        if ($merch_plugin && $merch_data['is_openmerch']) {
            $merch = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where id=:merchid and uniacid=:uniacid Limit 1', array(':uniacid' => $_W['uniacid'], ':merchid' => $id));
            $merch['logo'] = tomedia($merch['logo']);
            $merch['desc'] = nl2br($merch['desc']);
            //商户顶部banner判断
            if (file_exists('../addons/ewei_shopv2/storebg.png')) $merch['storebg'] = $_W['siteroot'] . '/addons/ewei_shopv2/storebg.png';
            elseif (!empty($merch_data['regbg'])) $merch['storebg'] = tomedia($merch_data['regbg']);
            else $merch_data['regbg'] = '';
            if (!empty($merch['lat']) && !empty($merch['lat'])) {
                $gcj02 = $this->Convert_BD09_To_GCJ02($merch['lat'], $merch['lng']);
                $merch['lat'] = $gcj02['lat'];
                $merch['lng'] = $gcj02['lng'];
            }
        } else {
            $merch = array();
        }
        //$goods['content'] = m('common')->html_to_images($goods['content']);
        app_json(array('merch' => $merch));
    }

    public function apply()
    {
        global $_W;
        global $_GPC;
        $set = $_W['shopset']['merch'];
        if (empty($set['apply_openmobile'])) {
            app_error(0, '未开启商户入驻申请', '');
        }
        $reg = pdo_fetch('select * from ' . tablename('ewei_shop_merch_reg') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
        $user = false;
        if (!(empty($reg['status']))) {
            $user = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));
        }
        if (!(empty($user)) && (1 <= $user['status'])) {
            $user['loginurl'] = $_W['siteroot'] . 'web/merchant.php?i=' . $_W['uniacid'];
            $user['joindate'] = date('Y-m-d', $user['jointime']);
            $user['todate'] = date('Y-m-d', $user['accounttime']);
            //app_error(0,'您已经申请，无需重复申请!');
        }
        $apply_set = array();
        $apply_set['open_protocol'] = $set['open_protocol'];
        if (empty($set['applytitle'])) {
            $apply_set['applytitle'] = '入驻申请协议';
        } else {
            $apply_set['applytitle'] = $set['applytitle'];
        }
        $template_flag = 0;
        $diyform_plugin = p('diyform');
        $fields = array();
        if ($diyform_plugin) {
            $area_set = m('util')->get_area_config_set();
            $new_area = intval($area_set['new_area']);
            if (!(empty($set['apply_diyform'])) && !(empty($set['apply_diyformid']))) {
                $template_flag = 1;
                $diyform_id = $set['apply_diyformid'];
                if (!(empty($diyform_id))) {
                    $formInfo = $diyform_plugin->getDiyformInfo($diyform_id);
                    $fields = $formInfo['fields'];
                    $diyform_data = iunserializer($reg['diyformdata']);
                    $member = m('member')->getMember($_W['openid']);
                    $f_data = $diyform_plugin->getDiyformData($diyform_data, $fields, $member);
                }
            }
        }
        if ($_W['ispost']) {
            if (empty($set['apply_openmobile'])) {
                show_json(0, '未开启商户入驻申请!');
            }
            if (!(empty($user)) && (1 <= $user['status'])) {
                show_json(0, '您已经申请，无需重复申请!');
            }
            $uname = trim($_GPC['uname']);
            $upass = $_GPC['upass'];
            if (empty($uname)) {
                show_json(0, '请填写帐号!');
            }
            if (empty($upass)) {
                show_json(0, '请填写密码!');
            }
            $where1 = ' uname=:uname';
            $params1 = array(':uname' => $uname);
            if (!(empty($reg))) {
                $where1 .= ' and id<>:id';
                $params1[':id'] = $reg['id'];
            }
            $usercount1 = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_merch_reg') . ' where ' . $where1 . ' limit 1', $params1);
            $where2 = ' username=:username';
            $params2 = array(':username' => $uname);
            $usercount2 = pdo_fetchcolumn('select count(1) from ' . tablename('ewei_shop_merch_account') . ' where ' . $where2 . ' limit 1', $params2);
            if ((0 < $usercount1) || (0 < $usercount2)) {
                show_json(0, '帐号 ' . $uname . ' 已经存在,请更改!');
            }
            $upass = m('util')->pwd_encrypt($upass, 'E');
            $data = array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'status' => 0, 'realname' => trim($_GPC['realname']), 'mobile' => trim($_GPC['mobile']), 'uname' => $uname, 'upass' => $upass, 'merchname' => trim($_GPC['merchname']), 'salecate' => trim($_GPC['salecate']), 'desc' => trim($_GPC['desc']));
            if ($template_flag == 1) {
                $mdata = $_GPC['mdata'];
                $insert_data = $diyform_plugin->getInsertData($fields, $mdata);
                $datas = $insert_data['data'];
                $m_data = $insert_data['m_data'];
                $mc_data = $insert_data['mc_data'];
                $data['diyformfields'] = iserializer($fields);
                $data['diyformdata'] = $datas;
            }
            if (empty($reg)) {
                $data['applytime'] = time();
                pdo_insert('ewei_shop_merch_reg', $data);
            } else {
                pdo_update('ewei_shop_merch_reg', $data, array('id' => $reg['id']));
            }
            p('merch')->sendMessage(array('merchname' => $data['merchname'], 'salecate' => $data['salecate'], 'realname' => $data['realname'], 'mobile' => $data['mobile'], 'applytime' => time()), 'merch_apply');
            show_json(1);
        }
        $set['regbg'] = tomedia($set['regbg']);
        $ifexist = 0;
        if (empty($reg)) $reg['merchname'] = '';
        else $ifexist = 1;
        app_json(array('canapply' => 1, 'set' => $set, 'apply_set' => $apply_set, 'reg' => $reg, 'ifexist' => $ifexist, 'myuser' => $user));
    }

    public function confirmjoin()
    {
        global $_W;
        global $_GPC;
        $set = $_W['shopset']['merch'];
        if (empty($set['apply_openmobile'])) {
            app_error(0, '未开启商户入驻申请', '');
        }
        $user = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':openid' => $_W['openid'], ':uniacid' => $_W['uniacid']));

        if (empty($user) || $user['status']) {
            app_error(0, '无权操作!');
        }
        if ($_W['ispost']) {
            pdo_update('ewei_shop_merch_user', array('status' => 1, 'jointime' => time()), array('id' => $user['id']));
            show_json(1);
        }
        app_error(0, '失败!');
    }

    public function Convert_BD09_To_GCJ02($lat, $lng)
    {
        $x_pi = (3.1415926535897931 * 3000) / 180;
        $x = $lng - 0.0064999999999999997;
        $y = $lat - 0.0060000000000000001;
        $z = sqrt(($x * $x) + ($y * $y)) - (2.0000000000000002E-5 * sin($y * $x_pi));
        $theta = atan2($y, $x) - (3.0000000000000001E-6 * cos($x * $x_pi));
        $lng = $z * cos($theta);
        $lat = $z * sin($theta);
        return array('lat' => $lat, 'lng' => $lng);
    }

    public function get_comment_list()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC['id']);
        $level = trim($_GPC['level']);
        $params = array(':goodsid' => $id, ':uniacid' => $_W['uniacid']);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $condition = '';

        if ($level == 'good') {
            $condition = ' and level=5';
        } else if ($level == 'normal') {
            $condition = ' and level>=2 and level<=4';
        } else if ($level == 'bad') {
            $condition = ' and level<=1';
        } else {
            if ($level == 'pic') {
                $condition = ' and ifnull(images,\'a:0:{}\')<>\'a:0:{}\'';
            }
        }

        $list = pdo_fetchall('select * from ' . tablename('ewei_shop_order_comment') . ' ' . '  where goodsid=:goodsid and uniacid=:uniacid and deleted=0 and checked=0 ' . $condition . ' order by istop desc, createtime desc, id desc LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);

        foreach ($list as &$row) {
            $row['headimgurl'] = tomedia($row['headimgurl']);
            $row['createtime'] = date('Y-m-d H:i', $row['createtime']);
            $row['images'] = set_medias(iunserializer($row['images']));
            $row['reply_images'] = set_medias(iunserializer($row['reply_images']));
            $row['append_images'] = set_medias(iunserializer($row['append_images']));
            $row['append_reply_images'] = set_medias(iunserializer($row['append_reply_images']));
            $row['nickname'] = cut_str($row['nickname'], 1, 0) . '**' . cut_str($row['nickname'], 1, -1);
        }

        unset($row);
        $total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_order_comment') . ' where goodsid=:goodsid  and uniacid=:uniacid and deleted=0 and checked=0 ' . $condition, $params);
        app_json(array('list' => $list, 'total' => $total, 'pagesize' => $psize));
    }

    public function get_content()
    {
        global $_W;
        global $_GPC;
        $uniacid = $_W['uniacid'];
        $id = intval($_GPC['id']);
        $goods = pdo_fetch('select content from ' . tablename('ewei_shop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
        app_json(array('content' => base64_encode($goods['content'])));
    }

    public function get_category()
    {
        global $_W;
        global $_GPC;
        $allcategory = m('shop')->getCategory();
        $catlevel = intval($_W['shopset']['category']['level']);
        $opencategory = true;
        $plugin_commission = p('commission');
        if ($plugin_commission && (0 < intval($_W['shopset']['commission']['level']))) {
            $mid = intval($_GPC['mid']);

            if (!empty($mid)) {
                $shop = p('commission')->getShop($mid);

                if (empty($shop['selectcategory'])) {
                    $opencategory = false;
                }
            }
        }

        app_json(array('allcategory' => $allcategory, 'catlevel' => $catlevel, 'opencategory' => $opencategory));
    }


    /**
     * 记录用户的第一个扫码来源店铺
     */
    public function from_store(){
        global $_GPC;
        $merchid = $_GPC['merchid'];
        $member = m('member')->getMember($_GPC['openid']);
        if(!$member) show_json(-1, "会员信息不存在");
        if($member['from_merchid']>0){
            show_json(0, '操作成功');
        }
        $date = array(
            'from_merchid' => $merchid,
        );
        pdo_update('ewei_shop_member', $date, array('openid' => $_GPC['openid']));
        show_json(0, '操作成功');
    }

    /**
     * 获取来源店铺信息
     */
    public function get_from_store(){

        global $_GPC;
        global $_W;
        $uniacid = $_W['uniacid'];
        $member = m('member')->getMember($_GPC['openid']);
        $memberMerchInfo = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where member_id=:member_id Limit 1', array(':member_id' => $member['id']));
        $data = array();
        if($member['agentid']>0){
            $agentMerchInfo = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where member_id=:member_id Limit 1', array(':member_id' => $member['agentid']));
        }
        if($memberMerchInfo) {//店主
            $args['merchid'] = $memberMerchInfo['id'];
            $merchInfo = $memberMerchInfo;
        }elseif($member && $member['from_merchid']>0){//存在来源店铺
            $merchInfo = pdo_fetch('select * from ' . tablename('ewei_shop_merch_user') . ' where id=:merchid and uniacid=:uniacid Limit 1', array(':uniacid' => $_W['uniacid'], ':merchid' => $member['from_merchid']));
            $goodsNum = pdo_count("ewei_shop_goods", "deleted =0 and status=1 and uniacid = " . $uniacid . " and merchid = " . $member['from_merchid']);
            if($merchInfo){//获取推荐商品
               $args['merchid'] = $member['from_merchid'];
            }else{//推荐附近商店
                $merchInfo = $this->get_near_merch(1);
                $args['merchid'] = $merchInfo['id'];
            }
            if($goodsNum<3){//推荐其他商品数量大于三的店铺
                $merchInfo = $this->get_near_merch(1);
                $args['merchid'] = $merchInfo['id'];
            }

        }elseif($agentMerchInfo){//查看推荐人是否有店铺
            $args['merchid'] = $agentMerchInfo['id'];
            $merchInfo = $agentMerchInfo;
        }else{//推荐附近商店
                $merchInfo = $this->get_near_merch(1);
                $args['merchid'] = $merchInfo['id'];
        }
        $args['order'] = 'sort desc,isrecommand';
        $goodList = m('goods')->getList($args);
        $merchInfo['logo'] = tomedia($merchInfo['logo']);
        $data['merchInfo'] = $merchInfo;
        $data['goodList'] = $goodList;
        show_json(0,$data);

    }

    /**
     * 获取最近的店铺
     * @return mixed
     */
    public function get_near_merch($is_from=0)
    {
        global $_GPC;
        global $_W;

        $merch_plugin = p('merch');
        $merch_data = m('common')->getPluginset('merch');
        $citysel = false;
        $citys = array();
        if ($merch_plugin && $merch_data['is_openmerch']) {
            $data = array();
            $pindex = max(1, intval($_GPC['page']));
            $psize = 10;
            $lat = floatval($_GPC['lat']);
            $lng = floatval($_GPC['lng']);
            $sorttype = intval($_GPC['sorttype']);
            $range = intval($_GPC['range']);

            $data = array_merge($data, array('status' => 1, 'field' => 'id,uniacid,merchname,salecate,logo,groupid,cateid,address,tel,lng,lat'));
            if (!(empty($sorttype))) {
                $data['orderby'] = array('id' => 'desc');
            }
            $merchuser = $merch_plugin->getMerch($data);
           // print_r($data);print_r($merchuser);pdo_debug();exit;
            $data = array();
            $data = array_merge($data, array('status' => 1, 'orderby' => array('displayorder' => 'desc', 'id' => 'asc')));
            $category = $merch_plugin->getCategory($data);
            if (!(empty($merchuser))) {
                $cate_list = array();
                if (!(empty($category))) {
                    foreach ($category as $k => $v) {
                        $cate_list[$v['id']] = $v;
                    }
                }

                if ($pindex == 1) {
                    $member = m('member')->getMember($_W['openid']);
                    if (!empty($member['agentid'])) {
                        $agent = m('member')->getMember($member['agentid']);
                        $isstore = pdo_getall('ewei_shop_merch_user', array('payopenid' => $agent['openid']));
                    }
                }
                if (!empty($isstore)) {
                    $merchuser = array_merge($isstore, $merchuser);
                }
                foreach ($merchuser as $k => $v) {
                    if (($lat != 0) && ($lng != 0) && !(empty($v['lat'])) && !(empty($v['lng']))) {
                        $distance = m('util')->GetDistance($lat, $lng, $v['lat'], $v['lng'], 2);
                        if ((0 < $range) && ($range < $distance)) {
                            unset($merchuser[$k]);
                            continue;
                        }
                        $merchuser[$k]['distance'] = $distance;
                        if ($distance < 1) $disname = ($distance * 100) . 'm';
                        else $disname = ($distance) . 'km';
                        $merchuser[$k]['disname'] = $disname;
                    } elseif ($range) {
                        unset($merchuser[$k]);
                        continue;
                    } else {
                        $merchuser[$k]['distance'] = 100000;
                        $merchuser[$k]['disname'] = '';
                    }
                    $merchuser[$k]['catename'] = $cate_list[$v['cateid']]['catename'];
                    $merchuser[$k]['logo'] = tomedia($v['logo']);

                    if($is_from>0){
                        $goodsNum = pdo_count("ewei_shop_goods", "deleted =0 and status=1  and merchid = " . $v['id']);
                        if($goodsNum<3){
                            unset($merchuser[$k]);
                        }
                    }
                }
            }

            if ($sorttype == 0 && !empty($merchuser)) {
                $merchuser = m('util')->multi_array_sort($merchuser, 'distance');
            }
            return $merchuser[0];
        }
    }

    /**
     * 提现排行榜  快报
     */
    public function draw_rank()
    {
        global $_W;
        $uniacid = $_W['uniacid'];
        //计算提现总人数
        $list = pdo_fetchall('select sum(l.money) as sum_money,m.nickname from '.tablename('ewei_shop_member_log').'l join '.tablename('ewei_shop_member').'m on m.openid=l.openid'.' where l.uniacid = "'.$uniacid.'" and type = 1 and l.status = 1 group by l.openid order by sum_money desc');
        $total = count($list);
        //取出来前三名
        //$third = array_slice($list,0,3);
        //设置每页数
        $pageSize = 100;
        //随机获取第几页  以及每页的第几个
        $page = rand(1,floor($total/$pageSize));
        $psize = ($page-1)*$pageSize;
        //分页显示
        $log = pdo_fetchall('select sum(l.money) as sum_money,m.nickname,m.id from '.tablename('ewei_shop_member_log').'l join '.tablename('ewei_shop_member').'m on m.openid=l.openid'.' where l.uniacid = "'.$uniacid.'" and type = 1 and l.status = 1 and m.id NOT IN (4350,9851,9861) group by l.openid order by sum_money desc LIMIT '.$psize.','.$pageSize);
        //如果不是第一页 就把前三名合并到分页的
        //if($page != 1){
        //    $log = array_merge($third,$log);
        //}
        foreach ($log as &$item){
            //计算昵称的长度
            $length = mb_strlen($item['nickname']);
            //如果昵称长度小于等于3  就截取1位 并拼接***   如果昵称大于4  截取第1位和最后1位
            if($length <= 3){
                $item['nickname'] = mb_substr($item['nickname'],0,1)."***";
            }elseif($length >= 4){
                $item['nickname'] = mb_substr($item['nickname'],0,1)."***".mb_substr($item['nickname'],-1,1);
            }
        }
        show_json(1,['log'=>$log,'page'=>$page,'total'=>$total]);
    }
}

?>
