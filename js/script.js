// PIRA RIESGOS — mini-sitio catálogo WhatsApp
// Sin dependencias externas, sin cookies, sin scripts de terceros.
// (Sin animaciones de aparición: se prefiere que todo el contenido sea
// visible de inmediato, sin depender de JavaScript para mostrarse.)

// Formulario de Contáctenos: intenta enviar de verdad vía enviar.php (cuando
// este sitio corre en un hosting con PHP, como pirariesgos.com/catalogo/).
// Si enviar.php no existe o falla (por ejemplo, la copia estática publicada
// en GitHub Pages, que no tiene backend), cae de vuelta a abrir el correo
// del visitante con el mensaje ya redactado, como respaldo.
(function () {
  var form = document.getElementById('form-contacto');
  var resultado = document.getElementById('contacto-resultado');
  if (!form) return;

  function escaparHtml(texto) {
    return String(texto)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function mostrarResultado(tipo, html) {
    if (!resultado) return;
    resultado.hidden = false;
    resultado.className = 'contact-form__result contact-form__result--' + tipo;
    resultado.innerHTML = html;
  }

  function enviarPorMailto(data) {
    var empresa = (data.get('empresa') || '').trim();
    var nombre = (data.get('nombre') || '').trim();
    var lineas = [
      'Nombre: ' + nombre,
      'Empresa: ' + (empresa || '-'),
      'Correo corporativo: ' + (data.get('correo') || '').trim(),
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
  }

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

    var boton = form.querySelector('button[type="submit"]');
    if (boton) { boton.disabled = true; boton.textContent = 'Enviando…'; }

    fetch('enviar.php', { method: 'POST', body: data })
      .then(function (res) {
        if (!res.ok) throw new Error('sin-backend');
        return res.json();
      })
      .then(function (json) {
        if (json && json.ok) {
          form.reset();
          form.style.display = 'none';
          mostrarResultado(
            'exito',
            '<strong>¡Listo! Recibimos su mensaje.</strong> Le responderemos pronto a ' +
              '<strong>' + escaparHtml(correo) + '</strong>.' +
              '<br><a class="btn btn--outline btn--small" style="margin-top:12px;" ' +
              'href="https://pirariesgos.com/">Ir a pirariesgos.com</a>'
          );
        } else {
          mostrarResultado(
            'error',
            (json && json.mensaje ? json.mensaje : 'No se pudo enviar.') +
              ' Escríbanos directo por <a href="https://wa.me/573133746523">WhatsApp</a> o a ' +
              '<a href="mailto:contactenos@pirariesgos.com">contactenos@pirariesgos.com</a>.'
          );
        }
      })
      .catch(function () {
        // Sin backend disponible (por ejemplo, la copia estática en GitHub
        // Pages) — respaldo: abrir el correo del visitante ya redactado.
        enviarPorMailto(data);
      })
      .finally(function () {
        if (boton) { boton.disabled = false; boton.textContent = 'Solicitar asesoría'; }
      });
  });
})();
