<?php

namespace Classes;

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

class Email
{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        $mail = new PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->SMTPSecure = $_ENV['EMAIL_SSL'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];

            $mail->setFrom('contacto@natuexp.com', 'NatuExp');
            $mail->addAddress($this->email, $this->nombre);
            $mail->Subject = 'Confirma tu Cuenta';

            $mail->isHTML(TRUE);
            $mail->CharSet = 'UTF-8';

            $contenido = '
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                        color: #333;
                    }
                    .container {
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #ffffff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        background-color: #3F4CB4;
                        padding: 10px;
                        text-align: center;
                        color: #ffffff;
                        border-radius: 10px 10px 0 0;
                    }
                    .content {
                        padding: 20px;
                        text-align: left;
                    }
                    .button {
                        display: inline-block;
                        background-color: #3F4CB4;
                        color: #ffffff;
                        padding: 10px 20px;
                        text-align: center;
                        text-decoration: none;
                        border-radius: 5px;
                        margin-top: 20px;
                    }
                    .footer {
                        margin-top: 20px;
                        text-align: center;
                        font-size: 12px;
                        color: #3F4CB4;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>Confirma tu Cuenta</h1>
                    </div>
                    <div class="content">
                        <p><strong>Hola ' . htmlspecialchars($this->nombre) . '</strong>,</p>
                        <p>Has registrado correctamente tu cuenta en Expedientes Clínicos de Nutracéuticos de México; pero es necesario confirmarla.</p>
                        <p>Presiona el siguiente botón para confirmar tu cuenta:</p>
                        <a class="button" href="' . $_ENV['HOST'] . 'confirmar?token=' . htmlspecialchars($this->token) . '">Confirmar Cuenta</a>
                        <p>Si tú no creaste esta cuenta, puedes ignorar este mensaje.</p>
                    </div>
                    <div class="footer">
                        <p>&copy; ' . date('Y') . ' NatuExp. Todos los derechos reservados.</p>
                    </div>
                </div>
            </body>
            </html>';

            $mail->Body = $contenido;

            $mail->send();
        } catch (Exception $e) {
            echo "Error al enviar la confirmación del correo: {$e->getMessage()}";
        }
    }

    public function enviarInstrucciones()
    {
        $mail = new PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->SMTPSecure = $_ENV['EMAIL_SSL'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];

            $mail->setFrom('contacto@natuexp.com', 'NatuExp');
            $mail->addAddress($this->email, $this->nombre);
            $mail->Subject = 'Reestablece tu Contraseña';

            $mail->isHTML(TRUE);
            $mail->CharSet = 'UTF-8';

            $contenido = '
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                        color: #333;
                    }
                    .container {
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #ffffff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        background-color: #3F4CB4;
                        padding: 10px;
                        text-align: center;
                        color: #ffffff;
                        border-radius: 10px 10px 0 0;
                    }
                    .content {
                        padding: 20px;
                        text-align: left;
                    }
                    .button {
                        display: inline-block;
                        background-color: #3F4CB4;
                        color: #ffffff;
                        padding: 10px 20px;
                        text-align: center;
                        text-decoration: none;
                        border-radius: 5px;
                        margin-top: 20px;
                    }
                    .footer {
                        margin-top: 20px;
                        text-align: center;
                        font-size: 12px;
                        color: #3F4CB4;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>Reestablece tu Contraseña</h1>
                    </div>
                    <div class="content">
                        <p><strong>Hola ' . htmlspecialchars($this->nombre) . '</strong>,</p>
                        <p>Has solicitado reestablecer tu contraseña. Sigue el siguiente enlace para hacerlo.</p>
                        <p>Presiona el siguiente botón para reestablecer tu contraseña:</p>
                        <a class="button" href="' . $_ENV['HOST'] . 'reestablecer?token=' . htmlspecialchars($this->token) . '">Reestablecer Contraseña</a>
                        <p>Si tú no solicitaste este cambio, puedes ignorar este mensaje.</p>
                    </div>
                    <div class="footer">
                        <p>&copy; ' . date('Y') . ' NatuExp. Todos los derechos reservados.</p>
                    </div>
                </div>
            </body>
            </html>';

            $mail->Body = $contenido;

            $mail->send();
        } catch (Exception $e) {
            echo "Error al enviar el restablecimiento de la contraseña: {$e->getMessage()}";
        }
    }

    public function enviarNotificacionCita()
    {
        $mail = new PHPMailer();
        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->SMTPSecure = $_ENV['EMAIL_SSL'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];

            $mail->setFrom('contacto@natuexp.com', 'NatuExp');
            $mail->addAddress($this->email, $this->nombre);
            $mail->Subject = 'Confirmación de Cita Médica';

            $mail->isHTML(TRUE);
            $mail->CharSet = 'UTF-8';

            $contenido = '
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                        color: #333;
                    }
                    .container {
                        width: 100%;
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #ffffff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    .header {
                        background-color: #3F4CB4;
                        padding: 10px;
                        text-align: center;
                        color: #ffffff;
                        border-radius: 10px 10px 0 0;
                    }
                    .content {
                        padding: 20px;
                        text-align: left;
                    }
                    .footer {
                        margin-top: 20px;
                        text-align: center;
                        font-size: 12px;
                        color: #3F4CB4;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>Confirmación de Cita Médica</h1>
                    </div>
                    <div class="content">
                        <p><strong>Hola ' . htmlspecialchars($this->nombre) . '</strong>,</p>
                        <p>Tu cita médica ha sido agendada correctamente.</p>
                        <p>Nos vemos en la fecha y hora acordadas. Si tienes alguna duda o necesitas cambiar tu cita, no dudes en contactarnos.</p>
                    </div>
                    <div class="footer">
                        <p>&copy; ' . date('Y') . ' NatuExp. Todos los derechos reservados.</p>
                    </div>
                </div>
            </body>
            </html>';

            $mail->Body = $contenido;

            $mail->send();
        } catch (Exception $e) {
            echo "Error al enviar la confirmación de la cita: {$e->getMessage()}";
        }
    }

}