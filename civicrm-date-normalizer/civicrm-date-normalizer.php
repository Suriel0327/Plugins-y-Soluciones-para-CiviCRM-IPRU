<?php
/**
 * Plugin Name: CiviCRM Date Normalizer
 * Description: Normaliza todas las fechas "Select Date" enviadas hacia CiviCRM, convirtiendo dd/mm/yyyy → yyyy-mm-dd antes del almacenamiento.
 * Version: 1.0
 * Author: Suriel
 */

if (!defined('ABSPATH')) exit;

add_action('init', function () {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    // Recorremos todos los campos enviados por POST
    foreach ($_POST as $key => $value) {

        // Ignorar arrays (archivos, etc.)
        if (is_array($value)) continue;

        // Detecta fechas tipo dd/mm/yyyy o d/m/yyyy
        if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', trim($value), $m)) {

            $day   = str_pad($m[1], 2, '0', STR_PAD_LEFT);
            $month = str_pad($m[2], 2, '0', STR_PAD_LEFT);
            $year  = $m[3];

            // Convertimos al formato correcto para MySQL
            $normalized = "$year-$month-$day";

            // Reemplaza en el POST
            $_POST[$key] = $normalized;
        }
    }
});
