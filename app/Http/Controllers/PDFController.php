namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function prueba()
    {
        $data = [
            'titulo' => 'Prueba de PDF en Hostinger',
            'mensaje' => 'Si ves este PDF, todo funciona correctamente.'
        ];

        return Pdf::loadView('pdf.prueba', $data)->download('prueba_hostinger.pdf');
    }
}
