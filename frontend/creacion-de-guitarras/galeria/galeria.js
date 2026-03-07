import * as THREE from "three";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";

const loader = new GLTFLoader();
const pathArray = window.location.pathname.split('/');
const rootPath = pathArray.slice(0, pathArray.indexOf('frontend')).join('/') + '/';

function initMiniScene(container) {
    if (container.clientWidth === 0) return;
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xfcfcfc);
    const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);

    // Ajuste de cámara cenital corregido
    camera.position.set(0, 10, 4.5); 
    camera.lookAt(0, 0, 0);

    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
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
            loader.load(rootPath + ruta, (gltf) => {
                scene.add(gltf.scene);
            });
        }
    });

    function animate() {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);
    }
    animate();
}

window.addEventListener('load', () => {
    document.querySelectorAll('.canvas-container').forEach(container => {
        initMiniScene(container);
    });

    const notyf = new Notyf({
        duration: 3000,
        position: { x: 'right', y: 'bottom' }
    });

    // Delegación de eventos para capturar el clic en botones de carrito
    document.addEventListener('click', function (event) {
        const target = event.target;
        if (target && target.classList.contains('btn-carrito')) {
            const idGuitarra = target.getAttribute('data-id');
            const precioGuitarra = target.getAttribute('data-precio');

            const formData = new FormData();
            formData.append('id_guitarra', idGuitarra);
            formData.append('precio', precioGuitarra);

            // RUTA CORREGIDA: Ajustada para llegar a backend/php/ desde el frontend
            fetch("../../../backend/php/add_carrito.php", {
                method: "POST",
                body: formData
            })
            .then(async response => {
                if (response.ok) {
                    notyf.success("¡Guitarra añadida al carrito!");
                } else {
                    const errorMsg = await response.text();
                    console.error("Error del servidor:", errorMsg);
                    notyf.error("Error al añadir al carrito");
                }
            })
            .catch(error => {
                console.error("Error de red:", error);
                notyf.error("No se pudo conectar con el servidor");
            });
        }
    });
});