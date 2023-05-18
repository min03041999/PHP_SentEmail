<?php 
    ob_start();
    session_start();

    require("./assets/PHPMailer/src/Exception.php");
    require("./assets/PHPMailer/src/PHPMailer.php");
    require("./assets/PHPMailer/src/SMTP.php");
     
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $email = $_POST['email'];
    $img = $_POST['chart'];

    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    $date = date('Y-m-d H:i:s');
    $date = str_replace(" ", "", str_replace(":", "", str_replace("-", "", $date)));
    $fileName = $date . '.png';
    file_put_contents('upload/'. $fileName, $fileData);


    /** send mail handle */
    $mail  = new PHPMailer();
    
    try {
        $mail ->SMTPDebug = 1;
        $mail ->isSMTP();
        $mail ->Host       = 'smtp.gmail.com';// Địa chỉ máy chủ SMTP của bạn
        $mail ->SMTPAuth   = true;
        $mail ->Username   = 'malik03041999@gmail.com'; // Tên đăng nhập của bạn
        $mail ->Password   = 'pkemgkljajxgokty'; // Mật khẩu của bạn
        $mail ->isHTML(true);
        $mail ->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Sử dụng STARTTLS
        $mail ->Port       = 587; // Cổng SMTP của bạn
       
        //Recipients
        $mail ->setFrom('min03012341999@gmail.com', 'Min');
        $mail ->addAddress('quandinh3492@gmail.com', 'Dinh'); // Add a recipient
        // Content
        $mail ->isHTML(true);   // Set email format to HTML
        $mail ->Subject = 'Chart';
        $mail ->AddEmbeddedImage('upload/'. $fileName, 'chart', 'upload'. $fileName); // attach file logo.jpg, and later link to it using identfier logoimg
        $mail ->Body = "<h1>Xin chào</h1><img src=\"cid:chart\" style='width: 600px; height: 300px'/>";
        $mail ->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail ->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail ->ErrorInfo}";
    }
?>