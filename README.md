# Mini-sitio catálogo WhatsApp — PIRA RIESGOS

## 🔗 Link público (ya publicado)

**https://pirariesgos.github.io/pira-catalogo-whatsapp/**

Repositorio: https://github.com/PIRARIESGOS/pira-catalogo-whatsapp (público, GitHub Pages
activado, sirve directamente la carpeta `WHAPP`). El QR final está en `qr.png` — apunta a ese
mismo link.

Página de una sola pantalla (landing) pensada para pegarse como artículo dentro del
**Catálogo de WhatsApp Business** de PIRA RIESGOS. No necesita servidor con backend: son solo
archivos estáticos (HTML + CSS + JS + imágenes).

## Qué hay en esta carpeta

```
WHAPP/
├── index.html              ← la página completa
├── css/styles.css
├── js/script.js
├── assets/
│   ├── logos/               isotipo y favicons (tomados de 01_IMAGEN_INSTITUCIONAL)
│   ├── screenshots/         8 capturas reales de pira-platform, sin datos personales
│   │                        (ver nota de seguridad abajo)
│   └── og-image.png         imagen que se ve en la tarjeta de vista previa al compartir el link
├── qr.png                   código QR que apunta al link público
├── generate_qr.py           script para regenerar el QR si el link cambia
└── README.md                este archivo
```

## Contenido de la página (v3 — recorrido completo + documentación de alertas + IA + contacto)

1. **Hero** — gancho + 4 insignias (Consultoría legal · Tecnología con IA · LMS de
   capacitación · Oficial de cumplimiento externo) + CTA WhatsApp.
2. **El costo de no actuar** — multas, responsabilidad personal, contratos perdidos,
   vinculaciones a ciegas.
3. **La diferencia PIRA** — los 4 pilares + comparativo explícito "consultoría tradicional vs.
   PIRA RIESGOS".
4. **La plataforma en acción** — capturas reales agrupadas por tema:
   - Gestión de riesgos (matrices GTC-45, SAGRILAFT/ISO 31000/COSO ERM, heatmap LA/FT
     probabilidad×impacto, factores y controles con % de cobertura).
   - Cumplimiento LA/FT (listas restrictivas, fuentes oficiales, automatización con la API de
     OFAC).
   - **Documentación de alertas de principio a fin** (nuevo): un reporte real de resultado de
     búsqueda en listas (con nombre y cédula difuminados), la pantalla de revisión de
     cumplimiento, el formulario de decisión con justificación obligatoria, y el historial
     exportable con contadores.
   - PTEE y ética empresarial (Red de Confianza: operaciones inusuales, ROS-UIAF, regalos y
     atenciones —con formulario real de registro—, conflictos de interés).
   - SG-SST (Decreto 1072/2015).
   - **Automatización y analítica con IA** (nuevo): segmentación de clientes con clustering
     K-means y el correo automático de resumen mensual de consultas.
5. **Capacitación (LMS)** — captura real del curso "SAGRILAFT y PTEE" (config, nota mínima,
   intentos, vigencia), una actividad de microaprendizaje, y el correo automático de
   certificado (nombre difuminado).
6. **Tercerización** — servicio de oficial de cumplimiento externo.
7. **Ejemplo de integración de API** — para el equipo técnico del cliente potencial.
8. **Contáctenos** — accesos rápidos (WhatsApp, pirariesgos.com, correo) + un formulario propio
   con los mismos campos del formulario de pirariesgos.com (Nombre, Empresa, Correo
   corporativo, Teléfono/WhatsApp, Cargo, ¿Qué necesita?, Mensaje, honeypot anti-spam). Como
   este sitio no tiene backend propio, el envío se resuelve abriendo el cliente de correo del
   visitante con el mensaje ya redactado hacia `contactenos@pirariesgos.com` (ver
   `js/script.js`).
9. **CTA final** con WhatsApp, correo y web.

### Formato de imagen (v3)

Todas las capturas (`assets/screenshots/`) y el isotipo inline (`assets/logos/isotipo.webp`) se
convirtieron a **WebP** para bajar el peso de la página (~45-55% más liviano que los PNG
originales, navegación más fluida). Los favicons y `assets/og-image.png` se dejaron en **PNG a
propósito**: son los formatos que garantizan compatibilidad con la tarjeta de vista previa al
compartir el link (WhatsApp, redes) y con `apple-touch-icon`.

