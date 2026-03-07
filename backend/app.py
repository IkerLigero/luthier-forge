import flet
from flet import Page, TextField, ElevatedButton, Column, Text, Dropdown, dropdown
from groq import Groq
from dotenv import load_dotenv
import os

load_dotenv()

client = Groq(api_key=os.getenv("GROQ_API_KEY"))

def get_ai_response(message):
    try:
        completion = client.chat.completions.create(
            model="llama-3.1-8b-instant",
            messages=[{"role": "user", "content": message}],
        )
        return completion.choices[0].message.content
    except Exception as e:
        return f"Error en Groq: {str(e)}"

def main(page: Page):
    page.title = "ChatBot de Luthier Forge"
    page.bgcolor = "white" 
    page.theme_mode = "light"
    
    input_box = TextField(
        label="Escribe tu mensaje aquí...",
        focused_border_color="blue",
        expand=True
    )
    
    mode_dropdown = Dropdown(
        options=[dropdown.Option("chat", "Chat con IA")],
        value="chat",
        label="Modo",
        border_color="blue200",
        color="black"
    )
    
    chat_area = Column(scroll="auto", expand=True)
    
    def send_message(e):
        user_message = input_box.value.strip()
        if not user_message:
            return
        
        chat_area.controls.append(Text(f"Usuario: {user_message}", color="black"))
        page.update()
        
        response = ""
        if mode_dropdown.value == "chat":
            response = get_ai_response(user_message)
        
        chat_area.controls.append(Text(f"Chatbot: {response}", color="blue"))
        input_box.value = ""
        page.update()
    
    send_button = ElevatedButton(content=Text("Enviar"), on_click=send_message)
    
    page.add(mode_dropdown, chat_area, input_box, send_button)


if __name__ == "__main__":
    flet.app(target=main, view=flet.AppView.WEB_BROWSER, port=8550)