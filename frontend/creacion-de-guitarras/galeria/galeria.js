import * as THREE from "three";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";

window.onload = inicio;

const pathArray = window.location.pathname.split('/');
const rootPath = pathArray.slice(0, pathArray.indexOf('frontend')).join('/') + '/';

function inicio() {

    // Seleccionamos los contenedores de los visores 3D
    const containers = document.querySelectorAll('.canvas-container');

    // Por cada contenedor, creamos una escena 3D
    containers.forEach(container => {

        // Si el contenedor tiene ancho 0, no hacemos nada
        if (container.clientWidth === 0) {
            return;
        }

        // ESCENA
        const scene = new THREE.Scene();
        scene.background = new THREE.Color(0xfcfcfc);

        // CAMARA
        let w = container.clientWidth;
        let h = container.clientHeight;
        let fov = 45;
        let near = 0.1;
        let far = 1000;
        let aspect = w / h;
        const camera = new THREE.PerspectiveCamera(fov, aspect, near, far);
        camera.position.set(0, 8, 0.1);
        camera.lookAt(0, 0, -2.7);

        // RENDERER
        const renderer = new THREE.WebGLRenderer({ antialias: true });
        renderer.setSize(w, h);
        container.appendChild(renderer.domElement);

        // ILUMINACION
        const ambientLight = new THREE.AmbientLight(0xffffff, 1.8);
        const dirLight = new THREE.DirectionalLight(0xffffff, 1);
        dirLight.position.set(0, 10, 2);
        scene.add(ambientLight, dirLight);

        // Cargamos piezas según atributos del contenedor
        const piezas = [
            container.getAttribute('data-forma'),
            container.getAttribute('data-mastil'),
            container.getAttribute('data-pastillas')
        ];

        // LOADER
        piezas.forEach(ruta => {
            if (ruta) {
                const loader = new GLTFLoader();
                loader.load(rootPath + ruta, (gltf) => {
                    scene.add(gltf.scene);
                });
            }
        });

        // ANIMACION
        function animar() {
            requestAnimationFrame(animar);
            renderer.render(scene, camera);
        }
        animar();

        // REDIMENSIONAR
        window.addEventListener('resize', () => {
            w = container.clientWidth;
            h = container.clientHeight;
            camera.aspect = w / h;
            camera.updateProjectionMatrix();
            renderer.setSize(w, h);
        });
    });

    // Configuración de notificaciones
    const notyf = new Notyf({
        duration: 3000,
        position: { x: 'right', y: 'bottom' }
    });

    // Delegación de eventos: añadir guitarra al carrito
    document.addEventListener('click', function (event) {
        const target = event.target;
        if (target && target.classList.contains('btn-carrito')) {

            // Obtenemos los datos del botón
            const idGuitarra = target.getAttribute('data-id');
            const precioGuitarra = target.getAttribute('data-precio');

            const formData = new FormData();
            formData.append('id_guitarra', idGuitarra);
            formData.append('precio', precioGuitarra);

            // Realizamos la petición POST para añadir al carrito
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
}


// Todas las "buenas practicas" como los return y demas componentes han sido proporcionadas por diversas
// IAs, para hacer el codigo mas practico y escalable.