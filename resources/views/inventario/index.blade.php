@extends('layouts.ap')

@section('content')
<div class="container">
    <h4>Inventario Actual</h4>

    {{-- Mensajes de éxito o error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('inventario.create') }}" class="btn btn-primary mb-3">Registrar Movimiento</a>
    <a href="{{ route('inventario.movimientos') }}" class="btn btn-secondary mb-3">Ver Historial</a>

    {{-- Gráficos lado a lado --}}
    <div class="row mb-4 d-flex justify-content-center" style="gap: 0.5rem;">
        <div class="col-lg-6 col-md-12 text-center">
            <canvas id="inventarioChart"
                width="900" height="400"
                style="max-width: 98%; width: 100%; margin: auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px #ddd;">
            </canvas>
        </div>
        <div class="col-lg-6 col-md-12 text-center">
            <canvas id="categoriaPieChart"
                width="900" height="400"
                style="max-width: 98%; width: 100%; margin: auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px #ddd;">
            </canvas>
        </div>
    </div>
    {{-- Botón para exportar ambos gráficos --}}
    <div class="mb-4 text-center">
        <button id="exportBothCharts" class="btn btn-success btn-lg mt-2">Descargar ambos gráficos (PDF/PNG)</button>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>
                    {{ $producto->stock }}
                    @if($producto->stock <= $producto->stock_minimo)
                        <span class="badge bg-danger">¡Bajo!</span>
                        <span class="badge bg-warning text-dark">Reponer stock</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
        // Mapea productos como array plano (nombre, stock, categoría)
        const productos = @json($productos->map(function($p) {
            return [
                'nombre' => $p->nombre,
                'stock' => $p->stock,
                'categoria' => $p->categoria ?: 'Sin categoría'
            ];
        }));

        // ----- Gráfico de Barras (Stock por producto) -----
        const labels = productos.map(p => p.nombre);
        const dataStock = productos.map(p => Number(p.stock));
        const colores = [
            '#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40',
            '#69C9FF', '#B8FF33', '#E733FF', '#FF5733', '#33FFBD', '#FF33F6'
        ];

        const ctx = document.getElementById('inventarioChart').getContext('2d');
        const chartBar = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Stock Actual',
                    data: dataStock,
                    backgroundColor: colores,
                }]
            },
            options: {
                responsive: false, // NECESARIO para PDF nítido
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Inventario Actual por Producto' },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                return 'Stock: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });

        // ----- Gráfico de Pastel (Stock total por categoría) -----
        let categoriaStock = {};
        productos.forEach(p => {
            categoriaStock[p.categoria] = (categoriaStock[p.categoria] || 0) + Number(p.stock);
        });
        const categorias = Object.keys(categoriaStock);
        const dataCategorias = Object.values(categoriaStock);

        const ctxPie = document.getElementById('categoriaPieChart').getContext('2d');
        const chartPie = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: categorias,
                datasets: [{
                    label: 'Stock por Categoría',
                    data: dataCategorias,
                    backgroundColor: colores,
                }]
            },
            options: {
                responsive: false, // NECESARIO para PDF nítido
                plugins: {
                    title: { display: true, text: 'Inventario Total por Categoría' },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                return `${label}: ${value}`;
                            }
                        }
                    }
                }
            }
        });

        // --- Exportar ambos gráficos como PNG y PDF en un solo click ---
        document.getElementById('exportBothCharts').addEventListener('click', async function() {
            const barCanvas = document.getElementById('inventarioChart');
            const pieCanvas = document.getElementById('categoriaPieChart');
            const barDataUrl = barCanvas.toDataURL("image/png");
            const pieDataUrl = pieCanvas.toDataURL("image/png");

            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF({
                orientation: 'landscape',
                unit: 'mm',
                format: 'a4'
            });

            pdf.setFontSize(18);
            pdf.text('Gráficos de Inventario', 148, 15, { align: 'center' });

            pdf.setFontSize(14);
            pdf.text('Por Producto', 40, 28);
            pdf.text('Por Categoría', 210, 28);

            pdf.addImage(barDataUrl, 'PNG', 10, 30, 135, 60);   // (x, y, w, h)
            pdf.addImage(pieDataUrl, 'PNG', 150, 30, 135, 60);

            pdf.save('graficos_inventario.pdf');

            
            const link1 = document.createElement('a');
            link1.href = barDataUrl;
            link1.download = "inventario_por_producto.png";
            link1.click();

            const link2 = document.createElement('a');
            link2.href = pieDataUrl;
            link2.download = "inventario_por_categoria.png";
            link2.click();
            
        });
    </script>
</div>
@endsection