### Nueva evidencia y redacción de datos personales (v3)

Se agregaron 11 capturas/documentos nuevos (`prueba-09` a `prueba-19`), incluido un reporte real
de búsqueda en listas (PDF → imagen) y dos capturas del módulo de revisión de cumplimiento que
contenían el nombre y número de cédula reales de una persona. En los tres casos donde aparecía
un dato personal identificable se **pixeló** esa región exacta (nombre completo y/o número de
documento) antes de publicar — en el caso del PDF, las coordenadas se ubicaron con precisión
usando la capa de texto del propio PDF (PyMuPDF `search_for`), no a ojo. El resto del contenido
(montos, nombres de empresas/NIT, metodología, resultados) se dejó intacto porque no identifica
a una persona natural. Mismo criterio de seguridad que se documenta más abajo para la v1.

## Cómo verla en su computador

Doble clic en `index.html`, o entre directamente al link público de arriba.

## Cómo se publicó (ya hecho, referencia para el futuro)

Se creó el repositorio público `PIRARIESGOS/pira-catalogo-whatsapp` en GitHub y se activó
**GitHub Pages** (Settings → Pages → Deploy from branch → `main` → `/root`). Cualquier cambio
que se suba a la rama `main` se publica solo, en uno o dos minutos, en el mismo link.

Para actualizar el sitio en el futuro (con Claude Code o manualmente):
```
cd WHAPP
git add -A
git commit -m "mensaje del cambio"
git push origin main
```

Si algún día se quiere mover a otro proveedor (Netlify, Vercel, dominio propio
`catalogo.pirariesgos.com`, etc.), los pasos son los mismos: subir esta carpeta y apuntar el
dominio. Recordar entonces actualizar las dos líneas `og:image` / `og:url` en `index.html` con
el nuevo link (controlan la vista previa que se ve al compartirlo).

## Cómo ponerlo en el Catálogo de WhatsApp Business

1. Abra **WhatsApp Business** → **Herramientas de empresa** → **Catálogo**.
2. Agregue un artículo nuevo (puede usar `assets/og-image.png` como foto del artículo).
3. En el campo de enlace/sitio web, pegue: `https://pirariesgos.github.io/pira-catalogo-whatsapp/`
4. Guarde. Ese artículo es el que sus clientes verán y podrán abrir desde el chat.
5. El código QR (`qr.png`) puede imprimirse o ponerse en tarjetas de presentación.

## Formulario de Contáctenos: cómo queda configurado en un servidor con PHP

`enviar.php` envía el formulario por **SMTP real con PHPMailer** (vendored en `libs/PHPMailer/`,
sin Composer), usando el mismo buzón/servidor que ya usa `contacto.php` en pirariesgos.com. En
la copia estática de GitHub Pages este archivo no se ejecuta — `js/script.js` detecta que la
petición falla y cae de vuelta a abrir el correo del visitante (`mailto:`) como respaldo.

**Para que funcione en un hosting real (por ejemplo `pirariesgos.com/catalogo/`):**

1. Suba también las carpetas/archivos `libs/PHPMailer/`, `config.example.php` y `enviar.php`.
2. En el servidor (nunca en Git), copie `config.example.php` como `config.local.php` en la misma
   carpeta y complete ahí `SMTP_CLAVE` con la clave real del buzón — edítelo directo por
   FTP/cPanel, nunca pegue esa clave en un chat ni la suba al repositorio. `config.local.php` ya
   está en `.gitignore`.
3. Si el host/usuario/puerto de correo cambia, ajústelo también en `config.local.php`
   (`SMTP_HOST`, `SMTP_PUERTO`, `SMTP_SEGURIDAD`, `SMTP_USUARIO`).
4. Pruebe el formulario en vivo una vez subido — sin `config.local.php` (o con `SMTP_CLAVE`
   vacía) responde con un error controlado y el sitio cae al respaldo `mailto:`, no se rompe.

## Nota de seguridad importante (leída durante la construcción del sitio)

