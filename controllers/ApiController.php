<?php

namespace Controllers;

use MVC\Router;

class ApiController {
    
    public static function getDatosCodigoPostal() {
        $codigoPostal = $_GET['codigo_postal'] ?? '';
        $token = 'b487c76a-29db-4a5d-aee8-75a8519f6add';

        header('Content-Type: application/json');

        if (empty($codigoPostal)) {
            echo json_encode(['error' => 'Código postal no proporcionado']);
            exit();
        }

        $url = "https://api.copomex.com/v1/CP/$codigoPostal";

        // Inicializa cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $token"
        ]);

        // Ejecuta la solicitud
        $response = curl_exec($ch);

        // Manejo de errores de cURL
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            echo json_encode(['error' => $error_msg]);
        } else {
            // Verifica el código de estado HTTP
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code === 200) {
                $data = json_decode($response, true);

                // Log de la respuesta completa para depuración
                error_log("API Response: " . print_r($data, true));

                if (isset($data['response']) && !empty($data['response'])) {
                    echo json_encode($data); // Mostrar datos completos
                } else {
                    echo json_encode(['error' => 'Datos del código postal no encontrados']);
                }
            } else {
                echo json_encode(['error' => 'Código postal no encontrado', 'code' => $http_code]);
            }
        }

        curl_close($ch);
    }
}
