<?php
/**
 * Plantilla de configuración para enviar.php (formulario de Contáctenos).
 *
 * En el SERVIDOR (no en Git): copie este archivo como "config.local.php" en
 * esta misma carpeta y ponga ahí la clave real del buzón. "config.local.php"
 * está en .gitignore a propósito — nunca debe subirse al repositorio público.
 *
 * Los valores de host/puerto/usuario de abajo son los mismos que ya usa
 * contacto.php en pirariesgos.com — solo falta la clave.
 */

const SMTP_HOST      = 'mail.pirariesgos.com';
const SMTP_PUERTO    = 465;                     // 465 (SSL) · 587 (TLS)
const SMTP_SEGURIDAD = 'ssl';                   // 'ssl' | 'tls'
const SMTP_USUARIO   = 'contactenos@pirariesgos.com';
const SMTP_CLAVE     = '';                      // <<< PON AQUÍ la clave del buzón, SOLO en config.local.php

// A dónde llega el mensaje del formulario del catálogo.
const CATALOGO_DESTINATARIO = 'contactenos@pirariesgos.com';
