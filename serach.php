<?php
header('content-type:text/html;charset=utf-8');
require "config.php";
require "Helps.php";
if (@isset($_POST['submit'])) {
    $version = '1.0';
    $mch_id = $config['mch_id'];
    $out_trade_no = @$_POST['out_trade_no'];
    $timestamp = date('Y-m-dH:i:s', time());
    $key = $config['key'];

    $sign = md5('mch_id=' . $mch_id . '&out_trade_no=' . $out_trade_no . '&timestamp=' . $timestamp . '&version=' . $version . '&' . $key);
    $url = "https://www.raotea.com/api/query_order?";
    $url .= 'version=' . $version . '&mch_id=' . $mch_id . '&out_trade_no=' . $out_trade_no . '&timestamp=' . $timestamp . '&sign=' . $sign;
    $helps = new \Common\Helps();
    $result = $helps->getcurl($url);
    if ($result->code==1){
        echo $result->msg;
        echo '<br>';
        if ($result->data->status==0){
            echo '状态：未支付';
        }else{
            echo '状态：已支付';
        }
        echo '<br>';
        echo '订单号：'.$result->data->out_trade_no;
        echo '<br>';
        echo '订单金额：'.$result->data->total_fee;
        echo '<br>';
        echo '支付金额：'.$result->data->pay_money;
        echo '<br>';
        echo '备注信息：'.$result->data->remark;
    }else{
        echo $result->msg;
    }
} else {
    ?>
    <!doctype html>
    <html>
    <head>
        <meta charset="utf8">
        <title>查询</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            html, body, div, p, span, ul, dl, ol, h1, h2, h3, h4, h5, h6, table, td, tr {
                padding: 0;
                margin: 0
            }

            .content {
                width: 400px;
                margin: 100px auto;
                border: 1px solid #ddd
            }

            h1 {
                margin-bottom: 30px;
                background-color: #eee;;
                border-bottom: 1px solid #ddd;
                padding: 10px;
                text-align: center
            }

            table {
                border-collapse: collapse;
                width: 90%;
                margin: 20px auto
            }

            table tr td {
                height: 40px;
                font-size: 14px
            }

            input, select {
                width: 100%;
                line-height: 25px
            }

            button {
                font-size: 16px
            }
        </style>
    </head>
    <body>
    <div class="content">
        <h1>查询</h1>
        <a href="/">支付</a>
        <!--<span><a href="index.html">金额输入框页</a></span>
        <span><a href="pay.html">金额下拉框页</a></span>-->
        <form action="" method="post"  target="_blank">
            <table>
                <tr>
                    <td>订单金额：</td>
                    <td>
                        <input type="text" id="text" name="out_trade_no" placeholder="订单号">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" name="submit">提交</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    </body>
    </html>
<?php } ?>