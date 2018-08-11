<?php

$url = "https://www.vietcombank.com.vn/exchangerates/ExrateXML.aspx"; //lấy file xml của nh vietcombank
$xml = file_get_contents($url);

$data = simplexml_load_string($xml);//chuyển đổi giá trị XML
date_default_timezone_set('Asia/Ho_Chi_Minh');//set múi giờ
$Ngay_cap_nhap =date("d/m/y" );//lấy ngày cập nhập
$Gio_cap_nhap=date(" h:i:s ");//lấy thời gian cập nhập
$ty_gia = $data->Exrate;//lấy data trong tag exrate
echo "<div style='font-family:tahoma'  >";//định dạng margin-top là 25%
echo "<h2 style='color:blue;text-align:center;'>Ngân hàng Vietcombank </h2><br>"; //tên ngân hàng
echo "
<div class='row'>
    <div class='col-12'>
        <div class='row'>
            <div class='col-lg-10'style='text-align:right;margin:0px;padding:0px'>Ngày Cập Nhập : &nbsp;</div>
            <div class='col-lg-2'style='text-align:left;margin:0px;padding:0px'> ".$Ngay_cap_nhap."</div>
        </div>
    </div>
    <div class='col-12'>
        <div class='row'>
            <div class='col-lg-10'style='text-align:right;margin:0px;padding:0px'>Giờ Cập Nhập : &nbsp;</div>
            <div class='col-lg-2'style='text-align:left;margin:0px;padding:0px'> ".$Gio_cap_nhap."</div>
        </div>
    </div>
</div>";
echo $ty_gia."<br>";

foreach($ty_gia as $ngoai_te) { //đổi $ty_gia thành $ngoai_te
    $ma = $ngoai_te['CurrencyCode'];//lấy mã ngoại tệ
    if($ma=="USD"){//nếu $ma = với USD thì tiếp tục lấy giá trị
        $ten = $ngoai_te['CurrencyName'];
        $gia_mua = $ngoai_te['Buy'];
        $gia_chuyen_khoan = $ngoai_te['Transfer'];
        $gia_ban = $ngoai_te['Sell'];
        //show giá trị đã lấy được ra dạng bảng
        echo "<table>
        <thead>   
        <tr><th style='text-align:center' colspan='3'>".$ten."</th></tr>
        </thead>
        <tbody >
        <tr align='center'><td >Giá Mua</td><td>Giá CK</td><td>Giá Bán</td></tr>
        <tr align='center'><td>".number_format("$gia_mua")."</td><td>".number_format("$gia_chuyen_khoan")."</td><td>".number_format("$gia_ban")."</td></tr>
        </tbody>
        </table>";
    }
}
echo "</div>";
?>
