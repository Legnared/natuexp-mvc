<?php

namespace Controllers;

use MVC\Router;
use Model\Contacto;
use Model\CitaMedica;

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
        $contacto = new Contacto();

       //debuguear($contacto);
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contacto->sincronizar($_POST);
            //debuguear($contacto);
            $contacto->creado = date('Y-m-d H:i:s');
    
            // Validar los datos del formulario
            $alertas = $contacto->validar();
    
            //debuguear($alertas); // Verifica si hay alertas de validación
    
            if (empty($alertas)) {
                try {
                    $resultado = $contacto->guardar();
                    //debuguear($resultado); // Verifica el resultado del guardado
    
                    if ($resultado) {
                        $alertas['success'][] = 'Se guardó y envió tu mensaje.';
                    } else {
                        $alertas['danger'][] = 'Error al enviar el mensaje. Inténtalo de nuevo.';
                    }
                } catch (\Exception $e) {
                    $alertas['danger'][] = 'Error al guardar el mensaje: ' . $e->getMessage();
                }
            }
        }
    
        $router->render('site/contacto', [
            'titulo' => 'Contacto',
            'alertas' => $alertas,
            'contacto' => $contacto
        ], 'site-layout');
    }

    public static function agendar_cita(Router $router) {
        session_start();
        $alertas = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cita = new CitaMedica($_POST);
    
            // Validar la cita
            $alertas = $cita->validar();
    
            // Si no hay alertas, guardar la cita
            if (empty($alertas)) {
                $resultado = $cita->guardar();
    
                if ($resultado) {
                    $alertas['success'][] = 'La cita se ha agendado correctamente.';
                } else {
                    $alertas['danger'][] = 'Hubo un error al agendar la cita.';
                }
            }
        }
    
        $router->render('site/agendar_cita', [
            'titulo' => 'Agenda Tú Cita',
            'alertas' => $alertas
        ], 'site-layout');
    }
    
    
}
