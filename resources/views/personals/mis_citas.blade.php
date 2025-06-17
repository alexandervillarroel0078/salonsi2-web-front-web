@extends('layouts.ap') {{-- o tu layout principal --}}

@section('content')
<div class="container">
    <h1 class="mb-4">Mis Citas Asignadas Personals</h1>

    @if($agendas->isEmpty())
    <div class="alert alert-info">No tienes citas asignadas.</div>
    @else
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Cliente(s)</th>
                    <th>Servicios</th>
                    <th>Tipo de Atención</th>
                    <th>Ubicación</th>
                    <th>Notas</th>
                    <th>Duración</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($agendas as $agenda)
                <tr>
                    <td>{{ $agenda->codigo }}</td>
                    <td>{{ $agenda->fecha }}</td>
                    <td>{{ $agenda->hora }}</td>
                    <td>
                        @php $cli = $agenda->clientes->first(); @endphp
                        {{ $cli?->name ?? '—' }}
                    </td>
                    <td>
                        @foreach($agenda->servicios as $servicio)
                        {{ $servicio->name }} (x{{ $servicio->pivot->cantidad }})<br>
                        @endforeach
                    </td>
                    <td>{{ ucfirst($agenda->tipo_atencion) }}</td>
                    <td>{{ $agenda->ubicacion }}</td>
                    <td>{{ $agenda->notas }}</td>
                    <td>{{ $agenda->duracion }} min</td>
                    <td>{{ ucfirst($agenda->estado) }}</td>
                    <td>
                        <a href="{{ route('personals.citas.show', $agenda->id) }}" class="btn btn-sm btn-primary">
                            Ver detalle
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
<!-- Modal para finalizar servicio -->
<div class="modal fade" id="finalizarModal" tabindex="-1" aria-labelledby="finalizarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="formFinalizar">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Finalizar Servicio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="agenda_id" id="modal_agenda_id">
                <input type="hidden" name="servicio_id" id="modal_servicio_id">

                <div class="form-group">
                    <label for="valoracion">Valoración</label>
                    <select class="form-control" name="valoracion" id="valoracion">
                        <option value="">Sin valoración</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} ⭐</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label for="comentario">Comentario</label>
                    <textarea class="form-control" name="comentario" id="comentario" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Finalizar</button>
            </div>
        </div>
    </form>
  </div>
</div>
