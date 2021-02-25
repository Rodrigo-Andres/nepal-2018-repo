<?php

require_once('phpmailer/class.phpmailer.php');

$mail = new PHPMailer();

if( isset( $_POST['template-contactform-submit'] ) AND $_POST['template-contactform-submit'] == 'submit' ) {
    if( $_POST['template-contactform-name'] != '' AND $_POST['template-contactform-email'] != '' AND $_POST['template-contactform-message'] != '' ) {

        $name = $_POST['template-contactform-name'];
        $email = $_POST['template-contactform-email'];
        $phone = $_POST['template-contactform-phone'];
        $service = $_POST['template-contactform-service'];
        $subject = $_POST['template-contactform-subject'];
        $message = $_POST['template-contactform-message'];

        $subject = isset($subject) ? $subject : 'New Message From Contact Form';

        $botcheck = $_POST['template-contactform-botcheck'];

        $toemail = 'semicolonweb@gmail.com'; // Your Email Address
        $toname = 'SemiColon'; // Your Name

        if( $botcheck == '' ) {

            $mail->SetFrom( $email , $name );
            $mail->AddReplyTo( $email , $name );
            $mail->AddAddress( $toemail , $toname );
            $mail->Subject = $subject;

            $name = isset($name) ? "Name: $name<br><br>" : '';
            $email = isset($email) ? "Email: $email<br><br>" : '';
            $phone = isset($phone) ? "Phone: $phone<br><br>" : '';
            $service = isset($service) ? "Service: $service<br><br>" : '';
            $message = isset($message) ? "Message: $message<br><br>" : '';

            $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>This Form was submitted from: ' . $_SERVER['HTTP_REFERER'] : '';

            $body = "$name $email $phone $service $message $referrer";

            if ( isset( $_FILES['template-contactform-cvfile'] ) && $_FILES['template-contactform-cvfile']['error'] == UPLOAD_ERR_OK ) {
                $mail->IsHTML(true);
                $mail->AddAttachment( $_FILES['template-contactform-cvfile']['tmp_name'], $_FILES['template-contactform-cvfile']['name'] );
            }

            $mail->MsgHTML( $body );
            $sendEmail = $mail->Send();

            if( $sendEmail == true ):
                echo 'Hemos recibido <strong>exitosamente</strong> tu mensaje, si lo requieres nos pondremos en contacto contigo a más tardar 16 horas (días laborales).';
            else:
                echo 'El correo <strong>no se ha podido enviar</strong> debido a un error inesperado. Por favor intente de nuevo más tarde.<br /><br /><strong>Reason:</strong><br />' . $mail->ErrorInfo . '';
            endif;
        } else {
            echo 'Bot <strong>Detected</strong>.! Clean yourself Botster.!';
        }
    } else {
        echo 'Por favor <strong>llene todos los campos</strong> marcados con el asterisco y intente de nuevo.';
    }
} else {
    echo 'Un error <strong>inesperado ocurrió.</strong> Por favor intente de nuevo más tarde.';
}

?>