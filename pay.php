<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
header('Content-Type:text/html;charset=utf8');
date_default_timezone_set('Asia/Shanghai');

include 'config.php';
include 'Helps.php';

$version = '1.0';
$mch_id = $config['mch_id'];
$out_trade_no = time() + mt_rand(1000, 9999);
$total_fee = number_format($_POST['amount'], 2, '.', '');
$pay_type = $_POST['payment_type'];
$notify_url = 'http://' . $_SERVER['HTTP_HOST'] . '/notify.php';
$return_url = 'http://' . $_SERVER['HTTP_HOST'] . '/return.php';
$remark = $_POST['remark'];

$key = $config['key'];

$data = "format=json" . "&mch_id=" . $mch_id . "&notify_url=" . $notify_url . "&out_trade_no=" . $out_trade_no . "&pay_type=" . $pay_type . '&remark=' . $remark . '&return_url=' . $return_url . '&total_fee=' . $total_fee . '&version=' . $version . "&" . $key;
$sign = md5($data);

$helps = new \Common\Helps();
$filename = "rizhi/" . 'request-' . $out_trade_no . ".txt";
$helps->myfwrite($filename, $data);

$url = 'https://www.raotea.com/api/unified_order?';
$url .= 'version=' . $version . '&mch_id=' . $mch_id . '&out_trade_no=' . $out_trade_no . '&total_fee=' . $total_fee . '&pay_type=' . $pay_type . '&notify_url=' . $notify_url . '&return_url=' . $return_url . '&remark=' . $remark . '&format=json&sign=' . $sign;
$return=$helps->getcurl($url);
if ($return->code==1){
    echo '<a href="'.$return->data->url.'">前往支付</a>';
}else{
    echo $return->msg;
}
?>
