import * as THREE from "three";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";

window.onload = inicio;

const pathArray = window.location.pathname.split('/');
const rootPath = pathArray.slice(0, pathArray.indexOf('frontend')).join('/') + '/';

// Variables para el comparador IA
let seleccionadas = [];
const notyf = new Notyf({ duration: 3000, position: { x: 'right', y: 'bottom' } });

function inicio() {
    const containers = document.querySelectorAll('.canvas-container');

    containers.forEach(container => {
        if (container.clientWidth === 0) return;

        const scene = new THREE.Scene();
        scene.background = new THREE.Color(0xfcfcfc);

        let w = container.clientWidth;
        let h = container.clientHeight;
        const camera = new THREE.PerspectiveCamera(45, w / h, 0.1, 1000);
        camera.position.set(0, 8, 0.1);
        camera.lookAt(0, 0, -2.7);

        const renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(w, h);
        container.appendChild(renderer.domElement);

        const ambientLight = new THREE.AmbientLight(0xffffff, 1.8);
        const dirLight = new THREE.DirectionalLight(0xffffff, 1);
        dirLight.position.set(0, 10, 2);
        scene.add(ambientLight, dirLight);

        const piezas = [
            container.getAttribute('data-forma'),
            container.getAttribute('data-mastil'),
            container.getAttribute('data-pastillas')
        ];

        piezas.forEach(ruta => {
            if (ruta) {
                const loader = new GLTFLoader();
                loader.load(rootPath + ruta, (gltf) => {
                    scene.add(gltf.scene);
                });
            }
        });

        function animar() {
            requestAnimationFrame(animar);
            renderer.render(scene, camera);
        }
        animar();
    });

    // Delegación para botones de carrito
    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('btn-carrito')) {
            const idGuitarra = event.target.getAttribute('data-id');
            const precioGuitarra = event.target.getAttribute('data-precio');
            const formData = new FormData();
            formData.append('id_guitarra', idGuitarra);
            formData.append('precio', precioGuitarra);

            fetch("../../../backend/php/add_carrito.php", { method: "POST", body: formData })
                .then(res => res.ok ? notyf.success("¡Añadida!") : notyf.error("Error"))
                .catch(() => notyf.error("Error de red"));
        }
    });
}

// FUNCIONES DEL COMPARADOR IA
window.seleccionarParaComparar = function(el) {
    // Si ya está seleccionada, la quitamos
    if (seleccionadas.includes(el)) {
        el.style.border = "none";
        seleccionadas = seleccionadas.filter(item => item !== el);
    } else {
        // Máximo 2 guitarras
        if (seleccionadas.length < 2) {
            el.style.border = "3px solid #8c2411";
            seleccionadas.push(el);
        } else {
            notyf.error("Solo puedes comparar 2 guitarras");
        }
    }

    // Actualizar botón
    const btn = document.getElementById('btn-comparar-maestro');
    if (seleccionadas.length === 2) {
        btn.innerText = "¡Comparar ahora!";
        btn.style.backgroundColor = "#8c2411";
        btn.onclick = enviarAPython;
    } else {
        btn.innerText = `Comparar Guitarras (${seleccionadas.length}/2)`;
        btn.style.backgroundColor = "#1a1a1a";
        btn.onclick = null;
    }
}

function enviarAPython() {
    const dataGuitarras = seleccionadas.map(card => {
        return {
            cuerpo: card.querySelector('.val-cuerpo').innerText,
            mastil: card.querySelector('.val-mastil').innerText,
            pastillas: card.querySelector('.val-pastillas').innerText,
            precio: card.querySelector('.precio').innerText
        };
    });

    notyf.success("Consultando al Maestro Luthier...");
    
    fetch('http://localhost:5000/comparar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ g1: dataGuitarras[0], g2: dataGuitarras[1] })
    })
    .then(response => response.json())
    .then(data => {
        const contenedor = document.getElementById('contenedor-resultado-ia');
        const texto = document.getElementById('texto-ia');
        contenedor.style.display = "block";
        texto.innerText = data.analisis;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    })
    .catch(error => {
        console.error(error);
        notyf.error("El servidor de IA no responde");
    });
}

window.cerrarIA = function() {
    document.getElementById('contenedor-resultado-ia').style.display = "none";
    seleccionadas.forEach(el => el.style.border = "none");
    seleccionadas = [];
    document.getElementById('btn-comparar-maestro').innerText = "Comparar Guitarras (0/2)";
}


// Todas las "buenas practicas" como los return y demas componentes han sido proporcionadas por diversas
// IAs, para hacer el codigo mas practico y escalable.