<?php
/**
 * Created by PhpStorm.
 * User: artem
 * Date: 04.09.17
 * Time: 18:38
 */




namespace app\models;

use yii\base\Model;
use Yii;
use app\components\debugger\Debugger;
use Dompdf\Dompdf;




class PrintPdf extends Model
{






    public function PrintPdf($html,$file_name)
    {
//  include("mpdf50/mpdf.php");
//  require_once(__DIR__ . '/../components/mpdf60/mpdf.php');
//  require_once(__DIR__ . '/../components/dompdf/autoload.inc.php');

        $dompdf = new Dompdf();// Создаем обьект
        $dompdf->load_html($html); // Загружаем в него наш html код
        $dompdf->render(); // Создаем из HTML PDF
        $dompdf->stream('bill_'.$file_name.'.pdf'); // Выводим результат (скачивание)
    }
}