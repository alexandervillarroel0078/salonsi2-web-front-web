// public/js/edit_agendas.js

const servicios = new Map();

document.addEventListener('DOMContentLoaded', () => {
    const dataDiv = document.getElementById('agenda-data');
    if (dataDiv) {
        try {
            const serviciosCargados = JSON.parse(dataDiv.dataset.servicios || '[]');
            serviciosCargados.forEach(servicio => {
                servicios.set(servicio.id.toString(), {
                    texto: servicio.name,
                    duracion: parseInt(servicio.duration_minutes),
                    precio: parseFloat(servicio.has_discount ? servicio.discount_price : servicio.price)
                });
            });
            renderizarServicios();
        } catch (error) {
            console.error("Error al parsear servicios:", error);
        }
    }
});

function agregarServicio() {
    const select = document.getElementById('servicioSelect');
    const valor = select.value;
    const texto = select.options[select.selectedIndex].text;
    const duracion = parseInt(select.options[select.selectedIndex].getAttribute('data-duration')) || 0;
    const precio = parseFloat(select.options[select.selectedIndex].getAttribute('data-price')) || 0;

    if (!servicios.has(valor)) {
        servicios.set(valor, { texto, duracion, precio });
        renderizarServicios();
    }
}

function eliminarServicio(valor) {
    servicios.delete(valor);
    renderizarServicios();
}

function renderizarServicios() {
    const container = document.getElementById('listaServicios');
    const hidden = document.getElementById('hiddenServicios');
    const duracionInput = document.getElementById('duracionTotal');
    const precioInput = document.getElementById('precio_total');

    container.innerHTML = '';
    hidden.innerHTML = '';

    let totalDuracion = 0;
    let totalPrecio = 0;

    servicios.forEach((data, valor) => {
        const chip = document.createElement('span');
        chip.className = 'badge bg-info text-white px-3 py-2 me-2 mb-2 rounded-pill d-inline-flex align-items-center';
        chip.innerHTML = `
            <span class="me-2">${data.texto}</span>
            <span style="cursor:pointer;" onclick="eliminarServicio('${valor}')">&times;</span>
        `;
        container.appendChild(chip);

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'servicios[]';
        input.value = valor;
        hidden.appendChild(input);

        totalDuracion += data.duracion;
        totalPrecio += data.precio;
    });

    if (duracionInput) duracionInput.value = totalDuracion;
    if (precioInput) precioInput.value = totalPrecio.toFixed(2);
}
