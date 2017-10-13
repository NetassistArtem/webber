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
      //  $bp = '/home/artem/public_html/test08/basic/web/img/';

      //  $dompdf->setBasePath($bp);
       // $dompdf = new Dompdf(array('enable_remote' => true));
       // $dompdf = new Dompdf(array('ENABLE_AUTOLOAD' => true));
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_base_path('/home/artem/public_html/test08/basic/web/');
        //$dompdf->set_base_path('/var/www/webbernu/data/www/invoice.webber.net.ua/basic/web/');
        $dompdf->set_option('defaultPaperSize', 'a4');
        //$dompdf->set_option('chroot', $bp);
      //  $dompdf->set_option('logOutputFile', 'print');
        $dompdf->load_html($html); // Загружаем в него наш html код
        $dompdf->render(); // Создаем из HTML PDF
        $dompdf->stream($file_name.'.pdf'); // Выводим результат (скачивание)
    }
}