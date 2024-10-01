<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Venta_model'); // Cargar el modelo de ventas
        $this->load->library('pdf'); // Cargar la librería PDF (Pdf.php)
    }

    public function index() {
        // Aquí puedes obtener datos si es necesario
        // $data['ventas'] = $this->Modelo_reporte->obtener_ventas(); // Ejemplo de carga de datos

        // Cargar las vistas
        $this->load->view('admin/template/header');
        $this->load->view('admin/template/navbar');
        $this->load->view('admin/template/sidebar');
        $this->load->view('admin/reportes'); // Tu vista de reportes
        $this->load->view('admin/template/footer');
    }

    public function generar_pdf() {
        // Obtener fechas del formulario
        $fecha_inicio = $this->input->get('fecha_inicio_ventas');
        $fecha_fin = $this->input->get('fecha_fin_ventas');
    
        // Obtener los datos de ventas del modelo
        $data['ventas'] = $this->Venta_model->get_ventas_by_fecha($fecha_inicio, $fecha_fin);
        
        // Pasar las fechas a la vista
        $data['fecha_inicio'] = $fecha_inicio;
        $data['fecha_fin'] = $fecha_fin;
    
        // Cargar la vista del reporte en una variable
        $html = $this->load->view('admin/pdf/reporte_ventas_fecha', $data, true);
    
        // Usar las funciones de DOMPDF a través de la clase heredada en Pdf.php
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait'); // Tamaño y orientación del papel
        $this->pdf->render(); // Renderizar el PDF
    
        // Abrir el PDF en el navegador
        $this->pdf->stream('reporte_ventas_' . $fecha_inicio . '_al_' . $fecha_fin . '.pdf', array("Attachment" => 0));
    }
       
}
