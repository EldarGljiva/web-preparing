<?php

require "../vendor/autoload.php";
require "./services/MidtermService.php";
require "./services/FinalService.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::register('midtermService', 'MidtermService');
Flight::register('finalService', 'FinalService');



/** TODO
 * Add middleware to protect routes rest/final/share_classes AND rest/final/share_class_categories
 */
Flight::route("/*", function () {
    $path = Flight::request()->url;
    if ($path == '/login' || $path == '/rest/final/login' || $path == '/final/login' || $path = '/register') {
        return TRUE;
    }
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        Flight::json(['error' => "Authorization header is missing"], 401);
        return FALSE;
    }
    $token = $headers['Authorization'];
    try {
        $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
        Flight::set('token', $decoded_token);
        return TRUE;
    } catch (Exception $e) {
        Flight::json(['error' => 'Unauthorized access: Invalid token'], 401);
        return FALSE;
    }
});

require 'routes/MidtermRoutes.php';
require 'routes/FinalRoutes.php';

Flight::start();
