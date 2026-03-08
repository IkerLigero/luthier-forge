import flet
from flet import Page, TextField, ElevatedButton, Column, Text, Dropdown, dropdown
from groq import Groq
from dotenv import load_dotenv
import os

load_dotenv()

# Definir el cliente de Groq con la clave API
client = Groq(api_key=os.getenv("GROQ_API_KEY"))

# Función para obtener la respuesta de la IA usando Groq
def get_ai_response(message):
    try:
        completion = client.chat.completions.create(
            model="llama-3.1-8b-instant",
            messages=[{"role": "user", "content": message}],
        )
        return completion.choices[0].message.content # Devuelve solo el contenido del mensaje de respuesta
    except Exception as e:
        return f"Error en Groq: {str(e)}"

# Función principal de la aplicación Flet
def main(page: Page):
    
    # Configuración básica de la página
    page.title = "ChatBot de Luthier Forge"
    page.bgcolor = "white" 
    page.theme_mode = "light"
    
    # Crear los controles de la interfaz
    input_box = TextField(
        label="Escribe tu mensaje aquí...",
        focused_border_color="blue",
        expand=True
    )
    
    # Dropdown para seleccionar el modo de interacción
    mode_dropdown = Dropdown(
        options=[dropdown.Option("chat", "Chat con IA")],
        value="chat",
        label="Modo",
        border_color="blue200",
        color="black"
    )
    
    # Área de chat para mostrar mensajes
    chat_area = Column(scroll="auto", expand=True)
    
    # Función para manejar el envío de mensajes
    def send_message(e):
        # Obtener el mensaje del usuario
        user_message = input_box.value.strip()
        if not user_message:
            return
        
        # Agregar el mensaje del usuario al área de chat
        chat_area.controls.append(Text(f"Usuario: {user_message}", color="black"))
        page.update()
        
        # Obtener la respuesta de la IA según el modo seleccionado
        response = ""
        if mode_dropdown.value == "chat":
            response = get_ai_response(user_message)
        
        # Agregar la respuesta de la IA al área de chat
        chat_area.controls.append(Text(f"Chatbot: {response}", color="blue"))
        input_box.value = ""
        page.update()
    
    # Botón para enviar el mensaje
    send_button = ElevatedButton(content=Text("Enviar"), on_click=send_message)
    
    # Agregar los controles a la página
    page.add(mode_dropdown, chat_area, input_box, send_button)


# Ejecutar la aplicación Flet
if __name__ == "__main__":
    flet.app(target=main, view=flet.AppView.WEB_BROWSER, port=8550)