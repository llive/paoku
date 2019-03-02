<?php defined('IN_IA') or exit('Access Denied');?><link rel="stylesheet" href="../addons/ewei_shopv2/plugin/lottery/static/style/zhuanpan.css"/>
<div class="wheel" >
    <ul class="wheel-light">
        <li><i></i><i></i><i></i><i></i></li>
        <li><i></i><i></i><i></i><i></i></li>
        <li><i></i><i></i><i></i><i></i></li>
        <li><i></i><i></i><i></i><i></i></li>
        <li><i></i><i></i><i></i><i></i></li>
        <li><i></i><i></i><i></i><i></i></li>
    </ul>

    <ul id="wheel" class="wheel-list">

    </ul>
    <div id="pointer" class="wheel-pointer" ><i>GO</i></div>
</div>
<script type="text/javascript">
    function buildpan() {
        $('#wheel').empty();
        $('#rec-rank .panel').each(function () {
            var obj = $(this);
            var li_div = '<li class="jssuper"><i ></i><div class="prize"><h3>'+obj.data('title')+'</h3><div class="icon"><img src="'+obj.data('icon')+'"></div></div></li>';
            $('#wheel').append(li_div);
            var pn = $('#wheel').find('li').length;			// 块数
            if(pn<4){
                pn=4;
            }
            var pa = 360/pn;								// 每块角度
            for(var i=0; i<pn; i++){
                $('#wheel').find('li').eq(i).css('transform', 'rotate(' + pa*i + 'deg)').find('i').css('transform', 'rotate('+ (pa/2) + 'deg) skewY(' + (90-pa) + 'deg)')
            }
        });
    }
    function getrank() {
        var test_rank = [];
        $('#rec-rank .panel').each(function () {
            var obj = $(this);
            var d = {};
            d.rank = obj.data('rank');
            d.title = obj.data('title');
            d.icon = obj.data('icon');
            d.probability = obj.data('probability');
            test_rank.push(d);
        });
        return test_rank;
    }
    $(function(){
        buildpan();
        var click=false;
        var runcount = 1;
        $('#pointer').on('click', function(){
            if(click){
                return false;
            }
            var pn = $('#wheel').find('li').length;
            if(pn<5){
                tip.msgbox.err('奖项不能低于5级');
                return;
            }
            var testreward = getrank();
            var reward = {};
            $.post('<?php  echo webUrl("lottery/index/testlottery");?>',{testreward:testreward},function (data) {
                if(data.status==1){
                    reward = data.info;
                    var num = data.num;
                    var pn = $('#wheel').find('li').length;
                    console.log(pn);
                    var pa = 360/pn;
                    $('#wheel').css('transform','rotate(' + (3600*runcount-num*pa) + 'deg)');
                    runcount++;
                    click=true;
                }else{
                    alert('系统错误');
                }
            },'json');


            $('#wheel')[0].addEventListener('webkitTransitionEnd', function(){
                console.log(reward);
                click=false;
            });

        });

    });
</script>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->