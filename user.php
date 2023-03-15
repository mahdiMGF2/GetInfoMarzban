<?php
include('config.php');

//get token
$url_get_token = $address_server . 'api/admin/token';
$data_token = array(
    'username' => $username,
    'password' => $password
);
$options = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($data_token),
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'accept: application/json'
    )
);
$curl_token = curl_init($url_get_token);
curl_setopt_array($curl_token, $options);
$token = curl_exec($curl_token);
curl_close($curl_token);

$body = json_decode($token, true);
$token = $body['access_token'];



//info get
$usernameac = $_GET['usernames'];
$url = $address_server . 'api/user/' . $usernameac;
$header_value = 'Bearer ';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'Authorization: ' . $header_value . $token
));

$output = curl_exec($ch);
curl_close($ch);
$Data = json_decode($output, true);
//username
$username_account = $Data['username'];
//status
$status = $Data['status'];
switch ($status) {
    case 'active':
        $color_active = "#47bf2f";
        $text_status = "فعال";
        break;
    case 'limited':
        $color_active = "#bf2e2e";
        $text_status = "پایان حجم";
        break;
    case 'disabled':
        $color_active = "#877bff";
        $text_status = "حساب غیرفعال";
        break;

    default:
        $color_active = "#828282";
        $text_status = "نامشخص";
        break;
}



//TOTAL TRAFFIC
$dataLimit = $Data['data_limit'];
$LastTraffic = round($dataLimit / 1073741824, 2) . "GB";
if ($LastTraffic < 1) {
    $LastTraffic = round($dataLimit / 1073741824, 2) * 1000 . "MB";
}
if ($LastTraffic == 0) {
    $LastTraffic = "نامحدود";
    $RemainingVolume = "نامحدود";
}

//used_traffic
$usedTraffic = $Data['used_traffic'];
$usedTrafficGb = round($usedTraffic / 1073741824, 2) . "GB";
if (round($usedTraffic / 1073741824, 2) < 1) {
    $usedTrafficGb = round($usedTraffic / 1073741824, 2) * 1000 . "MB";
}
if (round($usedTraffic / 1073741824, 2) == 0) {
    $usedTrafficGb = "مصرف نشده";
}



// remaining volume
if (round($dataLimit / 1073741824, 2) != 0) {
    $min = round($dataLimit / 1073741824, 2) - round($usedTraffic / 1073741824, 2);
    $RemainingVolume  = $min . "GB";
    if ($min < 1) {
        $RemainingVolume = $min * 1000 . "MB";
    }
}


//expire config
$expire = $Data['expire'];
$timestamp = $expire;
$expirationDate = date('Y/m/d', $timestamp);
$date_time_obj = new DateTime($expirationDate);
if ($date_time_obj->format('Y/m/d') == '1970/01/01') {
    $expirationDate = "نامحدود";
}

//remaining time
$currentTime = time();
$timeDiff = $expire - $currentTime;

if ($timeDiff > 0) {
    $day = floor($timeDiff / 86400) . " Day";
} else {
    $day = "نامحدود";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خروجی اطلاعات</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <h3 class="title"><span><?php echo $username_account; ?></span> نمایش اطلاعات کاربر</h3>
    <div class="box">
        <div class="list username">
            <div class="value">
                <h4><?php echo $username_account; ?></h4>
            </div>
            <div class="user">
                <h4>: نام کاربری</h4>
            </div>
        </div>
        <div class="list status">
            <div style="background-color:<?php echo  $color_active; ?>" class="value">
                <h4><span><?php echo $text_status; ?></span></h4>
            </div>
            <div class="statusl">
                <h4>: وضعیت سرویس </h4>
            </div>
        </div>
        <div class="list total">
            <div class="value">
                <h4><?php echo $LastTraffic; ?></h4>
            </div>
            <div class="user">
                <h4>:حجم کل سرویس</h4>
            </div>
        </div>
        <div class="list usedTrafficGbs">
            <div class="value">
                <h4><?php echo $usedTrafficGb; ?></h4>
            </div>
            <div class="usedTrafficGb">
                <h4>:حجم مصرف شده سرویس</h4>
            </div>
        </div>
        <div class="list RemainingVolumes">
            <div class="value">
                <h4><?php echo $RemainingVolume; ?></h4>
            </div>
            <div class="RemainingVolume">
                <h4>:حجم باقی مانده سرویس</h4>
            </div>
        </div>
        <div class="list expirationDate">
            <div class="value">
                <h4><?php echo $expirationDate; ?></h4>
            </div>
            <div class="expirationDate">
                <h4>:تاریخ پایان سرویس </h4>
            </div>
        </div>
        <div class="list day">
            <div class="value">
                <h4><?php echo $day; ?></h4>
            </div>
            <div class="day">
                <h4>:روزهای باقی مانده تا پایان سرویس </h4>
            </div>
        </div>
    </div>

    </div>
    <div class="btndiv">
        <a href="./index.html" class="btn">بازگشت به صفحه اصلی</a>
    </div>
    <script src="./js/app.js"></script>
</body>

</html>