Al revisar las capturas disponibles en el wiki de `pira-platform` para usarlas como "prueba
real", varias imágenes (listas de Revisión, el modal de coincidencia, el historial, y todas las
del módulo "Red de Confianza" — RIOI, ROS, Regalos y Atenciones, Conflictos de Interés,
Campañas) mostraban **nombres y números de cédula reales de personas**, o directamente una
**pantalla de error** ("Algo salió mal") por un problema del propio módulo en ese momento.
Ninguna de esas se usó en el sitio público. Para cubrir el tema PTEE/Red de Confianza sin
exponer datos personales ni mostrar un error, se usó solo el **menú de navegación** (recortado,
sin el panel de contenido) como evidencia de que esos módulos existen en la plataforma real.
Las 8 capturas finales (`assets/screenshots/`) muestran solo paneles, contadores agregados,
menús y pantallas de configuración — ningún dato de una persona específica.

Tampoco se expone ninguna API key real: el ejemplo de integración usa un host de ejemplo
(`TU-DOMINIO-PIRA`) y una llave enmascarada, tal como documenta el propio endpoint
`/api/v1/external/listas/documentacion` del backend.

`PIRA_CONTA` (la otra fuente sugerida) se revisó y **no tiene** pantallas de integración de
listas/alertas — es un software contable aparte, sin ese módulo. No se usó contenido de ahí.

## Reporte de pruebas realizadas (sobre la URL pública ya publicada)

- **Ortografía y gramática:** se releyó todo el texto renderizado de la página en vivo
  (tildes, ¿¡, mayúsculas); sin errores encontrados, incluida toda la ampliación de contenido
  de la v2.
- **Responsive:** se probó con Chromium headless (Playwright) directamente sobre
  `https://pirariesgos.github.io/pira-catalogo-whatsapp/` en 360 px (móvil), 768 px (tablet) y
  1440 px (escritorio), con capturas de página completa revisadas sección por sección.
- **Errores corregidos antes de la entrega:**
  1. Un efecto de aparición al hacer scroll dejaba las tarjetas invisibles — se eliminó.
  2. El bloque de código de la API se desbordaba horizontalmente en móvil — ahora hace salto
     de línea.
  3. Las imágenes de "prueba real" no se renderizaban en la captura completa por el atributo
     `loading="lazy"` — se quitó de las 8 imágenes para garantizar que carguen siempre.
- **Enlaces:** los 4 botones de WhatsApp (encabezado, hero, CTA final y botón flotante) abren
  el mismo número con el mismo mensaje prellenado, verificado sobre la URL en vivo. Enlaces de
  correo y sitio web verificados.
- **Consola/red:** sin errores de JavaScript ni de carga de recursos (fuentes, imágenes, CSS)
  en la página publicada.
- **Contraste y jerarquía visual:** magenta reservado solo para botones/CTA, azul y verde para
  títulos y acentos, fondo institucional oscuro en hero/CTA/impacto, tal como exige el manual
  de marca.
- **QR:** generado con `generate_qr.py` apuntando al link público real, con corrección de
  errores alta (se probó visualmente que el isotipo central no rompe la lectura).

Pendiente de validar por el cliente: abrir el link desde el navegador interno de WhatsApp en un
celular real (a veces se comporta distinto a Chrome) y confirmar que la tarjeta de vista previa
se ve bien al pegar el link en un chat.

## De este catálogo a una cotización (proceso aparte, no publicado)

El contenido de este catálogo (servicios, diferenciadores, evidencia técnica) está pensado para
poder convertirse en una propuesta comercial/cotización real, con el mismo formato de las
propuestas que PIRA ya ha presentado a clientes. Ese proceso **vive fuera de este repo público**,
en `D:\02A_TIC_GIT\REDES\02_COTIZACIONES\` (no se sube a GitHub porque incluye lenguaje comercial,
estructuras de precio internas y, cuando se usa con un cliente real, sus datos).

Método recomendado (v4): un **generador de PDF institucional** en
`02_COTIZACIONES/generador/` (Node + Playwright + PyMuPDF) que toma un archivo de datos por
cliente y produce la propuesta ya diagramada con la misma identidad visual de este catálogo
(colores, tipografías, logos, portada a sangre completa), con auto-selección de la norma
aplicable según el sector del cliente. Ver `02_COTIZACIONES/generador/README.md` para el uso y
el esquema de datos.

También queda, como referencia de contenido y cláusulas (método anterior, ya no el
recomendado), `02_COTIZACIONES/PLANTILLA_COTIZACION_PIRA.docx` +
`02_COTIZACIONES/00_PROCESO_cotizacion_desde_catalogo.md`.
