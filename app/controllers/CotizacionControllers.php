<?php

namespace App\Controllers;

use App\Models\Quotation;
use Core\Controller;

class CotizacionControllers extends Controller {

    public function mostrarVista() {
        $model = new Quotation();
        $data = $model->getQuotationList();

        $this->render('quation/view_medical_summary', ['data' => $data]); 
    }

    public function getData() {
        header('Content-Type: application/json');

        $model = new Quotation();

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        echo json_encode($model->getQuotationData($id));
    }
}
