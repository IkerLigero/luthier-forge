import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls.js";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";

window.onload = inicio;

async function inicio() {

    const contenedor = document.getElementById("canvas-three");
    const btnBorrar = document.getElementById("borrar-canvas");
    const btnGuardar = document.getElementById("guardar-guitarra");

    const subForma = document.getElementById("sub-forma");
    const subMastil = document.getElementById("sub-mastil");
    const subPastillas = document.getElementById("sub-pastillas");

    const btnForma = document.getElementById("cargar-forma");
    const btnMastil = document.getElementById("cargar-mastil");
    const btnPastillas = document.getElementById("cargar-pastillas");

    const idsSeleccionados = { forma: null, mastil: null, pastillas: null };
    const piezasActuales = { forma: null, mastil: null, pastillas: null };

    const pathArray = window.location.pathname.split('/');
    const rootPath = pathArray.slice(0, pathArray.indexOf('frontend')).join('/') + '/'; // Construimos la ruta raíz hasta la carpeta "frontend"

    const renderer = new THREE.WebGLRenderer({ antialias: true, preserveDrawingBuffer: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(contenedor.clientWidth, contenedor.clientHeight);
    contenedor.appendChild(renderer.domElement);

    //Definimos escena ----------------------------------------------------------------------------------------------------------------------------------------------------------------
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xfcfcfc);

    //Definimos cámara ----------------------------------------------------------------------------------------------------------------------------------------------------------------
    const fov = 50;
    const aspect = contenedor.clientWidth / contenedor.clientHeight;
    const near = 0.1;
    const far = 1000;
    const camera = new THREE.PerspectiveCamera(fov, aspect, near, far);
    camera.position.set(0, 0, 10);

    //Definimos controles (OrbitControls) ---------------------------------------------------------------------------------------------------------------------------------------------
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;


    //Definimos luces -----------------------------------------------------------------------------------------------------------------------------------------------------------------
    const hemi = new THREE.HemisphereLight(0xffffff, 0x444444, 1.5);
    scene.add(hemi);

    const dir = new THREE.DirectionalLight(0xffffff, 2);
    dir.position.set(5, 5, 5);
    scene.add(dir);


    //Función para actualizar el tamaño del canvas y la cámara al cambiar el tamaño de la ventana -------------------------------------------------------------------------------------
    function actualizarTamano() {
        const width = contenedor.clientWidth;
        const height = contenedor.clientHeight;

        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
    }
    window.addEventListener("resize", actualizarTamano);

    //Definimos loader para modelos GLB ------------------------------------------------------------------------------------------------------------------------------------------------
    const loader = new GLTFLoader();
    function cargarModelo(tipo, rutaGlb) {
        if (!rutaGlb) return; // Si no hay ruta, out

        if (piezasActuales[tipo]) scene.remove(piezasActuales[tipo]); // Eliminamos duplicados del mismo tipo.

        // Cargamos el modelo GLB y lo agregamos a la escena
        loader.load(rootPath + rutaGlb, (gltf) => {
            const obj = gltf.scene;
            obj.position.set(0, 0, 0);

            piezasActuales[tipo] = obj;
            scene.add(obj);
        });
    }

    //Async Await para obtener datos de componentes desde el backend y poblar los menús ------------------------------------------------------------------------------------------------
    try {
        const res = await fetch(rootPath + "backend/php/get_componentes.php");
        const data = await res.json();

        poblarMenu("forma", data.formas, subForma);
        poblarMenu("mastil", data.mastiles, subMastil);
        poblarMenu("pastillas", data.pastillas, subPastillas);

    } catch {
        // En caso de error, mostramos un mensaje simple en cada menú
    }

    function poblarMenu(tipo, items, menu) {
        menu.innerHTML = "";

        items.forEach(item => {

            const card = document.createElement("div");
            card.className = "card-item";

            let idReal = null;

            if (tipo === "forma") idReal = item.id_forma_color ?? item.id;
            if (tipo === "mastil") idReal = item.id_mastil ?? item.id;
            if (tipo === "pastillas") idReal = item.id_pastilla_modelo ?? item.id;

            const rutaModelo = item.referencia_glb ?? item.glb ?? null;

            const imagen =
                item.imagen ??
                item.imagen_pastillas ??
                item.img ??
                "";

            const nombre =
                item.nombre ??
                item.color ??
                item.tipo ??
                "pieza";

            card.innerHTML = `
                <img src="${rootPath + imagen}" alt="${nombre}">
                <span>${nombre}</span>
            `;

            card.onclick = () => {

                if (!idReal) return;

                cargarModelo(tipo, rutaModelo);
                idsSeleccionados[tipo] = idReal;

            };

            menu.appendChild(card);

        });
    }

    if (btnBorrar) {

        btnBorrar.onclick = () => {

            scene.clear();

            const hemi = new THREE.HemisphereLight(0xffffff, 0x444444, 1.5);
            scene.add(hemi);

            const dir = new THREE.DirectionalLight(0xffffff, 2);
            dir.position.set(5, 5, 5);
            scene.add(dir);

            Object.keys(idsSeleccionados).forEach(k => idsSeleccionados[k] = null);
            Object.keys(piezasActuales).forEach(k => piezasActuales[k] = null);

            camera.position.set(0, 0, 10);
            controls.target.set(0, 0, 0);
            controls.update();

        };

    }

    if (btnGuardar) {

        btnGuardar.onclick = async () => {

            if (!idsSeleccionados.forma || !idsSeleccionados.mastil || !idsSeleccionados.pastillas) return;

            const payload = {
                id_forma_color: idsSeleccionados.forma,
                id_mastil: idsSeleccionados.mastil,
                id_pastilla_modelo: idsSeleccionados.pastillas
            };

            try {

                const response = await fetch(rootPath + "backend/php/guardar_guitarra.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(payload)
                });

                await response.json();

            } catch { }

        };

    }

    //Función de animación para renderizar la escena continuamente ------------------------------------------------------------------------------------------------------------------------
    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }

    animate();

    const mapping = {
        "cargar-forma": subForma,
        "cargar-mastil": subMastil,
        "cargar-pastillas": subPastillas
    };

    const botones = {
        "cargar-forma": btnForma,
        "cargar-mastil": btnMastil,
        "cargar-pastillas": btnPastillas
    };

    Object.keys(mapping).forEach(id => {

        const btn = botones[id];
        const submenu = mapping[id];

        if (!btn) return;

        btn.onclick = () => {

            const oculto = submenu.classList.contains("hidden");

            document.querySelectorAll(".submenu").forEach(s => s.classList.add("hidden"));

            if (oculto) submenu.classList.remove("hidden");

            setTimeout(actualizarTamano, 50);

        };

    });

}