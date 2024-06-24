<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composerのオートローダーを読み込む

// PHPMailerのインスタンスを作成
$mail = new PHPMailer(true);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームから送信されたデータを取得
    $from_mail = htmlspecialchars($_POST['from_mail']);
    $from_name = htmlspecialchars($_POST['from_name']);
    $to_mail = htmlspecialchars($_POST['to_mail']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);
    
    // セッションにデータを保存
    $_SESSION['from_mail'] = $from_mail;
    $_SESSION['from_name'] = $from_name;
    $_SESSION['to_mail'] = $to_mail;
    $_SESSION['subject'] = $subject;
    $_SESSION['message'] = $message;
} else {
    // POSTリクエストでない場合、ページAにリダイレクト
    header("Location: form_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mail Confirm Page</title>
</head>
<body>
    <h2>Confirm Your Data</h2>
    <p>From Email: <?php echo $from_mail; ?></p>
    <p>From Name: <?php echo $from_name; ?></p>
    <p>To Email: <?php echo $to_mail; ?></p>
    <p>Subject: <?php echo $subject; ?></p>
    <p>Message: <?php echo nl2br($message); ?></p>
    
    <form action="response_page.php" method="post" style="display:inline;">
        <input type="submit" name="ok" value="OK">
    </form>
    <form action="form_page.php" method="post" style="display:inline;">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</body>
</html>
