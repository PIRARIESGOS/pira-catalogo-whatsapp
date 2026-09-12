<?php
/**
 * Envío del formulario de Contáctenos del catálogo PIRA RIESGOS.
 * Requiere PHP con mail() habilitado en el hosting (mismo servidor que
 * atiende /contacto.php en pirariesgos.com). No necesita base de datos.
 *
 * Si este archivo no existe o el hosting no soporta PHP (por ejemplo, la
 * copia estática publicada en GitHub Pages), js/script.js detecta el fallo
 * de red y cae de vuelta al enlace mailto: como respaldo.
 */

header('Content-Type: application/json; charset=UTF-8');

function responder($ok, $mensaje) {
    http_response_code($ok ? 200 : 400);
    echo json_encode(['ok' => $ok, 'mensaje' => $mensaje], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(false, 'Método no permitido.');
}

// Honeypot anti-spam: si el campo oculto llegó lleno, es un bot — respondemos
// éxito falso para no darle pistas, pero no enviamos nada.
if (!empty($_POST['empresa_web'])) {
    responder(true, 'Recibido.');
}

function limpiar($valor) {
    $valor = trim((string) $valor);
    // Evita inyección de encabezados si algún campo se llegara a usar en headers.
    // (El cuerpo del correo es texto plano, así que no se escapa como HTML.)
    return str_replace(["\r", "\n"], ' ', $valor);
}

$nombre    = limpiar($_POST['nombre'] ?? '');
$empresa   = limpiar($_POST['empresa'] ?? '');
$correo    = trim((string) ($_POST['correo'] ?? ''));
$telefono  = limpiar($_POST['telefono'] ?? '');
$cargo     = limpiar($_POST['cargo'] ?? '');
$necesidad = limpiar($_POST['necesidad'] ?? '');
$mensaje   = limpiar($_POST['mensaje'] ?? '');

if ($nombre === '' || $correo === '') {
    responder(false, 'Nombre y correo corporativo son obligatorios.');
}
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    responder(false, 'El correo no es válido.');
}
$correoLimpio = str_replace(["\r", "\n"], '', $correo);

$destinatario = 'contactenos@pirariesgos.com';
$asunto = '=?UTF-8?B?' . base64_encode('Solicitud de asesoria (catalogo) - ' . $nombre . ($empresa !== '' ? ' - ' . $empresa : '')) . '?=';

$cuerpo = "Nuevo mensaje desde el formulario del catálogo (pirariesgos.com/catalogo/)\n\n"
    . "Nombre: {$nombre}\n"
    . "Empresa: " . ($empresa !== '' ? $empresa : '-') . "\n"
    . "Correo corporativo: {$correoLimpio}\n"
    . "Teléfono / WhatsApp: " . ($telefono !== '' ? $telefono : '-') . "\n"
    . "Cargo: " . ($cargo !== '' ? $cargo : '-') . "\n"
    . "¿Qué necesita?: " . ($necesidad !== '' ? $necesidad : '-') . "\n\n"
    . "Mensaje:\n" . ($mensaje !== '' ? $mensaje : '-') . "\n";

$cabeceras = [
    'From: PIRA RIESGOS Web <no-responder@pirariesgos.com>',
    'Reply-To: ' . $correoLimpio,
    'Content-Type: text/plain; charset=UTF-8',
];

$enviado = @mail($destinatario, $asunto, $cuerpo, implode("\r\n", $cabeceras));

if ($enviado) {
    responder(true, 'Recibido. Le responderemos pronto.');
}

responder(false, 'No se pudo enviar en este momento.');
