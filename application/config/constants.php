<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */

// Define Ajax Request
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

// ESTADOS DE LOS PRESUPUESTOS/CIRUGIAS
define('PRESUPUESTO_PENDIENTE', 0);
define('PRESUPUESTO_ANULADO', 1);
define('CIRUGIA_PENDIENTE', 2);
define('CIRUGIA_REALIZADA', 3);
define('CIRUGIA_SUSPENDIDA', 4);
define('CIRUGIA_ANUALADA', 5);
define('CIRUGIA_ENPROCESO', 6);
define('CIRUGIAS_APROBADAS', 9);

// TIPO DE ITEMS
define('CAJA_INTERNA', 0);
define('CAJA_TERCEROS', 1);
define('STOCK_SUELTO', 2);
define('INGRESO_MANUAL', 3);
define('STOCK_TRAZADO', 4);

// DISTRIBUIDORES - DEPOSITOS
define('FABRICA', 1);
define('CIRUGIA', 2);

// ESTADO DE LAS ORDENDES DE TRABAJO
define('PENDIENTE', 0);
define('REALIZADA', 1);

// ESTADO DE LOS REMITOS
define('REMITO_PENDIENTE', 0);
define('REMITO_EJECTADO', 1);
define('REMITO_CERRADO', 2);

// ESTADO DE LOS ITEMS DE STOCK
define('STOCKITEM_DISPONIBLE', 0);
define('STOCKITEM_EJECTADO', 1);
define('STOCKITEM_APLICADO', 2);