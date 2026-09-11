# Mini-sitio catálogo WhatsApp — PIRA RIESGOS

Página de una sola pantalla (landing) pensada para pegarse como artículo dentro del
**Catálogo de WhatsApp Business** de PIRA RIESGOS. No necesita servidor con backend:
son solo archivos estáticos (HTML + CSS + JS + imágenes).

## Qué hay en esta carpeta

```
WHAPP/
├── index.html              ← la página completa
├── css/styles.css
├── js/script.js
├── assets/
│   ├── logos/               isotipo y favicons (tomados de 01_IMAGEN_INSTITUCIONAL)
│   ├── screenshots/         4 capturas reales de la plataforma pira-platform (sin datos
│   │                        personales — ver nota de seguridad abajo)
│   └── og-image.png         imagen que se ve en la tarjeta de vista previa al compartir el link
├── generate_qr.py           script para generar el QR final (una vez exista el link público)
└── README.md                este archivo
```

## Cómo verla en su computador antes de publicar

1. Doble clic en `index.html` (se abre en el navegador), o
2. Si tiene Python instalado, abra una terminal en esta carpeta y ejecute:
   ```
   python -m http.server 8000
   ```
   y luego entre a `http://localhost:8000` en el navegador.

## Cómo obtener el link público (elegir una opción)

### Opción A — Netlify Drop (la más simple, sin instalar nada)
1. Entre a **https://app.netlify.com/drop** desde el navegador.
2. Arrastre la carpeta `WHAPP` completa a esa página.
3. En segundos le entrega un link público (ej. `https://algo-al-azar.netlify.app`).
4. Cree una cuenta gratuita en Netlify (con el correo `contactenos@pirariesgos.com`) para que
   ese link no se borre y pueda ponerle un nombre más corto (ej. `pira-riesgos.netlify.app`)
   desde "Site settings → Change site name".

### Opción B — GitHub Pages (si ya tiene o quiere una cuenta de GitHub)
1. Cree un repositorio nuevo (puede llamarse `pira-catalogo`).
2. Suba el contenido de esta carpeta `WHAPP` a ese repositorio.
3. En el repositorio: **Settings → Pages → Deploy from branch → main → /(root)**.
4. GitHub le entrega un link tipo `https://usuario.github.io/pira-catalogo/`.

## Después de publicar (paso obligatorio, no opcional)

Una vez tenga el link público definitivo:

1. Abra `index.html` y reemplace las dos líneas marcadas con
   `REEMPLAZAR-CON-TU-LINK-PUBLICO` (busque ese texto) por su link real. Esto controla la
   tarjeta de vista previa que aparece cuando alguien recibe el link por WhatsApp — si no se
   reemplaza, la vista previa sale rota o sin imagen.
2. Vuelva a publicar (arrastre otra vez la carpeta en Netlify, o suba el cambio a GitHub).
3. Genere el código QR final con el script incluido:
   ```
   pip install qrcode pillow      (solo la primera vez)
   python generate_qr.py https://su-link-publico.com
   ```
   Esto crea `qr.png` en esta misma carpeta, con el isotipo de PIRA en el centro.

## Cómo ponerlo en el Catálogo de WhatsApp Business

1. Abra **WhatsApp Business** → **Herramientas de empresa** → **Catálogo**.
2. Agregue un artículo nuevo (puede usar la imagen `assets/og-image.png` como foto del artículo).
3. En el campo de enlace/sitio web, pegue el link público del paso anterior.
4. Guarde. Ese artículo es el que sus clientes verán y podrán abrir desde el chat.
5. El código QR (`qr.png`) puede imprimirse o ponerse en tarjetas de presentación, apunta al
   mismo link.

## Nota de seguridad importante (leída durante la construcción del sitio)

Al revisar las capturas disponibles en el wiki de `pira-platform` para usarlas como "prueba
real", varias imágenes (las de la pestaña Revisión, el modal de coincidencia y el historial)
mostraban **nombres y números de cédula reales** de personas consultadas contra las listas
restrictivas. Esas capturas **no se usaron** en el sitio público por tratarse de datos
personales sensibles. Las 4 capturas que sí se usaron (`assets/screenshots/`) muestran solo
paneles, contadores agregados y pantallas de configuración, sin ningún dato de una persona
específica. Si en el futuro se quieren usar capturas más "de acción" (con una búsqueda real),
hay que producirlas primero con datos de prueba ficticios, nunca con datos reales de clientes.

Tampoco se expone ninguna API key real: el ejemplo de integración usa un host de ejemplo
(`TU-DOMINIO-PIRA`) y una llave enmascarada, tal como documenta el propio endpoint
`/api/v1/external/listas/documentacion` del backend.

## Reporte de pruebas realizadas

- **Ortografía y gramática:** se releyó todo el texto renderizado (tildes, ¿¡, mayúsculas);
  sin errores encontrados.
- **Responsive:** se probó con Chromium headless (Playwright) en 360 px (móvil), 768 px
  (tablet) y 1440 px (escritorio), con capturas de pantalla completas revisadas sección por
  sección. Se encontró y corrigió un error real antes de la entrega: un efecto de aparición
  al hacer scroll dejaba las tarjetas invisibles; se eliminó por completo. También se corrigió
  el bloque de código de la sección de API, que se desbordaba horizontalmente en pantallas
  angostas — ahora hace salto de línea.
- **Enlaces:** los 4 botones de WhatsApp (encabezado, hero, CTA final y botón flotante) abren
  el mismo número con el mismo mensaje prellenado. Enlaces de correo y de sitio web
  verificados.
- **Consola/red:** sin errores de JavaScript ni de carga de recursos (fuentes, imágenes, CSS)
  en la prueba automatizada.
- **Contraste y jerarquía visual:** magenta reservado solo para botones/CTA, azul y verde para
  títulos y acentos, fondo institucional oscuro en hero/CTA, tal como exige el manual de marca.

Pendiente de validar por el cliente una vez esté publicado: abrir el link real desde un celular
dentro de WhatsApp (el navegador interno de WhatsApp a veces se comporta distinto a Chrome) y
confirmar que la vista previa del link se ve bien después de completar el paso "Después de
publicar" de este README.
