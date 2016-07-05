<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'umvirtual_actual');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'root');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+7(oP8sE*^o}ckkOS+-mI0-J|?{oa@9c.iTC[~H.YD{Kvd:-[65F5AopEim-O z>');
define('SECURE_AUTH_KEY',  'lriFUBVn-gL[?*o6Zc>W1pA:bQT5>hjjQW*G78zZZ!zQp%nJ;O7nDD-AMu%R<Rb(');
define('LOGGED_IN_KEY',    'V},XB&~&wQqYXWKcC8fGaQD;-kofn/tYeIoA@qTHXszD~x$hgL&m>gWQH-O501S5');
define('NONCE_KEY',        'DZ><NMa4lyvGrW|f,+s.i-d|Hddu+1WK;HRwJ@Im}sVJl}=HRy9DLc|JM&1V5Zo%');
define('AUTH_SALT',        '9F9z_!6>;~|)cev}xs[?[x2sRi?B}Z6ZN[`}ReX(<U@KeSIg-S;9&87&>Pn}DC8G');
define('SECURE_AUTH_SALT', '|0A8H{g?p$SV=-+~+s`dm_ZIfgQn8I7-+at#.MVJe3EBp-g3mbH]ImKKWhlER8]4');
define('LOGGED_IN_SALT',   'L8+F_%^T7Uk-4aONr#YP5J2,5bUu+F4wXH45:F~qpE!$dTc;O#fdfcCvxNv}V&mb');
define('NONCE_SALT',       'e$abOjT|)Z.7Br3E7jWB/ji(}<YK<NfeOPmk0EEnecv=b9CEDr{zrNmXW^ ,?@[(');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';

define('WPLANG', 'es_ES');
/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

