<?php
/**
 * Envío del formulario de Contáctenos del catálogo PIRA RIESGOS, por SMTP
 * real con PHPMailer (mismo servidor de correo que usa contacto.php en
 * pirariesgos.com — mail() sencillo cae en spam con mucha frecuencia).
 *
 * Requiere:
 *  - libs/PHPMailer/ (ya incluido en este mismo folder, vendored, sin Composer).
 *  - config.local.php en esta carpeta, con la clave real del buzón — NO se
 *    sube a Git (ver .gitignore). Cópielo desde config.example.php.
 *
 * Si config.local.php no existe (por ejemplo, la copia estática publicada en
 * GitHub Pages, que no tiene backend), responde con error controlado y
 * js/script.js cae de vuelta al enlace mailto: como respaldo.
 */

header('Content-Type: application/json; charset=UTF-8');

function responder($ok, $mensaje) {
    http_response_code($ok ? 200 : 400);
    echo json_encode(['ok' => $ok, 'mensaje' => $mensaje], JSON_UNESCAPED_UNICODE);
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responder(false, 'Método no permitido.');
}

// Honeypot anti-spam: si el campo oculto llegó lleno, es un bot — respondemos
// éxito falso para no darle pistas, y ni siquiera cargamos PHPMailer.
if (!empty($_POST['empresa_web'])) {
    responder(true, 'Recibido.');
}

$configPath = __DIR__ . '/config.local.php';
if (!file_exists($configPath)) {
    responder(false, 'Config no disponible en este servidor.');
}
require $configPath;

if (SMTP_CLAVE === '') {
    responder(false, 'Falta configurar la clave SMTP en config.local.php.');
}

require __DIR__ . '/libs/PHPMailer/Exception.php';
require __DIR__ . '/libs/PHPMailer/PHPMailer.php';
require __DIR__ . '/libs/PHPMailer/SMTP.php';

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

$cuerpo = "Nuevo mensaje desde el formulario del catálogo (pirariesgos.com/catalogo/)\n\n"
    . "Nombre: {$nombre}\n"
    . "Empresa: " . ($empresa !== '' ? $empresa : '-') . "\n"
    . "Correo corporativo: {$correo}\n"
    . "Teléfono / WhatsApp: " . ($telefono !== '' ? $telefono : '-') . "\n"
    . "Cargo: " . ($cargo !== '' ? $cargo : '-') . "\n"
    . "¿Qué necesita?: " . ($necesidad !== '' ? $necesidad : '-') . "\n\n"
    . "Mensaje:\n" . ($mensaje !== '' ? $mensaje : '-') . "\n";

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->Port       = SMTP_PUERTO;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USUARIO;
    $mail->Password   = SMTP_CLAVE;
    $mail->SMTPSecure = SMTP_SEGURIDAD === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom(SMTP_USUARIO, 'PIRA RIESGOS - Catálogo');
    $mail->addAddress(CATALOGO_DESTINATARIO);
    $mail->addReplyTo($correo, $nombre);

    $mail->Subject = 'Solicitud de asesoria (catalogo) - ' . $nombre . ($empresa !== '' ? ' - ' . $empresa : '');
    $mail->isHTML(false);
    $mail->Body = $cuerpo;

    $mail->send();
    responder(true, 'Recibido. Le responderemos pronto.');
} catch (PHPMailerException $e) {
    error_log('enviar.php (catalogo) PHPMailer error: ' . $mail->ErrorInfo);
    responder(false, 'No se pudo enviar en este momento.');
}
