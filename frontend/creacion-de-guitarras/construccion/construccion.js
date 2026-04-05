import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls.js";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";

// Configura las notificaciones flotantes que acompañan toda la experiencia de creación.
/* NOTYF */

const notyf = new Notyf({
    duration: 4000,
    position: { x: "right", y: "bottom" }
});

// Inicia el configurador 3D cuando la página ya está preparada.
window.onload = inicio;

async function inicio() {


    // Recoge los nodos principales de la interfaz para trabajar con ellos más adelante.
    // Elementos del DOM
    const visor3D = document.getElementById("visor-guitarra-3d");

    const btnReset = document.getElementById("btn-reset-configuracion");
    const btnGuardar = document.getElementById("btn-guardar-configuracion");

    const menuCuerpos = document.getElementById("menu-cuerpos");
    const menuMastiles = document.getElementById("menu-mastiles");
    const menuPastillas = document.getElementById("menu-pastillas");

    const btnCuerpos = document.getElementById("btn-cargar-cuerpo");
    const btnMastiles = document.getElementById("btn-cargar-mastil");
    const btnPastillas = document.getElementById("btn-cargar-pastillas");

    // Guarda tanto los ids elegidos como las piezas 3D cargadas actualmente en escena.
    // Variables para almacenar ID
    const idsComponentesSeleccionados = { forma: null, mastil: null, pastillas: null };
    const piezasCargadas = { forma: null, mastil: null, pastillas: null };

    // Calcula la ruta raíz del proyecto para poder cargar modelos y endpoints sin hardcodear.
    // PATH
    const pathArray = window.location.pathname.split("/");
    const rootPath = pathArray.slice(0, pathArray.indexOf("frontend")).join("/") + "/";

    // Crea el renderer de Three.js y lo inserta en el visor principal.
    // RENDERER
    let w = visor3D.clientWidth;
    let h = visor3D.clientHeight;
    const renderer = new THREE.WebGLRenderer({antialias: true, preserveDrawingBuffer: true});

    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(w, h);

    renderer.outputColorSpace = THREE.SRGBColorSpace;

    let toneMapping = THREE.ACESFilmicToneMapping;
    let exposure = 1.5;

    renderer.toneMapping = toneMapping;
    renderer.toneMappingExposure = exposure;

    visor3D.appendChild(renderer.domElement);

    // Escena base donde se irán añadiendo cuerpo, mástil y pastillas.
    // ESCENA
    const scene = new THREE.Scene();
    const backgroundColor = 0xfcfcfc;
    scene.background = new THREE.Color(backgroundColor);


    // Cámara principal desde la que el usuario verá la guitarra montada.
    // CAMARA 
    let fov = 50;
    let aspect = w / h;
    let near = 0.1;
    let far = 1000;
    const camera = new THREE.PerspectiveCamera(fov, aspect, near, far);
    camera.position.set(0, 0, 10);


    // Permite orbitar alrededor del modelo con inercia suave.
    // Orbit Controls
    const controls = new OrbitControls(camera, renderer.domElement);
    let damping = true;
    controls.enableDamping = damping;


    // Crea una iluminación neutra para que todas las piezas se vean bien en el visor.
    // LUCES
    function crearIluminacion() {
        const hemi = new THREE.HemisphereLight(0xffffff, 0x444444, 0.8);
        scene.add(hemi);

        const dirPrincipal = new THREE.DirectionalLight(0xffffff, 4.2);
        dirPrincipal.position.set(5, 5, 5);
        dirPrincipal.target.position.set(0, 0, 0);
        scene.add(dirPrincipal);

        const dirContra = new THREE.DirectionalLight(0xffffff, 2);
        dirContra.position.set(-5, 3, -5);
        scene.add(dirContra);
    }
    crearIluminacion();

    // Funcion para actualizar tamaño del renderer y camara
    function actualizarTamano() {

        w = visor3D.clientWidth;
        h = visor3D.clientHeight;

        camera.aspect = w / h;
        camera.updateProjectionMatrix();

        renderer.setSize(w, h);
    }
    // Evento que se dispara al redimensionar la ventana
    window.addEventListener("resize", actualizarTamano);


    // LOADER (glb)
    const loader = new GLTFLoader();

    // Sustituye la pieza actual de un tipo por el nuevo modelo GLB seleccionado.
    function cargarModelo(tipo, ruta) {
        if (!ruta) return; // Si no hay ruta -> no hacemos nada

        // Limpiar modelos repetidos
        if (piezasCargadas[tipo]) {
            scene.remove(piezasCargadas[tipo]);
        }

        // Cargar nuevo modelo
        loader.load(rootPath + ruta, (gltf) => {
            const obj = gltf.scene;
            obj.position.set(0, 0, 0);
            piezasCargadas[tipo] = obj;
            scene.add(obj);
        });

    }

    // Obtenemos componentes desde backend y poblamos menús
    // Carga desde backend el catálogo disponible y rellena los tres menús laterales.
    try {
        const res = await fetch(rootPath + "backend/php/get_componentes.php");
        const data = await res.json();

        poblarMenu("forma", data.formas, menuCuerpos);
        poblarMenu("mastil", data.mastiles, menuMastiles);
        poblarMenu("pastillas", data.pastillas, menuPastillas);

    } catch {
        notyf.error("Error cargando componentes");
    }

    // Definimos función para poblar menús de selección de componentes
    // Genera visualmente cada menú de selección a partir de los datos recibidos.
    function poblarMenu(tipo, items, menu) {

        // Limpiamos menú antes de poblar
        menu.innerHTML = "";

        // Por cada componente, creamos una tarjeta con su imagen y nombre
        items.forEach(item => {

            const card = document.createElement("div");
            card.className = "tarjeta-componente";
            // Determinamos ID real, ruta del modelo 3D, imagen y nombre a mostrar según tipo de componente
            let idReal =
                tipo === "forma"
                    ? item.id_forma_color ?? item.id
                    : tipo === "mastil"
                        ? item.id_mastil ?? item.id
                        : item.id_pastilla_modelo ?? item.id;

            // Obteemos la ruta del modelo 3D
            let rutaModelo = item.referencia_glb ?? item.glb ?? null;

            // Obtenemos imagen a mostrar en la tarjeta
            let imagen =
                item.imagen ??
                item.imagen_pastillas ??
                item.img ??
                "";

            // Obtenemos nombre a mostrar en la tarjeta
            let nombre =
                item.nombre ??
                item.color ??
                item.tipo ??
                "pieza";

            // Construimos tarjeta
            // Construye una tarjeta sencilla con imagen y nombre de la pieza.
            card.innerHTML = `
                <img src="${rootPath + imagen}" alt="${nombre}">
                <span>${nombre}</span>
            `;

            // Cuando se hace click en la tarjeta, cargamos el modelo 3D correspondiente y guardamos la selección
            // Al seleccionar una tarjeta, carga su modelo y guarda su id para poder persistirlo después.
            card.onclick = () => {
                if (!idReal) return; // Si no hay ID, no hacemos nada
                cargarModelo(tipo, rutaModelo); // Llamamos a la función de carga del modelo con el loader
                idsComponentesSeleccionados[tipo] = idReal; // Asignamos el ID del componente seleccionado

            };

            menu.appendChild(card);

        });

    }

    // BOTON DE REINICIAR COMPONENTES
    // Devuelve el configurador al estado inicial y elimina todas las piezas montadas.
    if (btnReset) {
        btnReset.onclick = () => {
            scene.clear();
            crearIluminacion();

            Object.keys(idsComponentesSeleccionados)
                .forEach(k => idsComponentesSeleccionados[k] = null);

            Object.keys(piezasCargadas)
                .forEach(k => piezasCargadas[k] = null);

            camera.position.set(0, 0, 10);

            controls.target.set(0, 0, 0);
            controls.update();

            notyf.success("Diseño reseteado");

        };

    }

    // BOTON DE GUARDAR
    // Valida la configuración y la envía al backend para guardarla en el perfil del usuario.
    if (btnGuardar) {

        btnGuardar.onclick = async () => {
            if (!idsComponentesSeleccionados.forma || !idsComponentesSeleccionados.mastil || !idsComponentesSeleccionados.pastillas) {
                notyf.error("Selecciona todas las piezas antes de guardar");
                return;
            }

            // Definimos el payload con los IDs
            // Prepara solo los ids necesarios para que el backend reconstruya la guitarra.
            const payload = {
                id_forma_color: idsComponentesSeleccionados.forma,
                id_mastil: idsComponentesSeleccionados.mastil,
                id_pastilla_modelo: idsComponentesSeleccionados.pastillas
            };

            try {
                // Enviamos petición al backend para guardar la guitarra con los IDs seleccionados
                const response = await fetch(
                    rootPath + "backend/php/guardar_guitarra.php",
                    {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify(payload)
                    }
                );

                //Guardamos la imagen del renderer como PNG en formato base64
                // Interpreta la respuesta del backend y comunica el resultado al usuario.
                const resultado = await response.json();

                //Ajustes del notif
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

    // ANIMATE
    // Mantiene activo el renderizado continuo del visor 3D.
    function animar() {
        requestAnimationFrame(animar);
        controls.update();
        renderer.render(scene, camera);
    }
    animar();


    // MENÚS DE COMPONENTES
    // Relaciona cada botón superior con su submenú de componentes correspondiente.
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

    // Por cada botón, asignamos un evento de click que muestra el submenú correspondiente y oculta los demás
    // Hace que solo un submenú esté visible a la vez y reajusta el visor tras abrirlo.
    Object.keys(mapping).forEach(id => {

        // Obtenemos el botón y el submenú correspondiente a partir del mapping
        const btn = botones[id];
        const submenu = mapping[id];

        if (!btn) return;

        // Alternativamente mostrar/ocultar el submenú al hacer click en el botón
        btn.onclick = () => {

            const oculto = submenu.classList.contains("oculto");

            document.querySelectorAll(".grid-componentes").forEach(s => s.classList.add("oculto"));
            if (oculto){
                submenu.classList.remove("oculto");
            } 
            setTimeout(actualizarTamano, 50);
        };
    });
}

// Todas las "buenas practicas" como los return y demas componentes han sido proporcionadas por diversas
// IAs, para hacer el codigo mas practico y escalable.
