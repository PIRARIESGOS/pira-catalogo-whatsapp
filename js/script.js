// PIRA RIESGOS — mini-sitio catálogo WhatsApp
// Sin dependencias externas, sin cookies, sin scripts de terceros.
// (Sin animaciones de aparición: se prefiere que todo el contenido sea
// visible de inmediato, sin depender de JavaScript para mostrarse.)

// Formulario de Contáctenos: este sitio es estático (GitHub Pages, sin
// backend propio), así que el envío se resuelve abriendo el cliente de
// correo del visitante con el mensaje ya redactado hacia PIRA RIESGOS.
(function () {
  var form = document.getElementById('form-contacto');
  if (!form) return;

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    var data = new FormData(form);

    // Honeypot anti-spam: si un bot llenó este campo oculto, no hacer nada.
    if (data.get('empresa_web')) return;

    var nombre = (data.get('nombre') || '').trim();
    var correo = (data.get('correo') || '').trim();
    if (!nombre || !correo) {
      form.reportValidity();
      return;
    }

    var empresa = (data.get('empresa') || '').trim();
    var lineas = [
      'Nombre: ' + nombre,
      'Empresa: ' + (empresa || '-'),
      'Correo corporativo: ' + correo,
      'Teléfono / WhatsApp: ' + ((data.get('telefono') || '').trim() || '-'),
      'Cargo: ' + ((data.get('cargo') || '').trim() || '-'),
      '¿Qué necesita?: ' + ((data.get('necesidad') || '').trim() || '-'),
      '',
      'Mensaje:',
      (data.get('mensaje') || '').trim() || '-'
    ];

    var asunto = 'Solicitud de asesoría — ' + nombre + (empresa ? ' (' + empresa + ')' : '');
    var mailto = 'mailto:contactenos@pirariesgos.com'
      + '?subject=' + encodeURIComponent(asunto)
      + '&body=' + encodeURIComponent(lineas.join('\n'));

    window.location.href = mailto;
  });
})();
