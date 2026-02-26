//Importo THREE
import * as THREE from "https://unpkg.com/three@0.160.0/build/three.module.js";
import { OrbitControls } from "https://unpkg.com/three@0.160.0/examples/jsm/controls/OrbitControls.js";
import { GLTFLoader } from "https://unpkg.com/three@0.160.0/examples/jsm/loaders/GLTFLoader.js";

window.onload = inicio;

function inicio() {

    //Obtengo los botones del HTML
    let forma = document.getElementById("cargar-forma");
    let mastil = document.getElementById("cargar-mastil");
    let pastillas = document.getElementById("cargar-pastillas");
    let reset = document.getElementById("borrar-canvas");
    let contenedor = document.getElementById("canvas-three");

    //Definimos renderer
    const w = contenedor.clientWidth;
    const h = contenedor.clientHeight;
    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(w, h);
    contenedor.appendChild(renderer.domElement);

    //Definimos camara
    const fov = 75;
    const aspect = w / h;
    const near = 0.1;
    const far = 1000;
    const camera = new THREE.PerspectiveCamera(fov, aspect, near, far);
    camera.position.set(0, 2, 6);

    //Defino una escena
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x111111);

    //Orbit Controls
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    // Luces basicas
    const light = new THREE.DirectionalLight(0xffffff, 3);
    light.position.set(5, 10, 5);
    scene.add(light);

    const ambient = new THREE.AmbientLight(0xffffff, 1);
    scene.add(ambient);

    // Loader 
    const loader = new GLTFLoader();

    function cargarModelo(ruta) {
        loader.load(ruta, (gltf) => {
            scene.add(gltf.scene);
        },
            undefined, // Parametro irrelevante
            (error) => {
                console.log("Imposible de cargar");
                console.error(error);
            });
    }

    // Interaccion con los botones:
    forma.addEventListener("click", () => {
        cargarModelo("../../../Modelos/Formas/Explorer/Explorer_Caoba.glb");
    });

    mastil.addEventListener("click", () => {
        cargarModelo("../../../Modelos/Pala_Mastil/Guibson_3mas3.glb");
    });

    pastillas.addEventListener("click", () => {
        cargarModelo("../../../Modelos/Hambucker/Hambucker_Explorer.glb");
    });

    reset.addEventListener("click", () => {
        limpiarEscena();
    });

    function limpiarEscena() {
        scene.clear();
        camera.position.set(0, 2, 6);
        scene.add(light);
        scene.add(ambient);
    }

    // Ajustamos tamaño de obj a ventana
    window.addEventListener("resize", (ev) => {
        const newWidth = contenedor.clientWidth;
        const newHeight = contenedor.clientHeight;

        renderer.setSize(newWidth, newHeight);
        camera.aspect = newWidth / newHeight;
        camera.updateProjectionMatrix();
    });

    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }

    animate();
}