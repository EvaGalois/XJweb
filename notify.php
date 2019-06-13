<?php
include 'Helps.php';
include 'config.php';

$version = $_POST['version'];
$status = $_POST['status'];
$mch_id = $_POST['mch_id'];
$trade_no = $_POST['trade_no'];
$out_trade_no = $_POST['out_trade_no'];
$total_fee = $_POST['total_fee'];
$pay_money = $_POST['pay_money'];
$pay_type = $_POST['pay_type'];
$remark = $_POST['remark'];
$sign = $_POST['sign'];
$sign_type = $_POST['sign_type'];
$key = $config['key'];

$data = 'mch_id=' . $mch_id . '&out_trade_no=' . $out_trade_no . '&pay_money=' . $pay_money . '&pay_type=' . $pay_type . '&status=' . $status . '&trade_no=' . $trade_no . '&total_fee=' . $total_fee . 'version=' . $version . '&' . $key;

$helps = new \Common\Helps();
$filename = 'rizhi/receive-' . $out_trade_no . 'txt';
$helps->myfwrite($filename, $data);

$mysign = md5($data);

if ($sign = $mysign) {
    echo 'success';
} else {
    echo 'signerr';
}
?>
