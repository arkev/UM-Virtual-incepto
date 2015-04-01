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
define('DB_NAME', 'umv');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'umv');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'sitioNuevoUMVirt.15');

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
define('AUTH_KEY', 'roPhzK>Jw!3m^%6+Fm+VF0yxce]iKLBz*T6q63f(-/f-nQ2@XF~ee*Wn m@+a<]|'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', '<=z=w7e`;?E:`ABAGx*mO)lLO+w eZGjmUej#!Em@RY_F[dt1bxyi_}Zal^y!)P)'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', '%4e>{os=s7TtJELbkX>:{?oG*.[c<N$,Ld;j-A0p&rNDkI#-1#x}F<QsbYKW[^^3'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', 'yg*WOQET[( Z5D-m;{e<@%K%|c5chW|OoZH!TH~9wgc(` 9+AKlOHV<E{7Pz3nQ9'); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', 'FY.OGQHgp?+3wZZdM8Ie;x75qd/[{SH<+vs3>0BA4z=LG5fOg|VMx-=X:AR^}-Pd'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', 'bl@T,.X}LL^tQ(wb.i`or:jRhJLz7G}`}FFO%>uK4YOQkK;5h& m~gs0VXrNLV[Z'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', '3hVG+Z$pb&kg2oQ -&-T6j3xt#x$AD(4U/08~Xt~/M@v.Dv%-V%_Q:5 Zd2|zcvk'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', 'ZH+w5GUb$^s[o!x1+t+A-=DpY>D*2?Or^|,JBN$ZaJiE&Z4 hSn<|3t/8-Dn|c]z'); // Cambia esto por tu frase aleatoria.

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';

/**
 * Idioma de WordPress.
 *
 * Cambia lo siguiente para tener WordPress en tu idioma. El correspondiente archivo MO
 * del lenguaje elegido debe encontrarse en wp-content/languages.
 * Por ejemplo, instala ca_ES.mo copiándolo a wp-content/languages y define WPLANG como 'ca_ES'
 * para traducir WordPress al catalán.
 */
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
