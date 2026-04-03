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
    Eres un Maestro Luthier experto de la tienda 'Luthier Forge'. 
    Compara estas dos guitarras personalizadas para un cliente:

    GUITARRA A:
    - Cuerpo: {g1['cuerpo']}
    - Mástil: {g1['mastil']}
    - Pastillas: {g1['pastillas']}
    - Precio: {g1['precio']}

    GUITARRA B:
    - Cuerpo: {g2['cuerpo']}
    - Mástil: {g2['mastil']}
    - Pastillas: {g2['pastillas']}
    - Precio: {g2['precio']}

    Instrucciones:
    1. Analiza cómo influyen las maderas (Cuerpo/Mástil) en el tono.
    2. Explica la diferencia sonora de las pastillas.
    3. Compara las guitarras entre si enfrentando sus características.
    4. Termina con una conclusión recomendando cuál guitarra sería mejor para un cliente que busca un tono cálido y versátil, sin importar el precio.
    
    Instrucciones para el agente:
    - Se breve y directo, no te alargues en los distintos apartados.
    - No mas de dos lineas por apartado de guitarra.
    - Separa los apartados con un enter doble.
    - SOLO usa texto plano, no uses formato markdown ni emojis ni nada, solo texto. No uses negritas ni cursivas ni nada, solo texto plano.
    - La introduccion y la despedida es constante: 
    Introduccion: Buenas, soy el Maestro Luthier de Luthier Forge, y aquí tienes mi análisis. 
    Despedida: Espero que esta información te sea útil para elegir la guitarra perfecta para ti.
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