// Importo THREE y GTLFLoader

import * as THREE from "https://unpkg.com/three@0.160.0/build/three.module.js";
import { GLTFLoader } from "https://unpkg.com/three@0.160.0/examples/jsm/loaders/GLTFLoader.js";

window.onload = inicio;

function inicio() {

    //Obteno los botones del HTML
    let contenedor = document.getElementById("three-pua");

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

    //Luz General
    const ambient = new THREE.AmbientLight(0xffffff, 3);
    scene.add(ambient);

    const loader = new GLTFLoader();
}