<?php

namespace Controllers;

use MVC\Router;
use Model\Contacto;
use Model\Paciente;
use Model\CitaMedica;
use Model\PacienteCitaMedica;
use Classes\Email;

class SitioController {

    public static function inicio(Router $router) {
        session_start();
        // Puedes agregar cualquier lógica necesaria aquí

        $router->render('site/inicio', [
            'titulo' => 'Página de Inicio',
        ], 'site-layout');
    }

    public static function mapa(Router $router) {
        session_start();
        // Puedes agregar cualquier lógica necesaria aquí

        $router->render('site/mapa', [
            'titulo' => 'Ubicacion',
        ], 'site-layout');
    }

    public static function about(Router $router) {
        session_start();
        // Puedes agregar cualquier lógica necesaria aquí

        $router->render('site/about', [
            'titulo' => 'Nosotros',
        ], 'site-layout');
    }

    public static function services(Router $router) {
        session_start();
        // Puedes agregar cualquier lógica necesaria aquí

        $router->render('site/services', [
            'titulo' => 'Nuestros Servicios',
        ], 'site-layout');
    }

    public static function privacy(Router $router) {
        session_start();
        // Puedes agregar cualquier lógica necesaria aquí

        $router->render('site/privacy', [
            'titulo' => 'Politicas de Privacidad',
        ], 'site-layout');
    }

    public static function terms(Router $router) {
        session_start();
        // Puedes agregar cualquier lógica necesaria aquí

        $router->render('site/terms', [
            'titulo' => 'Terminos & Condiciones',
        ], 'site-layout');
    }

    

    public static function contacto(Router $router) {
        session_start();
        $alertas = [];
        $contacto = new Contacto([]); // Inicializar $contacto aquí
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contacto->sincronizar($_POST);
    
            // Asignar la fecha de creación
            $contacto->creado = date('Y-m-d H:i:s');
    
            // Continuar con el flujo normal de validación y guardado
            $alertas = $contacto->validar();
    
            if (empty($alertas)) {
                try {
                    $resultado = $contacto->guardar();
    
                    if ($resultado) {
                        // Enviar el mensaje de contacto
                        $email = new Email(
                            $contacto->email,
                            $contacto->nombre,
                            $contacto->asunto,
                            $contacto->mensaje
                        );
                        $email->enviarMensajeContacto($contacto->nombre, $contacto->email, $contacto->asunto, $contacto->mensaje);
    
                        $alertas['success'][] = 'Se guardó y envió tu mensaje.';
                    } else {
                        $alertas['error'][] = 'Error al enviar el mensaje. Inténtalo de nuevo.';
                    }
                } catch (\Exception $e) {
                    $alertas['error'][] = 'Error al guardar el mensaje: ' . $e->getMessage();
                }
            }
        }
    
        $router->render('site/contacto', [
            'titulo' => 'Contacto',
            'alertas' => $alertas,
            'contacto' => $contacto
        ], 'site-layout');
    }
    
    
    
    
    
    
    
    
    

    public static function agendar_cita(Router $router)
    {
        session_start();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $aceptar_terminos = isset($_POST['aceptar_terminos']) ? 1 : 0;
            $cita = new CitaMedica($_POST);
            $cita->aceptar_terminos = $aceptar_terminos;

            // Validar la cita
            $alertas = $cita->validar();

            if (empty($alertas)) {
                // Verificar si el correo electrónico ya está registrado
                $emailExistente = CitaMedica::buscarPorEmail($cita->email);
                
                if ($emailExistente) {
                    $alertas['warning'][] = 'Ya hay una cita registrada con este correo electrónico. Si necesita soporte, por favor contáctenos.';
                    
                    // Enviar notificación por WhatsApp
                    $mensaje_whatsapp = "Hola, ya existe una cita registrada con este correo electrónico: " . $cita->email . ". Por favor, contáctenos si necesita soporte.";
                    // Aquí deberías llamar a una función para enviar el mensaje por WhatsApp
                } else {
                    $resultado = $cita->guardar();

                    if ($resultado) {
                        // Generar un token para la confirmación (si es necesario)
                        $token = bin2hex(random_bytes(16)); // Genera un token de ejemplo
                        
                        // Enviar correo de confirmación con la fecha y hora de la cita
                        $email = new Email($cita->email, $cita->nombre, $token, $cita->fecha_hora);
                        try {
                            $email->enviarNotificacionCita(); // Método que envía el correo
                            $alertas['success'][] = 'La cita ha sido agendada correctamente. Se ha enviado una notificación a su correo electrónico.';
                        } catch (Exception $e) {
                            $alertas['error'][] = 'Error al enviar la notificación de la cita.';
                        }
                    } else {
                        $alertas['error'][] = 'Error al agendar la cita.';
                    }
                }
            }
        }

        $router->render('site/agendar_cita', [
            'titulo' => 'Agenda Tu Cita',
            'alertas' => $alertas
        ], 'site-layout');
    }



    



    


    
    
    

    
    

}
