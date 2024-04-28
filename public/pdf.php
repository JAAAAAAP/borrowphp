<?php
require $_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/vendor/autoload.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/config/connectdb.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["group"])) {
        include_once($_SERVER['DOCUMENT_ROOT'] . '/jaa/bookingphp/config/connectdb.php');
        include_once('../plugin/script.php');

        $group = $_GET["group"];
        $groupid_sql = 'SELECT o.*, u.user, p.name AS products_name, p.sn_products,p.amount AS products_amount 
                        FROM products AS p 
                        INNER JOIN oder_product AS o ON p.p_id = o.p_id 
                        INNER JOIN USER AS u ON u.user_id = o.user_id 
                        WHERE group_id = :g_id AND status = "กำลังยืม"';
        $groupid_query = $conn->prepare($groupid_sql);
        $groupid_query->bindParam(':g_id', $group, PDO::PARAM_INT);
        $groupid_query->execute();
        $groupid = $groupid_query->fetchAll(PDO::FETCH_ASSOC);
    }
}

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [ // lowercase letters only in font key
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
        ]
    ],
    'default_font' => 'sarabun'
]);

$projecter = '';
$Notebook1 = '';
$Notebook2 = '';
$MacBook = '';
$HDMI_to_VGA = '';
$VGA = '';
$Opaque_projector = '';
$Audio1 = '';
$wireless_microphone = '';  
$wired_microphone = '';
$audio_cable = '';
$Extension_plug = '';
foreach ($groupid as $group) {
    $user = "<div style='position: absolute; top: 150px; left: 200px;font-size:13;'><h1>" . $_SESSION['user'] . "</h1></div>";
    $tel = "<div style='position: absolute; top: 150px; left: 500px;font-size:13;'><h1>0" . $group['tel'] . "</h1></div>";
    $department = "<div style='position: absolute; top: 175px; left: 220px;font-size:13;'><h1>" . $group['department'] . "</h1></div>";
    $address = "<div style='position: absolute; top: 392px;left: 165px;font-size:13;'><h1>" . $group['address'] . "</h1></div>";
    $teacher = "<div style='position: absolute; top: 416px; left: 200px;font-size:13;'><h1>" . $group['teacher'] . "</h1></div>";
    $date_start = "<div style='position: absolute; top: 440px; left: 180px;font-size:13;'><h1>" . date("d/m/Y", strtotime($group['date_start'])) . "</h1></div>";
    $date_end = "<div style='position: absolute; top: 440px; left: 500px;font-size:13;'><h1>" . date("d/m/Y", strtotime($group['date_end'])) . "</h1></div>";
    $checked1 = "<div style='position: absolute; top: 611px; left: 184px;font-size:13;'><h1>X</h1></div>";
    $checked2 = "<div style='position: absolute; top: 659px; left: 184px;font-size:13;'><h1>X</h1></div>";
    if (trim($group['products_name']) === 'โปรเจคเตอร์') {
        $projecter = "<div style='position: absolute; top: 224px; left: 108px;font-size:13;'><h1>X</h1></div>";
    } elseif (trim($group['products_name']) === 'Notebook ACER ๑(สำหรับยืมสอน)') {
        $Notebook1 = "<div style='position: absolute; top: 248px; left: 108px;font-size:13;'><h1>X</h1></div>";
    } elseif (trim($group['products_name']) === 'Notebook ACER ๒(สำหรับประชุม)') {
        $Notebook2 = "<div style='position: absolute; top: 273px; left: 108px;font-size:13;'><h1>X</h1></div>";
    } elseif (trim($group['products_name']) === 'MacBook Air(สำหรับประชุม)') {
        $MacBook = "<div style='position: absolute; top: 297px; left: 108px;font-size:13;'><h1>X</h1></div>";
    } elseif (trim($group['products_name']) === 'HDMI to VGA') {
        $HDMI_to_VGA = "<div style='position: absolute; top: 321px; left: 108px;font-size:13;'><h1>X</h1></div>";
    } elseif (trim($group['products_name']) === 'สาย VGA') {
        $VGA = "<div style='position: absolute; top: 345px; left: 108px;font-size:13;'><h1>X</h1></div>";
    } elseif (trim($group['products_name']) === 'เครื่องฉายแผ่นทึบ') {
        $Opaque_projector = "<div style='position: absolute; top: 224px; left: 390px;font-size:13;'><h1>X</h1></div>";
    } elseif (trim($group['products_name']) === 'เครื่องเสียง') {
        $Audio1 = "<div style='position: absolute; top: 248px; left: 390px;font-size:13;'><h1>X</h1></div>";
    } elseif (trim($group['products_name']) === 'ไมค์ลอย') {
        $wireless_microphone = "<div style='position: absolute; top: 273px; left: 390px;font-size:13;'><h1>X</h1></div>";
    } elseif (trim($group['products_name']) === 'ไมล์สาย') {
        $wired_microphone = "<div style='position: absolute; top: 297px; left: 390px;font-size:13;'><h1>X</h1></div>";
    } elseif (trim($group['products_name']) === 'สายเสียง') {
        $audio_cable = "<div style='position: absolute; top: 321px; left: 390px;font-size:13;'><h1>X</h1></div>";
    } elseif (trim($group['products_name']) === 'ปลั๊กพ่วง') {
        $Extension_plug = "<div style='position: absolute; top: 345px; left: 390px;font-size:13;'><h1>X</h1></div>";
    }else{
        $Audio1 = "<div style='position: absolute; top: 248px; left: 390px;font-size:13;'><h1>X</h1></div>";
    }
}

// Set source file for template if needed
$mpdf->SetSourceFile('borrowForm.pdf');

$pageCount = $mpdf->SetSourceFile('borrowForm.pdf');
for ($i = 1; $i <= $pageCount; $i++) {
    $mpdf->AddPage();
    $templateId = $mpdf->ImportPage($i);
    $mpdf->UseTemplate($templateId);
}
$html = $user . $tel . $department . $address . $teacher . $date_start . $date_end . $checked1 . $checked2 . $projecter . $Notebook1 . $VGA . $Notebook2 . $MacBook . $HDMI_to_VGA . $Opaque_projector . $Audio1 . $wireless_microphone . $wired_microphone . $audio_cable . $Extension_plug;
$mpdf->WriteHTML($html);

// $mpdf->WriteHTML(var_dump(trim($group['products_name'])));
// $mpdf->WriteHTML(var_dump(trim($group['products_name'])));
// $mpdf->WriteHTML(var_dump(trim($group['products_name'])));
// $mpdf->WriteHTML(var_dump(trim($group['products_name'])));
// $mpdf->WriteHTML(var_dump(trim($group['products_name'])));
$mpdf->Output();
