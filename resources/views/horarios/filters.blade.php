<form action="{{ route('horarios.index') }}" method="GET" class="mb-4">
    <div class="row g-3 align-items-center">

        {{-- Buscar por fecha --}}
        <div class="col-md-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ request('fecha') }}">
        </div>

        {{-- Filtrar por personal --}}
        <div class="col-md-3">
            <label for="personal_id" class="form-label">Personal</label>
            <select name="personal_id" id="personal_id" class="form-select">
                <option value="">Todos</option>
                @foreach ($personals as $personal)
                    <option value="{{ $personal->id }}" {{ request('personal_id') == $personal->id ? 'selected' : '' }}>
                        {{ $personal->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Filtrar por disponibilidad --}}
        <div class="col-md-3">
            <label for="disponible" class="form-label">Disponible</label>
            <select name="disponible" id="disponible" class="form-select">
                <option value="">Todos</option>
                <option value="1" {{ request('disponible') === '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ request('disponible') === '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        {{-- Botón --}}
        <div class="col-md-3 mt-4">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{ route('horarios.index') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </div>
</form>
