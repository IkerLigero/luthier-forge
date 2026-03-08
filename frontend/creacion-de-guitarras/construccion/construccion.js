import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls.js";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";

/* NOTIFICACIONES */

const notyf = new Notyf({
    duration: 4000,
    position: { x: 'right', y: 'bottom' }
});

window.onload = iniciarConfigurador;

async function iniciarConfigurador() {

    /* ELEMENTOS DOM */

    const visor3D = document.getElementById("visor-guitarra-3d");

    const btnReset = document.getElementById("btn-reset-configuracion");
    const btnGuardar = document.getElementById("btn-guardar-configuracion");

    const menuCuerpos = document.getElementById("menu-cuerpos");
    const menuMastiles = document.getElementById("menu-mastiles");
    const menuPastillas = document.getElementById("menu-pastillas");

    const btnCuerpos = document.getElementById("btn-cargar-cuerpo");
    const btnMastiles = document.getElementById("btn-cargar-mastil");
    const btnPastillas = document.getElementById("btn-cargar-pastillas");

    /* ESTADO CONFIGURADOR */

    const idsComponentesSeleccionados = { forma: null, mastil: null, pastillas: null };
    const piezasCargadas = { forma: null, mastil: null, pastillas: null };

    /* RUTA BASE */

    const pathArray = window.location.pathname.split('/');
    const rootPath = pathArray.slice(0, pathArray.indexOf('frontend')).join('/') + '/';

    /* RENDER THREE */

    const renderer = new THREE.WebGLRenderer({ antialias: true, preserveDrawingBuffer: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(visor3D.clientWidth, visor3D.clientHeight);
    visor3D.appendChild(renderer.domElement);

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xfcfcfc);

    /* CÁMARA */

    const camera = new THREE.PerspectiveCamera(
        50,
        visor3D.clientWidth / visor3D.clientHeight,
        0.1,
        1000
    );

    camera.position.set(0, 0, 10);

    /* CONTROLES */

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    /* LUCES */

    const hemi = new THREE.HemisphereLight(0xffffff, 0x444444, 1.5);
    scene.add(hemi);

    const dir = new THREE.DirectionalLight(0xffffff, 2);
    dir.position.set(5, 5, 5);
    scene.add(dir);

    /* RESIZE */

    function actualizarTamano() {

        const width = visor3D.clientWidth;
        const height = visor3D.clientHeight;

        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);

    }

    window.addEventListener("resize", actualizarTamano);

    /* CARGADOR MODELOS */

    const loader = new GLTFLoader();

    function cargarModelo(tipo, ruta) {

        if (!ruta) return;

        if (piezasCargadas[tipo]) scene.remove(piezasCargadas[tipo]);

        loader.load(rootPath + ruta, (gltf) => {

            const obj = gltf.scene;
            obj.position.set(0, 0, 0);

            piezasCargadas[tipo] = obj;
            scene.add(obj);

        });

    }

    /* OBTENER COMPONENTES */

    try {

        const res = await fetch(rootPath + "backend/php/get_componentes.php");
        const data = await res.json();

        poblarMenu("forma", data.formas, menuCuerpos);
        poblarMenu("mastil", data.mastiles, menuMastiles);
        poblarMenu("pastillas", data.pastillas, menuPastillas);

    } catch {

        notyf.error("Error cargando componentes");

    }

    /* CREAR TARJETAS */

    function poblarMenu(tipo, items, menu) {

        menu.innerHTML = "";

        items.forEach(item => {

            const card = document.createElement("div");
            card.className = "tarjeta-componente";

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
                idsComponentesSeleccionados[tipo] = idReal;

            };

            menu.appendChild(card);

        });

    }

    /* RESET */

    if (btnReset) {

        btnReset.onclick = () => {

            scene.clear();

            const hemi = new THREE.HemisphereLight(0xffffff, 0x444444, 1.5);
            scene.add(hemi);

            const dir = new THREE.DirectionalLight(0xffffff, 2);
            dir.position.set(5, 5, 5);
            scene.add(dir);

            Object.keys(idsComponentesSeleccionados).forEach(k => idsComponentesSeleccionados[k] = null);
            Object.keys(piezasCargadas).forEach(k => piezasCargadas[k] = null);

            camera.position.set(0, 0, 10);
            controls.target.set(0, 0, 0);
            controls.update();

            notyf.success("Diseño reseteado");

        };

    }

    /* GUARDAR */

    if (btnGuardar) {

        btnGuardar.onclick = async () => {

            if (!idsComponentesSeleccionados.forma ||
                !idsComponentesSeleccionados.mastil ||
                !idsComponentesSeleccionados.pastillas) {

                notyf.error("Selecciona todas las piezas antes de guardar");
                return;

            }

            const payload = {
                id_forma_color: idsComponentesSeleccionados.forma,
                id_mastil: idsComponentesSeleccionados.mastil,
                id_pastilla_modelo: idsComponentesSeleccionados.pastillas
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

    /* LOOP */

    function animar() {

        requestAnimationFrame(animar);
        controls.update();
        renderer.render(scene, camera);

    }

    animar();

    /* MENÚS */

    const mapping = {
        "btn-cargar-cuerpo": menuCuerpos,
        "btn-cargar-mastil": menuMastiles,
        "btn-cargar-pastillas": menuPastillas
    };

    const botones = {
        "btn-cargar-cuerpo": btnCuerpos,
        "btn-cargar-mastil": btnMastiles,
        "btn-cargar-pastillas": btnPastillas
    };

    Object.keys(mapping).forEach(id => {

        const btn = botones[id];
        const submenu = mapping[id];

        if (!btn) return;

        btn.onclick = () => {

            const oculto = submenu.classList.contains("oculto");

            document.querySelectorAll(".grid-componentes").forEach(s => s.classList.add("oculto"));

            if (oculto) submenu.classList.remove("oculto");

            setTimeout(actualizarTamano, 50);

        };

    });

}