# 🎸 Luthier Forge 

[![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/HTML) [![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](https://developer.mozilla.org/en-US/docs/Web/CSS) [![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/en-US/docs/Web/JavaScript) [![jQuery](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)](https://jquery.com) [![Three.js](https://img.shields.io/badge/Three.js-000000?style=for-the-badge&logo=threedotjs&logoColor=white)](https://threejs.org/docs/) [![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://dev.mysql.com/doc/) [![Blender](https://img.shields.io/badge/Blender-F5792A?style=for-the-badge&logo=blender&logoColor=white)](https://docs.blender.org) [![Python](https://img.shields.io/badge/Python-3776AB?style=for-the-badge&logo=python&logoColor=white)](https://docs.python.org/3/)

**Luthier Forge** es una plataforma interactiva diseñada para músicos y entusiastas que buscan la perfección. Personaliza, visualiza y compara cada componente de tu instrumento con precisión técnica. Construir la guitarra de tus sueños nunca fue tan sencillo ni tan intuitivo.
&nbsp;



## 🏗️ Tecnologías utilizadas.
1. **THREE.js:** Es el encargado de renderizar y gestionar el entorno 3D en el navegador. Permite la visualización en tiempo real de los modelos de las guitarras, permitiendo al usuario rotar, hacer zoom y apreciar las texturas de los materiales.  
&nbsp;
2. **Python (Flask/FastAPI):** Actúa como el motor de inteligencia artificial del proyecto. Utiliza el **modelo Llama-3.1-8b** para actuar como un Maestro Luthier virtual. Procesa las especificaciones técnicas de las guitarras configuradas por el usuario y genera un análisis experto en tiempo real sobre el tono, la compatibilidad de maderas y la electrónica.
&nbsp;

3. **MySQL:** La base de datos donde se almacenan las especificaciones técnicas, compatibilidades entre piezas y el inventario de componentes disponibles en la forja. En nuestro caso almacena rutas a los diferentes elemtos fisicos (glbs).
&nbsp;

4. **jQuery:** Utilizado para la manipulación ágil del DOM y la gestión de eventos de la interfaz de usuario de forma sencilla y eficiente.
&nbsp;

5. **Blender:** Utilizado para el modelado 3D de alta precisión de los cuerpos, mástiles y hardware de las guitarras. Cada pieza ha sido exportada en formato .GLB para mantener un equilibrio entre calidad visual y rendimiento web.
&nbsp;



## ⭐ Características principales.  
- **Visualizador 3D Interactivo:** Gracias a Three.js, los usuarios pueden navegar por los diferentes componentes de las guitarras.
&nbsp;
- **Comparador experto con IA:** Integración con el modelo Llama 3.1 (Groq) para ofrecer un análisis acústico y técnico en tiempo real.
&nbsp;
- **Personalización Modular:** Sistema que permite intercambiar piezas (cuerpo, mástil, pastillas) de forma dinámica, reflejando los cambios visuales y técnicos de manera instantánea.
&nbsp;



## 📦 Instalación de dependencias.

#### 🐍 Python:

1. Entra en la carpeta del backend:
```bash
   cd backend
```

2. Instala las dependencias:
```bash
   pip install -r requirements.txt
```

3. Crea un archivo `.env` con tu API key de Groq:
```
GROQ_API_KEY=xxx
```

#### 🗄️ Base de datos:
Para poder usar la aplicación debes primero tener la base de datos funcionando.

1. Crear la base de datos en **phpMyAdmin**: Debes crar una base llamada **luthier_forge** .
2. Importar la base de datos proporcionada en la carpeta raiz del proyecto.
&nbsp;


## 🚀 Puesta en marcha:
1. Situar el proyecto en la carpeta htdocs de xampp.
2. Arrancar el servicio **Apache y MySQL**.
3. Asegurarse de tener el CORS habilitado.
4. Ejecutar el comando `python ia_comparador.py` para arrancar el agente comparador.

