from flask import Flask, request, jsonify
from flask_cors import CORS
from groq import Groq
import os
from dotenv import load_dotenv

# Cargamos el .env que está en la carpeta backend según tu indicación
load_dotenv('./.env') 


app = Flask(__name__)
CORS(app) # Permite que el navegador haga peticiones desde PHP a Python

client = Groq(api_key=os.getenv("GROQ_API_KEY"))

@app.route('/comparar', methods=['POST'])
def comparar_guitarras():
    data = request.json
    g1 = data['g1']
    g2 = data['g2']

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
    - Se brevé y directo, no te alargues en los distintos apartados.
    - No mas de dos lineas por apartado de guitarra.
    - Separa los apartados con un enter. e. g. "1. Análisis de maderas: ... \n\n 2. Diferencia de pastillas: ... \n\n 3. Comparación: ... \n\n 4. Conclusión: ..."
    - SOLO usa texto plano, no sues formato markdown ni emojis ni nada, solo texto. No uses negritas ni cursivas ni nada, solo texto plano.
    - La introduccion y la despedida es constante: Introduccion: Buenas, soy el Maestro Luthier de Luthier Forge, y aquí tienes mi análisis. Despedida: Espero que esta información te sea útil para elegir la guitarra perfecta para ti.
    """

    try:
        completion = client.chat.completions.create(
            model="llama-3.1-8b-instant",
            messages=[{"role": "user", "content": prompt}],
        )
        return jsonify({"analisis": completion.choices[0].message.content})
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    # Ejecuta en el puerto 5000
    app.run(host="0.0.0.0", port=5000, debug=True)