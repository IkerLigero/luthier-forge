import * as THREE from "three";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";

window.onload = inicio;

const pathArray = window.location.pathname.split('/');
const rootPath = pathArray.slice(0, pathArray.indexOf('frontend')).join('/') + '/';


// DEFINIMOS NOTYF PARA NOTIFICACIONES
let seleccionadas = [];
const notyf = new Notyf({
    duration: 4000,
    position: { x: 'right', y: 'bottom' },
    types: [
        { type: 'info', background: '#1a1a1a', icon: false }
    ]
});

function inicio() {
    const containers = document.querySelectorAll('.canvas-container');
    containers.forEach(container => {
        // Si el contenedor no tiene ancho, no intentamos renderizar
        if (container.clientWidth === 0) return;

        // DEFINIMOS ESCENA
        const scene = new THREE.Scene();
        scene.background = new THREE.Color(0xfcfcfc);

        // DEFINIMOS CAMARA
        let w = container.clientWidth;
        let h = container.clientHeight;
        const camera = new THREE.PerspectiveCamera(45, w / h, 0.1, 1000);
        camera.position.set(0, 8, 0.1);
        camera.lookAt(0, 0, -2.7);

        // DEFINIMOS RENDERER
        const renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(w, h);
        container.appendChild(renderer.domElement);


        // APARTADO DE LUCES
        const ambientLight = new THREE.AmbientLight(0xffffff, 1.8);
        const dirLight = new THREE.DirectionalLight(0xffffff, 1);
        dirLight.position.set(0, 10, 2);
        scene.add(ambientLight, dirLight);

        // CARGAMOS LOS MODELOS 3D
        const piezas = [
            container.getAttribute('data-forma'),     // Cuerpo
            container.getAttribute('data-mastil'),    // Mástil
            container.getAttribute('data-pastillas')  // Pastillas
        ];
        // Por cada ruta, si existe, cargamos el modelo y lo añadimos a la escena
        piezas.forEach(ruta => {
            if (ruta) {
                // DEFINIMOS Y USAMOS EL LOADER
                const loader = new GLTFLoader();
                loader.load(rootPath + ruta, (gltf) => { scene.add(gltf.scene); });
            }
        });

        // ANIMACIÓN
        function animate() {
            requestAnimationFrame(animate);
            renderer.render(scene, camera);
        }
        animate();
    });
}

// SELECCION DE GUITARRAS
window.seleccionarParaComparar = function (el) {
    // Si el usuario hace click en el botón de carrito, no seleccionamos la tarjeta
    if (event.target.classList.contains('btn-carrito')) return;

    // Si ya está seleccionada, la deseleccionamos
    if (seleccionadas.includes(el)) {
        el.style.border = "none";
        el.style.transform = "scale(1)";
        seleccionadas = seleccionadas.filter(item => item !== el);

        // Si no está seleccionada, la seleccionamos (máximo 2)
    } else {
        if (seleccionadas.length < 2) {
            el.style.border = "3px solid #8c2411";
            el.style.transform = "scale(1.02)";
            seleccionadas.push(el);
        }
        else {
            notyf.error("Solo puedes comparar 2 guitarras");
            return;
        }
    }

    // Actualizamos el botón de comparar según la cantidad seleccionada
    const btn = document.getElementById('btn-comparar-maestro');
    // Si hay 2 seleccionadas, habilitamos el botón
    if (seleccionadas.length === 2) {
        btn.innerText = "¡Consultar Maestro Luthier!";
        btn.style.backgroundColor = "#8c2411";
    }
    // Si no, lo deshabilitamos
    else {
        btn.innerText = `Selecciona 2 guitarras (${seleccionadas.length}/2)`;
        btn.style.backgroundColor = "#1a1a1a";
    }
}

// CONEXION CON LA IA
document.getElementById('btn-comparar-maestro').addEventListener('click', function (e) {
    e.preventDefault();            // Evita el comportamiento por defecto del botón para que no recargue la página
    e.stopImmediatePropagation();  // Evita que otros scripts escuchen este click

    // Si no hay 2 guitarras seleccionadas, mostramos una notificación y salimos
    if (seleccionadas.length !== 2) {
        notyf.open({ type: 'info', message: 'Selecciona 2 guitarras primero' });
        return;
    }

    // Extraemos los datos de las guitarras seleccionadas para enviarlos a la IA
    const datos = seleccionadas.map(card => ({
        cuerpo: card.querySelector('.val-cuerpo').innerText,         //Valor Cuerpo
        mastil: card.querySelector('.val-mastil').innerText,         //Valor Mástil
        pastillas: card.querySelector('.val-pastillas').innerText,   //Valor Pastillas
        precio: card.querySelector('.precio span').innerText         //Valor Precio
    }));

    // Mostramos una notificación de que se está procesando la solicitud
    notyf.success("El Maestro Luthier está analizando...");

    // Enviamos los datos de las guitarras seleccionadas al servidor de IA
    fetch('http://localhost:5000/comparar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ g1: datos[0], g2: datos[1] })
    })
        .then(res => {
            if (!res.ok) throw new Error();
            return res.json();
        })
        .then(data => {
            // Mostramos el resultado de la IA en el contenedor correspondiente
            document.getElementById('contenedor-resultado-ia').style.display = "block";
            document.getElementById('texto-ia').innerText = data.analisis;
            window.scrollTo({ top: 0, behavior: 'smooth' }); // Scroll suave hacia el resultado
        })
        .catch(() => {
            // Si hay un error, mostramos una notificación de error
            notyf.error("El servidor de IA no responde");
        });
});

// LOGICA DEL CARRITO DE COMPRAS
document.addEventListener('click', function (e) {
    // Si el click es en un botón de añadir al carrito, procesamos la acción
    if (e.target.classList.contains('btn-add-cart')) {
        e.preventDefault();
        e.stopImmediatePropagation();
        
        // Extraemos el ID y el precio de la guitarra desde los atributos data del botón
        const idGuitarra = e.target.getAttribute('data-id');
        const precioGuitarra = e.target.getAttribute('data-precio');
        const formData = new FormData(); // Creamos un FormData para enviar los datos al backend
        formData.append('id_guitarra', idGuitarra); // Añadimos ID al FormData
        formData.append('precio', precioGuitarra);  // Añadimos precio al FormData

        // Enviamos la solicitud al backend para añadir la guitarra al carrito
        fetch("../../../backend/php/add_carrito.php",
            {
                method: "POST",
                body: formData
            })
            .then(res => res.ok ? notyf.success("Añadida al carrito") : notyf.error("Error al añadir")) //
            .catch(() => notyf.error("Error de conexión"));
    }
});

// Función para cerrar el resultado de la IA y resetear las selecciones
window.cerrarIA = function () {
    // Ocultamos el resultado de la IA y reseteamos las selecciones
    document.getElementById('contenedor-resultado-ia').style.display = "none";
    // Reseteamos las selecciones y el estilo de las tarjetas
    seleccionadas.forEach(el => {
        el.style.border = "none";
        el.style.transform = "scale(1)";
    });
    // Limpiamos el array de seleccionadas y reseteamos el botón de comparar
    seleccionadas = [];
    document.getElementById('btn-comparar-maestro').innerText = "Selecciona 2 guitarras (0/2)";
    document.getElementById('btn-comparar-maestro').style.backgroundColor = "#1a1a1a";
}