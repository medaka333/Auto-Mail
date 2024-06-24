<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Composerのオートローダーを読み込む

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['ok'])) {
        // セッションからデータを取得
        $from_mail = $_SESSION['from_mail'];
        $from_name = $_SESSION['from_name'];
        $to_mail = $_SESSION['to_mail'];
        $subject = htmlspecialchars($_SESSION['subject']);
        $message = htmlspecialchars($_SESSION['message']);

        $to_emails = explode(',', $to_mail);
        $successfulEmails = [];
        $failedEmails = [];

        foreach ($to_emails as $to_email) {
            $to_email = trim($to_email);
            $mail = new PHPMailer(true);

            try {
                // SMTP設定
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // GmailのSMTPサーバー
                $mail->SMTPAuth = true;
                $mail->Username = 'your_mail@gmail.com'; // あなたのGmailのメールアドレス
                $mail->Password = 'your_password'; // GmailのApp Password
                $mail->SMTPSecure = 'tls'; // SSLまたはTLSを使用
                $mail->Port = 587; // GmailのTLSポート

                // 送信者設定
                $mail->setFrom($from_mail, $from_name);

                // 受信者設定
                $mail->addAddress($to_email);

                // メール内容
                $mail->isHTML(true); // HTML形式を使用する場合はtrueに設定
                $mail->CharSet = 'UTF-8'; // 文字セットをUTF-8に設定
                $mail->Subject = $subject; // 件名をセット
                $mail->Body    = nl2br($message);

                // メールを送信
                $mail->send();
                $successfulEmails[] = $to_email;
            } catch (Exception $e) {
                $failedEmails[] = $to_email . ": " . $mail->ErrorInfo;
            }
        }

        // 成功と失敗の結果を表示
        if (!empty($successfulEmails)) {
            echo "Emails sent successfully to: " . implode(', ', $successfulEmails) . "<br>";
        }
        if (!empty($failedEmails)) {
            echo "Failed to send email to: " . implode(', ', $failedEmails) . "<br>";
        }

        // データの表示
        echo "From Email: " . $from_mail . "<br>";
        echo "From Name: " . $from_name . "<br>";
        echo "To Email: " . $to_mail . "<br>";
        echo "Subject: " . $subject . "<br>";
        echo "Message: " . nl2br($message) . "<br>";
    }
} else {
    // POSTリクエストでない場合、ページAにリダイレクト
    header("Location: form_page.php");
    exit();
}

// セッションデータのクリア
session_unset();
session_destroy();
?>
<br>
<a href="form_page.php">Back to Form</a>
</body>
</html>
