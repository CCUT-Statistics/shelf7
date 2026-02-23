<?php
function tt_have_reward($arr){
    $r= $arr['reward_from1']!='0' OR $arr['reward_to1']!='0' OR $arr['reward_from2']!='0' OR $arr['reward_to2']!='0' OR $arr['reward_from3']!='0' OR $arr['reward_to3']!='0' ;
    return $r;
}
function tt_credits_rtn_name($credits1='0',$credits2='0',$credits3='0'){
    $rtn='';
    if($credits1!='0'&&$credits1!='') $rtn.=','.lang('credits1').':'.$credits1;
    if($credits2!='0'&&$credits2!='') $rtn.=','.lang('credits2').':'.$credits2;
    if($credits3!='0'&&$credits3!='') $rtn.=','.lang('credits3').':'.$credits3/100.0;
    return $rtn;
}
?>