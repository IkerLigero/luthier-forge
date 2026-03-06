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
    
    camera.position.set(0, 8, 0.1);
    
    // Hacemos que la cámara mire al centro del suelo
    camera.lookAt(0, 0, -2.7);

    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    container.appendChild(renderer.domElement);

    const ambientLight = new THREE.AmbientLight(0xffffff, 1.8);
    const dirLight = new THREE.DirectionalLight(0xffffff, 1);
    dirLight.position.set(0, 10, 0); // Luz desde arriba también
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
});