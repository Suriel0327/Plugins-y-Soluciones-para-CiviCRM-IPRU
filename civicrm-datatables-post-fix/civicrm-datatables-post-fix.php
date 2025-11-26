<?php
/*
Plugin Name: CiviCRM Multirecord POST Fix
Description: Fuerza que las tablas multiregistro usen POST para evitar errores 414.
Version: 1.0
*/

add_action('init', function () {
    if (!function_exists('CRM_Core_Page_AJAX::multirecordfieldlist')) {
        return;
    }

    // Sobrecargar la ruta para usar POST
    add_filter('civicrm_alterMenu', function ($menu) {

        if (!empty($menu['civicrm/ajax/multirecordfieldlist'])) {
            $menu['civicrm/ajax/multirecordfieldlist']['is_get'] = 0;  // Desactivar GET
            $menu['civicrm/ajax/multirecordfieldlist']['is_post'] = 1; // Activar POST
        }

        return $menu;
    });
});
