<?php
require_once APPPATH . 'libraries/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Pdf extends Dompdf {
    public function __construct() {
        parent::__construct();
    }
}
