@extends('layouts.ap')

@section('content')
<div class="container">
    <h3>Confirmar y calificar servicios</h3>

    <form method="POST" action="{{ route('cliente.agenda.confirmar.guardar', $agenda->id) }}">

        @csrf

        @foreach($agenda->servicios as $servicio)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $servicio->name }} -
                    <small class="text-muted">
                        Especialista:
                        {{
                                \App\Models\Personal::find($servicio->pivot->personal_id)?->name ?? 'Sin asignar'
                            }}
                    </small>
                </h5>

                <label>Calificación (1-5):</label>
                <select name="valoraciones[{{ $servicio->id }}]" class="form-select mb-2">
                    <option value="">⭐</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}⭐</option>
                        @endfor
                </select>
                <label>Comentario:</label>
                <textarea
                    name="comentarios[{{ $servicio->id }}]"
                    class="form-control"
                    placeholder="Comentario sobre el servicio..."></textarea>
            </div>
        </div>
        @endforeach

        <button type="submit" class="btn btn-success">Confirmar y finalizar cita</button>
    </form>
</div>
@endsection