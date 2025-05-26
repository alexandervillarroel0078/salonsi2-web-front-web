@extends('layouts.ap') {{-- o el layout que uses --}}

@section('content')
<div class="container mt-4">
    <h3><i class="fas fa-question-circle text-primary"></i> Centro de Soporte</h3>
    <p class="mb-4">Encuentra aquí asistencia sobre el uso del sistema:</p>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="card-title">📘 Guía de usuario</h5>
            <p class="card-text">Puedes descargar la guía completa de uso del sistema en formato PDF.</p>
            <a href="#" class="btn btn-outline-primary">Descargar Guía</a>
        </div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <h5 class="card-title">📧 Contacto directo</h5>
            <p><strong>Email:</strong> soporte@salonapp.com</p>
            <p><strong>Teléfono:</strong> +591 70000000</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">❓ Preguntas Frecuentes (FAQ)</h5>

            <div class="accordion" id="faqAccordion">
                <!-- FAQ 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
                            ¿Cómo creo una nueva cita?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" aria-labelledby="faq1-heading" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Para crear una nueva cita, ve al módulo "Gestionar agenda" y presiona el botón <strong>+ Nueva Cita</strong>. Llena los campos requeridos y guarda.
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq2-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                            ¿Cómo exporto los datos?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faq2-heading" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            En cada módulo con tabla (como agenda o servicios), puedes seleccionar el formato de exportación (PDF, Excel, etc.) y hacer clic en el botón <strong>Exportar</strong>.
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq3-heading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                            ¿Qué hacer si olvido mi contraseña?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faq3-heading" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Haz clic en el enlace <strong>¿Olvidaste tu contraseña?</strong> en la pantalla de inicio de sesión. Recibirás un correo con instrucciones para restablecerla.
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
<div class="card shadow-sm mt-4">
    <div class="card-body">
        <h5 class="card-title">✉️ Deja tus comentarios o sugerencias</h5>
        <form>
            <div class="mb-3">
                <label for="comentario" class="form-label">¿Cómo podemos mejorar el sistema?</label>
                <textarea class="form-control" id="comentario" rows="4"
                          placeholder="Escribe aquí tus sugerencias, comentarios o problemas que encontraste..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar sugerencia</button>
        </form>
    </div>
</div>

</div>
@endsection