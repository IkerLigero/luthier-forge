from flask import Flask, request, jsonify
from flask_cors import CORS
from groq import Groq
import os
from dotenv import load_dotenv

# Cargar desde la ruta backend
load_dotenv('./.env') 

app = Flask(__name__)
# Configuración robusta de CORS para evitar bloqueos en el navegador
CORS(app, resources={r"/*": {"origins": "*"}})

client = Groq(api_key=os.getenv("GROQ_API_KEY"))

@app.route('/comparar', methods=['POST'])
def comparar_guitarras():
    data = request.json
    g1 = data.get('g1')
    g2 = data.get('g2')

    if not g1 or not g2:
        return jsonify({"error": "Faltan datos"}), 400

    prompt = f"""
        [ROL]
        Eres un Maestro Luthier experto de la tienda 'Luthier Forge'. Tu lenguaje es profesional, artesanal y directo.

        [CONTEXTO Y DATOS]
        Compara estas dos guitarras personalizadas para un cliente:

        GUITARRA A:
        - Cuerpo: {g1['cuerpo']}
        - Mastil: {g1['mastil']}
        - Pastillas: {g1['pastillas']}
        - Precio: {g1['precio']}

        GUITARRA B:
        - Cuerpo: {g2['cuerpo']}
        - Mastil: {g2['mastil']}
        - Pastillas: {g2['pastillas']}
        - Precio: {g2['precio']}

        [INSTRUCCIONES DE CONTENIDO]
        Genera un analisis estructurado exactamente en los siguientes 4 bloques:
        1. TONO DE LAS MADERAS: Analiza como influyen las maderas del cuerpo y mastil en el sonido de cada opcion.
        2. PASTILLAS: Explica la diferencia sonora y dinamica entre las pastillas de la Guitarra A y la B.
        3. COMPARATIVA DIRECTA: Enfrenta las caracteristicas de ambas guitarras para mostrar sus contrastes.
        4. CONCLUSION: Recomienda cual es mejor para un cliente que busca un tono calido y versatil, ignorando el precio.

        [RESTRICCIONES ESTRICTAS DE FORMATO Y ESTILO]
        - INTRODUCCION OBLIGATORIA (Primera linea): Buenas, soy el Maestro Luthier de Luthier Forge, y aqui tienes mi analisis.
        - DESPEDIDA OBLIGATORIA (Ultima linea): Espero que esta informacion te sea util para elegir la guitarra perfecta para ti.
        - CERO MARKDOWN: Prohibido usar asteriscos (*), almohadillas (#), guiones de lista (-), o cualquier formato. Todo el output debe ser TEXTO PLANO.
        - LONGITUD: Se extremadamente breve. Cada uno de los 4 bloques de analisis debe tener un maximo de 2 lineas de texto.
        - ESPACIADO: Separa la introduccion, cada uno de los 4 bloques, y la despedida con un ENTER DOBLE (un salto de linea en blanco entre cada seccion).
    """

    try:
        completion = client.chat.completions.create(
            model="llama-3.1-8b-instant",
            messages=[{"role": "user", "content": prompt}],
        )
        return jsonify({"analisis": completion.choices[0].message.content})
    except Exception as e:
        print(f"Error detectado: {e}")
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    # Importante: Mantener esta línea al margen izquierdo total
    app.run(host="0.0.0.0", port=5000, debug=True)