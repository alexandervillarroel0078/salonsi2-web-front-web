const especialidades = new Map();

// Obtener servicios desde el DOM
document.addEventListener("DOMContentLoaded", function () {
    const dataElement = document.getElementById("personal-data");
    const servicios = JSON.parse(dataElement.dataset.services || "[]");

    // Precargar servicios del personal
    servicios.forEach(servicio => {
        especialidades.set(servicio.id.toString(), servicio.name);
    });

    renderizarEspecialidades();
});

function agregarEspecialidad() {
    const select = document.getElementById("servicioSelect");
    const valor = select.value;
    const texto = select.options[select.selectedIndex].text;

    if (!especialidades.has(valor)) {
        especialidades.set(valor, texto);
        renderizarEspecialidades();
    }
}

function eliminarEspecialidad(valor) {
    especialidades.delete(valor);
    renderizarEspecialidades();
}

function renderizarEspecialidades() {
    const container = document.getElementById("serviciosSeleccionados");
    const hidden = document.getElementById("hiddenSpecialties");
    container.innerHTML = "";
    hidden.innerHTML = "";

    especialidades.forEach((texto, valor) => {
        const chip = document.createElement("span");
        chip.className = "badge bg-secondary text-white px-3 py-2 me-2 mb-2 d-inline-flex align-items-center rounded-pill";
        chip.innerHTML = `
            <span class="me-2">${texto}</span>
            <span style="cursor:pointer;" onclick="eliminarEspecialidad('${valor}')">&times;</span>
        `;
        container.appendChild(chip);

        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "specialties[]";
        input.value = valor;
        hidden.appendChild(input);
    });
}
