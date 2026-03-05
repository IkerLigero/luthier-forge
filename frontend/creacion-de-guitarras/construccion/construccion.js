import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls.js";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";

window.onload = inicio;

async function inicio() {
    let contenedor = document.getElementById("canvas-three");

    // RUTA MAESTRA: Detecta si estás en luthier_forge/luthier-forge automáticamente
    const pathArray = window.location.pathname.split('/');
    const rootPath = pathArray.slice(0, pathArray.indexOf('frontend')).join('/') + '/';

    // --- THREE.JS SETUP ---
    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(contenedor.clientWidth, contenedor.clientHeight);
    contenedor.appendChild(renderer.domElement);

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x111111);

    const camera = new THREE.PerspectiveCamera(45, contenedor.clientWidth / contenedor.clientHeight, 0.01, 1000);
    camera.position.set(0, 0, 10);

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.screenSpacePanning = false; // Mantiene el eje mejor para guitarras
    controls.minDistance = 1;   // Que no te metas dentro de la madera
    controls.maxDistance = 20;  // Que no se vaya al infinito

    const loader = new GLTFLoader();
    const piezasActuales = { forma: null, mastil: null, pastillas: null };

    scene.add(new THREE.HemisphereLight(0xffffff, 0x444444, 1.5));
    const light = new THREE.DirectionalLight(0xffffff, 2);
    light.position.set(5, 5, 5);
    scene.add(light);

    // --- CARGAR MODELOS ---
    function cargarModelo(tipo, rutaGlb) {
        if (piezasActuales[tipo]) scene.remove(piezasActuales[tipo]);

        loader.load(rootPath + rutaGlb, (gltf) => {
            const obj = gltf.scene;

            // IMPORTANTE: No usamos box.getCenter aquí si queremos que encajen.
            // Solo reseteamos la posición a 0 para que use el origen del archivo.
            obj.position.set(0, 0, 0);

            piezasActuales[tipo] = obj;
            scene.add(obj);5

            console.log(`Cargado ${tipo} en origen:`, rutaGlb);
        }, undefined, (e) => console.error("Error:", e));
    }

    // --- CARGAR DATOS ---
    try {
        const res = await fetch(rootPath + 'backend/php/get_componentes.php');
        const data = await res.json();

        poblarMenu('forma', data.formas, 'sub-forma');
        poblarMenu('mastil', data.mastiles, 'sub-mastil');
        poblarMenu('pastillas', data.pastillas, 'sub-pastillas');
    } catch (e) { console.error("Error BD:", e); }

    function poblarMenu(tipo, items, contenedorId) {
        const menu = document.getElementById(contenedorId);
        items.forEach(item => {
            const card = document.createElement("div");
            card.className = "card-item";
            card.innerHTML = `
                <img src="${rootPath + item.img}" alt="pieza">
                <span>${item.nombre}</span>
            `;
            card.onclick = () => cargarModelo(tipo, item.glb);
            menu.appendChild(card);
        });
    }

    // --- ANIMACIÓN ---
    function animate() {
        requestAnimationFrame(animate);
        controls.update(); // CRUCIAL para el zoom suave
        renderer.render(scene, camera);
    }
    animate();

    // Lógica de menús
    const mapping = { 'cargar-forma': 'sub-forma', 'cargar-mastil': 'sub-mastil', 'cargar-pastillas': 'sub-pastillas' };
    Object.keys(mapping).forEach(id => {
        document.getElementById(id).onclick = () => {
            document.querySelectorAll('.submenu').forEach(s => s.classList.add('hidden'));
            document.getElementById(mapping[id]).classList.remove('hidden');
        };
    });
}