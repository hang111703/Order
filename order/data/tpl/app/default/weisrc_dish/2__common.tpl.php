<?php defined('IN_IA') or exit('Access Denied');?><audio id="music" >
    <source src="http://tts.baidu.com/text2audio?lan=zh&ie=UTF-8&spd=3&text=您有未处理的订单，请尽快处理" type="audio/mpeg">
    <embed height="0" width="0" src="http://tts.baidu.com/text2audio?lan=zh&ie=UTF-8&spd=3&text=您有未处理的订单，请尽快处理">
</audio>
<script>
    function checkorder() {
        $.post("<?php  echo $this->createMobileUrl('checkorder', array('storeid' => $storeid));?>", function(data){
            var tip = "您有未处理的订单，请尽快处理";
            if(data == 'success') {
                $("#music")[0].src="http://tts.baidu.com/text2audio?lan=zh&ie=UTF-8&spd=3&text=" + tip;
                $("#music")[0].play();
            } else {
                if (data != '') {
                    $("#music")[0].src="http://tts.baidu.com/text2audio?lan=zh&ie=UTF-8&spd=3&text=" + data;
                    $("#music")[0].play();
                }
            }
            setTimeout(checkorder, 10000);
        });
    }
    $(function(){
        checkorder();
    });
</script>