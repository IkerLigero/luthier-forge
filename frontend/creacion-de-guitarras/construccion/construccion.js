import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls.js";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";

const notyf = new Notyf({
    duration: 4000,
    position: { x: 'right', y: 'top' }
});

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
    const rootPath = pathArray.slice(0, pathArray.indexOf('frontend')).join('/') + '/';

    const renderer = new THREE.WebGLRenderer({ antialias: true, preserveDrawingBuffer: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(contenedor.clientWidth, contenedor.clientHeight);
    contenedor.appendChild(renderer.domElement);

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xfcfcfc);

    const fov = 50;
    const aspect = contenedor.clientWidth / contenedor.clientHeight;
    const near = 0.1;
    const far = 1000;
    const camera = new THREE.PerspectiveCamera(fov, aspect, near, far);
    camera.position.set(0, 0, 10);

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    const hemi = new THREE.HemisphereLight(0xffffff, 0x444444, 1.5);
    scene.add(hemi);

    const dir = new THREE.DirectionalLight(0xffffff, 2);
    dir.position.set(5, 5, 5);
    scene.add(dir);

    function actualizarTamano() {
        const width = contenedor.clientWidth;
        const height = contenedor.clientHeight;

        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
    }

    window.addEventListener("resize", actualizarTamano);

    const loader = new GLTFLoader();

    function cargarModelo(tipo, rutaGlb) {

        if (!rutaGlb) return;

        if (piezasActuales[tipo]) scene.remove(piezasActuales[tipo]);

        loader.load(rootPath + rutaGlb, (gltf) => {

            const obj = gltf.scene;
            obj.position.set(0, 0, 0);

            piezasActuales[tipo] = obj;
            scene.add(obj);

        });
    }

    try {

        const res = await fetch(rootPath + "backend/php/get_componentes.php");
        const data = await res.json();

        poblarMenu("forma", data.formas, subForma);
        poblarMenu("mastil", data.mastiles, subMastil);
        poblarMenu("pastillas", data.pastillas, subPastillas);

    } catch {
        notyf.error("Error cargando componentes");
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

            notyf.success("Diseño reseteado");

        };

    }

    if (btnGuardar) {

        btnGuardar.onclick = async () => {

            if (!idsSeleccionados.forma || !idsSeleccionados.mastil || !idsSeleccionados.pastillas) {

                notyf.error("Selecciona todas las piezas antes de guardar");
                return;

            }

            const payload = {
                id_forma_color: idsSeleccionados.forma,
                id_mastil: idsSeleccionados.mastil,
                id_pastilla_modelo: idsSeleccionados.pastillas
            };

            try {

                const response = await fetch(rootPath + "backend/php/guardar_guitarra.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload)
                });

                const resultado = await response.json();

                if (resultado.success) {

                    notyf.success("Guitarra guardada en tu perfil");

                } else {

                    notyf.error("Error al guardar la guitarra");

                }

            } catch {

                notyf.error("Error de conexión con el servidor");

            }

        };

    }

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