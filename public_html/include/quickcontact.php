<?php

require_once('phpmailer/class.phpmailer.php');

$mail = new PHPMailer();

if( isset( $_POST['quick-contact-form-submit'] ) AND $_POST['quick-contact-form-submit'] == 'submit' ) {
    if( $_POST['quick-contact-form-name'] != '' AND $_POST['quick-contact-form-email'] != '' AND $_POST['quick-contact-form-message'] != '' ) {

        $name = $_POST['quick-contact-form-name'];
        $email = $_POST['quick-contact-form-email'];
        $message = $_POST['quick-contact-form-message'];

        $subject = 'New Message From Quick Contact Form';

        $botcheck = $_POST['quick-contact-form-botcheck'];

        $toemail = 'laboratoriosnepal@gmail.com'; // Your Email Address
        $toname = 'NEPAL Instituto Químico Terapéutico'; // Your Name

        if( $botcheck == '' ) {

            $mail->SetFrom( $email , $name );
            $mail->AddReplyTo( $toemail , $toname );
            $mail->AddAddress( $toemail , $toname );
            $mail->Subject = $subject;

            $name = isset($name) ? "Name: $name<br><br>" : '';
            $email = isset($email) ? "Email: $email<br><br>" : '';
            $message = isset($message) ? "Message: $message<br><br>" : '';

            $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>This Form was submitted from: ' . $_SERVER['HTTP_REFERER'] : '';

            $body = "$name $email $message $referrer";

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