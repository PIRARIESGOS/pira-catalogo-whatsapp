"""
Genera el codigo QR final del mini-sitio, una vez que exista el link publico
(por ejemplo, despues de publicarlo en Netlify o GitHub Pages).

Uso:
    python generate_qr.py https://tu-link-publico.netlify.app

Genera: qr.png (1000x1000, con el isotipo de PIRA en el centro).
"""
import sys

import qrcode
from PIL import Image
from qrcode.constants import ERROR_CORRECT_H

def generar(url: str, salida: str = "qr.png") -> None:
    qr = qrcode.QRCode(error_correction=ERROR_CORRECT_H, box_size=20, border=3)
    qr.add_data(url)
    qr.make(fit=True)
    img = qr.make_image(fill_color="#201A3E", back_color="white").convert("RGB")

    try:
        logo = Image.open("assets/logos/isotipo.png").convert("RGBA")
        target = int(img.size[0] * 0.22)
        logo.thumbnail((target, target), Image.LANCZOS)
        pos = ((img.size[0] - logo.size[0]) // 2, (img.size[1] - logo.size[1]) // 2)
        fondo_logo = Image.new("RGBA", logo.size, "white")
        img.paste(fondo_logo, pos)
        img.paste(logo, pos, logo)
    except FileNotFoundError:
        pass

    img.save(salida)
    print(f"QR generado en {salida} para: {url}")


if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("Uso: python generate_qr.py https://tu-link-publico.com")
        sys.exit(1)
    generar(sys.argv[1])
