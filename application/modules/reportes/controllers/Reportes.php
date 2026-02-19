<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once(FCPATH.'vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Reportes extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("reportes_model");
		$this->load->model("general_model");
		$this->load->helper('form');
    }

	/**
	 * Gestion de Turnos
	 */
	public function attentionTurns()
	{
		$arrParam = array(
			'from' => date('Y-m-d'),
			'to' => date('Y-m-d')
		);			
		$data['listaTurnos'] = $this->reportes_model->get_turnos($arrParam);
		$data['noTurnosHOY'] = $data['listaTurnos']?count($data['listaTurnos']):0;
		if (date('D')=='Mon'){
		     $lunes = date('Y-m-d');
		} else {
		     $lunes = date('Y-m-d', strtotime('last Monday', time()));
		}
		$domingo = strtotime('next Sunday', time());
		$domingo = date('Y-m-d', $domingo);
		$domingo = date('Y-m-d',strtotime ('+1 day ', strtotime($domingo)));
		$arrParam = array(
			'from' => $lunes,
			'to' => $domingo
		);
		$data['listaTurnosSEMANA'] = $this->reportes_model->get_turnos($arrParam);
		$data['noTurnosSEMANA'] = $data['listaTurnosSEMANA']?count($data['listaTurnosSEMANA']):0;
		$month_start = strtotime('first day of this month', time());
		$month_start = date('Y-m-d', $month_start);
		$month_end = strtotime('last day of this month', time());
		$month_end = date('Y-m-d', $month_end);
		$month_end = date('Y-m-d',strtotime ('+1 day ', strtotime($month_end)));
		$arrParam = array(
			'from' => $month_start,
			'to' => $month_end
		);
		$data['listaTurnosMES'] = $this->reportes_model->get_turnos($arrParam);
		$data['noTurnosMES'] = $data['listaTurnosMES']?count($data['listaTurnosMES']):0;
		$data["view"] = "reports_turns";
		$this->load->view("layout_calendar2", $data);
	}

	/**
     * Modal Buscar Turnos x Fecha
     */
    public function modalTurnosFecha() 
	{
		header("Content-Type: text/plain; charset=utf-8");
		$this->load->view('modal_turnos_fecha');
    }
	
	/**
	 * Lista de Turnos x Fecha
	 */
	public function buscarTurnosFecha()
	{
		$data['from'] = $this->input->post('from');
		$data['to'] = $this->input->post('to');
		$arrParam = array(
			'from' => $data['from'],
			'to' => $data['to']
		);
		$data['listaTurnos'] = $this->reportes_model->get_turnos($arrParam);
		$data["view"] ='buscar_turnos_fecha';
		$this->load->view("layout_calendar2", $data);
	}

    /**
	 * Generar Reporte Turnos XLS
	 */
    public function generarReporteTurnosXLS()
	{
		$bandera = $this->input->post('bandera');
		if($bandera == 1) {
			$from = date('Y-m-d');
			$to = date('Y-m-d');
			$nombreArchivo = 'reporte_turnos_' . $from . '.xlsx';
		} else {
			$from = $this->input->post('from');
			$to = $this->input->post('to');
			$nombreArchivo = 'reporte_turnos_' . $from . '_' . $to . '.xlsx';
		}
		$arrParam = array(
			'from' => $from,
			'to' => $to
		);
		$listaTurnos = $this->reportes_model->get_turnos($arrParam);
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle('Reporte Turnos');
		$img1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$img1->setPath('images/logo_alcaldia.png');
		$img1->setCoordinates('A1');
		$img1->setOffsetX(25);
		$img1->setOffsetY(10);
		$img1->setWorksheet($spreadsheet->getActiveSheet());
		$img2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$img2->setPath('images/logo_bogota.png');
		$img2->setCoordinates('L1');
		$img2->setOffsetX(10);
		$img2->setOffsetY(10);
		$img2->setWorksheet($spreadsheet->getActiveSheet());
		$spreadsheet->getActiveSheet()->mergeCells('A1:A5');
		$spreadsheet->getActiveSheet()->mergeCells('L1:L5');
		$spreadsheet->getActiveSheet()->mergeCells('B1:K1');
		$spreadsheet->getActiveSheet()->mergeCells('B2:K2');
		$spreadsheet->getActiveSheet()->mergeCells('B3:K3');
		$spreadsheet->getActiveSheet()->mergeCells('B4:D4');
		$spreadsheet->getActiveSheet()->mergeCells('E4:G4');
		$spreadsheet->getActiveSheet()->mergeCells('H4:I4');
		$spreadsheet->getActiveSheet()->mergeCells('J4:K4');
		$spreadsheet->getActiveSheet()->mergeCells('B5:D5');
		$spreadsheet->getActiveSheet()->mergeCells('E5:G5');
		$spreadsheet->getActiveSheet()->mergeCells('H5:I5');
		$spreadsheet->getActiveSheet()->mergeCells('J5:K5');
		$spreadsheet->getActiveSheet(0)
							->setCellValue('B1', 'MANUAL DE PROCESOS Y PROCEDIMIENTOS')
							->setCellValue('B2', 'SAC - SERVICIO AL CIUDADANO')
							->setCellValue('B3', 'FORMATO PLANILLA REGISTRO DIGITURNOS')
							->setCellValue('B4', 'Código:')
							->setCellValue('E4', 'Versión:')
							->setCellValue('H4', 'Fecha:')
							->setCellValue('J4', 'Página:')
							->setCellValue('B5', 'SAC.PR.01.F.03')
							->setCellValue('E5', '1')
							->setCellValue('H5', '14/03/2022')
							->setCellValue('J5', '1 de 1');
		$spreadsheet->getActiveSheet(0)
							->setCellValue('A7', 'Fecha')
							->setCellValue('B7', 'Visitante')
							->setCellValue('C7', 'Tipo Servicio')
							->setCellValue('D7', 'Categoria')
							->setCellValue('E7', 'Turno')
							->setCellValue('F7', 'Estado')
							->setCellValue('G7', 'Asesor')
							->setCellValue('H7', 'Encuesta')
							->setCellValue('I7', 'Fecha Espera')
							->setCellValue('J7', 'Fecha Llamado')
							->setCellValue('K7', 'Fecha Atención')
							->setCellValue('L7', 'Fecha Finalización');
		$j=8;
		if($listaTurnos){
			foreach ($listaTurnos as $lista):
				$servicio = $lista['id_tipo_servicio']!=99?$lista['tipo_servicio']:$lista['servicio_cual'];
				$encuesta = $lista['encuesta']==1?"Si":"No";
				$spreadsheet->getActiveSheet()->getStyle('A'.$j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
				$spreadsheet->getActiveSheet()->getStyle('D'.$j.':F'.$j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
				$spreadsheet->getActiveSheet()->getStyle('H'.$j.':L'.$j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
				$spreadsheet->getActiveSheet()
							->setCellValue('A'.$j, $lista['fecha'])
							->setCellValue('B'.$j, $lista['nombres'] . ' ' . $lista['apellidos'])
							->setCellValue('C'.$j, $servicio)
							->setCellValue('D'.$j, $lista['categoria'])
							->setCellValue('E'.$j, $lista['turno'])
							->setCellValue('F'.$j, $lista['estado_turno'])
							->setCellValue('G'.$j, $lista['first_name'] . ' ' . $lista['last_name'])
							->setCellValue('H'.$j, $encuesta)
							->setCellValue('I'.$j, $lista['fecha_espera'])
							->setCellValue('J'.$j, $lista['fecha_llamado'])
							->setCellValue('K'.$j, $lista['fecha_atencion'])
							->setCellValue('L'.$j, $lista['fecha_finalizacion']);
				$j++;
			endforeach;
		}
		// Set column widths
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(10);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(40);
		// Set fonts
		$spreadsheet->getActiveSheet()->getStyle('B1:K3')->getFont()->setSize(14);
		$spreadsheet->getActiveSheet()->getStyle('B1:K3')->getFont()->setBold(true);
 		$spreadsheet->getActiveSheet()->getStyle('B1:K3')->getFill()->setFillType(Fill::FILL_SOLID);
 		$spreadsheet->getActiveSheet()->getStyle('B1:K3')->getFill()->getStartColor()->setARGB('236e09');
 		$spreadsheet->getActiveSheet()->getStyle('B1:K3')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$spreadsheet->getActiveSheet()->getStyle('B1:K3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B1:K3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B4:K5')->getFont()->setSize(11);
		$spreadsheet->getActiveSheet()->getStyle('B4:K5')->getFont()->setBold(true);
 		$spreadsheet->getActiveSheet()->getStyle('B4:K5')->getFill()->setFillType(Fill::FILL_SOLID);
 		$spreadsheet->getActiveSheet()->getStyle('B4:K5')->getFill()->getStartColor()->setARGB('236e09');
 		$spreadsheet->getActiveSheet()->getStyle('B4:K5')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$spreadsheet->getActiveSheet()->getStyle('B4:K5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B4:K5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A7:L7')->getFont()->setSize(11);
		$spreadsheet->getActiveSheet()->getStyle('A7:L7')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A7:L7')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
 		$spreadsheet->getActiveSheet()->getStyle('A7:L7')->getFill()->setFillType(Fill::FILL_SOLID);
		$spreadsheet->getActiveSheet()->getStyle('A7:L7')->getFill()->getStartColor()->setARGB('808080');
		$spreadsheet->getActiveSheet()->getStyle('A7:L7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A7:L7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('7')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('8')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getStyle('A1:L5')->applyFromArray(
		    [
		        'borders' => [
		            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
		        ],
		    ]
		);
		$spreadsheet->getActiveSheet()->getStyle('A7:L7')->applyFromArray(
		    [
		        'borders' => [
		            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
		        ],
		    ]
		);
		$spreadsheet->getActiveSheet()->getStyle('A1:A5')->applyFromArray(
		    [
			    'alignment' => [
			        'wrapText' => TRUE
			    ]
		    ]
		);
		ob_end_clean();
		header('Content-Type:application/vnd.ms-excel');
		header('Content-Disposition:attachment;filename=' . $nombreArchivo);
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

    /**
	 * Atencion al Ciudadano
	 */
	public function attentionCitizen()
	{
		$arrParam = array(
			'from' => date('Y-m-d'),
			'to' => date('Y-m-d')
		);			
		$data['listaAtencion'] = $this->reportes_model->get_atencion($arrParam);
		$data['noAtencionHOY'] = $data['listaAtencion']?count($data['listaAtencion']):0;
		if (date('D')=='Mon'){
		     $lunes = date('Y-m-d');
		} else {
		     $lunes = date('Y-m-d', strtotime('last Monday', time()));
		}
		$domingo = strtotime('next Sunday', time());
		$domingo = date('Y-m-d', $domingo);
		$domingo = date('Y-m-d',strtotime ('+1 day ', strtotime($domingo)));
		$arrParam = array(
			'from' => $lunes,
			'to' => $domingo
		);
		$data['listaAtencionSEMANA'] = $this->reportes_model->get_atencion($arrParam);
		$data['noAtencionSEMANA'] = $data['listaAtencionSEMANA']?count($data['listaAtencionSEMANA']):0;
		$month_start = strtotime('first day of this month', time());
		$month_start = date('Y-m-d', $month_start);
		$month_end = strtotime('last day of this month', time());
		$month_end = date('Y-m-d', $month_end);
		$month_end = date('Y-m-d',strtotime ('+1 day ', strtotime($month_end)));
		$arrParam = array(
			'from' => $month_start,
			'to' => $month_end
		);
		$data['listaAtencionMES'] = $this->reportes_model->get_atencion($arrParam);
		$data['noAtencionMES'] = $data['listaAtencionMES']?count($data['listaAtencionMES']):0;
		$data["view"] = "reports_attention";
		$this->load->view("layout_calendar2", $data);
	}

	/**
     * Modal Buscar Atencion x Fecha
     */
    public function modalAtencionFecha() 
	{
		header("Content-Type: text/plain; charset=utf-8");
		$this->load->view('modal_atencion_fecha');
    }
	
	/**
	 * Lista de Atencion x Fecha
	 */
	public function buscarAtencionFecha()
	{
		$data['from'] = $this->input->post('from');
		$data['to'] = $this->input->post('to');
		$arrParam = array(
			'from' => $data['from'],
			'to' => $data['to']
		);
		$data['listaAtencion'] = $this->reportes_model->get_atencion($arrParam);
		$data["view"] ='buscar_atencion_fecha';
		$this->load->view("layout_calendar2", $data);
	}

	/**
	 * Generar Reporte Atencion XLS
	 */
    public function generarReporteAtencionXLS()
	{
		$bandera = $this->input->post('bandera');
		if($bandera == 1) {
			$from = date('Y-m-d');
			$to = date('Y-m-d');
			$nombreArchivo = 'reporte_atencion_' . $from . '.xlsx';
		} else {
			$from = $this->input->post('from');
			$to = $this->input->post('to');
			$nombreArchivo = 'reporte_atencion_' . $from . '_' . $to . '.xlsx';
		}
		$arrParam = array(
			'from' => $from,
			'to' => $to
		);
		$listaAtencion = $this->reportes_model->get_atencion($arrParam);
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle('Reporte Atención');
		$img1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$img1->setPath('images/logo_alcaldia.png');
		$img1->setCoordinates('A1');
		$img1->setOffsetX(25);
		$img1->setOffsetY(10);
		$img1->setWorksheet($spreadsheet->getActiveSheet());
		$img2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$img2->setPath('images/logo_bogota.png');
		$img2->setCoordinates('O1');
		$img2->setOffsetX(10);
		$img2->setOffsetY(10);
		$img2->setWorksheet($spreadsheet->getActiveSheet());
		$spreadsheet->getActiveSheet()->mergeCells('A1:A5');
		$spreadsheet->getActiveSheet()->mergeCells('O1:O5');
		$spreadsheet->getActiveSheet()->mergeCells('B1:N1');
		$spreadsheet->getActiveSheet()->mergeCells('B2:N2');
		$spreadsheet->getActiveSheet()->mergeCells('B3:N3');
		$spreadsheet->getActiveSheet()->mergeCells('B4:E4');
		$spreadsheet->getActiveSheet()->mergeCells('F4:H4');
		$spreadsheet->getActiveSheet()->mergeCells('I4:K4');
		$spreadsheet->getActiveSheet()->mergeCells('L4:N4');
		$spreadsheet->getActiveSheet()->mergeCells('B5:E5');
		$spreadsheet->getActiveSheet()->mergeCells('F5:H5');
		$spreadsheet->getActiveSheet()->mergeCells('I5:K5');
		$spreadsheet->getActiveSheet()->mergeCells('L5:N5');
		$spreadsheet->getActiveSheet()->mergeCells('A6:B7');
		$spreadsheet->getActiveSheet()->mergeCells('C6:D6');
		$spreadsheet->getActiveSheet()->mergeCells('E6:F6');
		$spreadsheet->getActiveSheet()->mergeCells('G6:H6');
		$spreadsheet->getActiveSheet()->mergeCells('I6:J6');
		$spreadsheet->getActiveSheet()->mergeCells('C7:D7');
		$spreadsheet->getActiveSheet()->mergeCells('E7:F7');
		$spreadsheet->getActiveSheet()->mergeCells('G7:H7');
		$spreadsheet->getActiveSheet()->mergeCells('I7:J7');
		$spreadsheet->getActiveSheet()->mergeCells('A8:B9');
		$spreadsheet->getActiveSheet()->mergeCells('C8:D8');
		$spreadsheet->getActiveSheet()->mergeCells('E8:F8');
		$spreadsheet->getActiveSheet()->mergeCells('G8:H8');
		$spreadsheet->getActiveSheet()->mergeCells('I8:J8');
		$spreadsheet->getActiveSheet()->mergeCells('C9:D9');
		$spreadsheet->getActiveSheet()->mergeCells('E9:F9');
		$spreadsheet->getActiveSheet()->mergeCells('G9:H9');
		$spreadsheet->getActiveSheet()->mergeCells('I9:J9');
		$spreadsheet->getActiveSheet()->mergeCells('K6:O9');
		$spreadsheet->getActiveSheet()->getStyle('C9:J9')->getNumberFormat()->setFormatCode('hh:mm:ss');
		$spreadsheet->getActiveSheet(0)
							->setCellValue('B1', 'MANUAL DE PROCESOS Y PROCEDIMIENTOS')
							->setCellValue('B2', 'SAC - SERVICIO AL CIUDADANO')
							->setCellValue('B3', 'FORMATO PLANILLA REGISTRO ATENCIÓN DIARIA DE CIUDADANOS')
							->setCellValue('B4', 'Código:')
							->setCellValue('F4', 'Versión:')
							->setCellValue('I4', 'Fecha:')
							->setCellValue('L4', 'Página:')
							->setCellValue('B5', 'SAC.PR.01.F.03')
							->setCellValue('F5', '1')
							->setCellValue('I5', '14/03/2022')
							->setCellValue('L5', '1 de 1')
							->setCellValue('A6', 'TOTAL REGISTROS POR CANAL')
							->setCellValue('C6', 'Atención Presencial')
							->setCellValue('E6', 'Atención Teléfono')
							->setCellValue('G6', 'Atención Celular')
							->setCellValue('I6', 'Atención WhatsApp')
							->setCellValue('K6', 'ATENCIÓN AL CIUDADANO')
							->setCellValue('C7','=COUNTIF(I:I,"X")') 
							->setCellValue('E7','=COUNTIF(J:J,"X")')
							->setCellValue('G7','=COUNTIF(K:K,"X")')
							->setCellValue('I7','=COUNTIF(L:L,"X")')
							->setCellValue('A8', 'INDICADOR DE TIEMPO POR CANAL')
							->setCellValue('C8', 'Atención Presencial')
							->setCellValue('E8', 'Atención Teléfono')
							->setCellValue('G8', 'Atención Celular')
							->setCellValue('I8', 'Atención WhatsApp')
							->setCellValue('C9','=SUMIF(I:I,"X",D:D)')
							->setCellValue('E9','=SUMIF(J:J,"X",D:D)')
							->setCellValue('G9','=SUMIF(K:K,"X",D:D)')
							->setCellValue('I9','=SUMIF(L:L,"X",D:D)');
		$spreadsheet->getActiveSheet(0)
							->setCellValue('A11', 'Fecha')
							->setCellValue('B11', 'Inicio Atención')
							->setCellValue('C11', 'Fin Atención')
							->setCellValue('D11', 'Indicador')
							->setCellValue('E11', 'Asesor')
							->setCellValue('F11', 'Ciudadano')
							->setCellValue('G11', 'Telefono')
							->setCellValue('H11', 'Asunto')
							->setCellValue('I11', 'Atención Presencial')
							->setCellValue('J11', 'Atención Telefónica')
							->setCellValue('K11', 'Atención Celular')
							->setCellValue('L11', 'Atención WhatsApp')
							->setCellValue('M11', 'Respuesta Inmediata')
							->setCellValue('N11', 'Traslado a Dependencia')
							->setCellValue('O11', 'Genero');
		$j=12;
		if($listaAtencion){
			foreach ($listaAtencion as $lista):
				if (!empty($lista['fk_id_visitante'])) {
                    $ciudadano = $lista['nombres'] . ' ' . $lista['apellidos'];
                    $telefono = $lista['telefono'];
                    $genero = $lista['genero'];
                } else {
                    $ciudadano = $lista['nombre'] . ' ' . $lista['apellido'];
                    $telefono = $lista['phone'];
                    $genero = $lista['genero1'];
                }
				$inicio = explode(" ", $lista['fecha_atencion']);
				$final = explode(" ", $lista['fecha_finalizacion']);
				$asunto = $lista['id_tipo_servicio']!=99?$lista['tipo_servicio']:$lista['servicio_cual'];
				$presencial = $telefonica = $celular = $whatsapp = $inmediata = $traslado = "";
				if($lista['id_tipo_atencion'] == 1) {
					$presencial = "X";
				} else if ($lista['id_tipo_atencion'] == 2) {
					$telefonica = "X";
				} else if ($lista['id_tipo_atencion'] == 3) {
					$celular = "X";
				} else if ($lista['id_tipo_atencion'] == 4) {
					$whatsapp = "X";
				}
				if($lista['id_solucion'] == 1) {
					$inmediata = "X";
				} else if ($lista['id_solucion'] == 2) {
					$traslado = "X";
				}
				$spreadsheet->getActiveSheet()->getStyle('A'.$j.':D'.$j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
				$spreadsheet->getActiveSheet()->getStyle('G'.$j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
				$spreadsheet->getActiveSheet()->getStyle('I'.$j.':N'.$j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
				$spreadsheet->getActiveSheet()->getStyle('B'.$j.':D'.$j)->getNumberFormat()->setFormatCode('hh:mm:ss');
				$spreadsheet->getActiveSheet()
							->setCellValue('A'.$j, $lista['fecha'])
							->setCellValue('B'.$j, $inicio[1])
							->setCellValue('C'.$j, $final[1])
							->setCellValue('D'.$j, '=TIMEVALUE(C'.$j.')-TIMEVALUE(B'.$j.')')
							->setCellValue('E'.$j, $lista['first_name'] . ' ' . $lista['last_name'])
							->setCellValue('F'.$j, $ciudadano)
							->setCellValue('G'.$j, $telefono)
							->setCellValue('H'.$j, $asunto)
							->setCellValue('I'.$j, $presencial)
							->setCellValue('J'.$j, $telefonica)
							->setCellValue('K'.$j, $celular)
							->setCellValue('L'.$j, $whatsapp)
							->setCellValue('M'.$j, $inmediata)
							->setCellValue('N'.$j, $traslado)
							->setCellValue('O'.$j, $genero);
				$j++;
			endforeach;
		}
		// Set column widths
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
		$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(25);
		$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(40);
		// Set fonts
		$spreadsheet->getActiveSheet()->getStyle('B1:N3')->getFont()->setSize(14);
		$spreadsheet->getActiveSheet()->getStyle('B1:N3')->getFont()->setBold(true);
 		$spreadsheet->getActiveSheet()->getStyle('B1:N3')->getFill()->setFillType(Fill::FILL_SOLID);
 		$spreadsheet->getActiveSheet()->getStyle('B1:N3')->getFill()->getStartColor()->setARGB('236e09');
 		$spreadsheet->getActiveSheet()->getStyle('B1:N3')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$spreadsheet->getActiveSheet()->getStyle('B1:N3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B1:N3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B4:N5')->getFont()->setSize(11);
		$spreadsheet->getActiveSheet()->getStyle('B4:N5')->getFont()->setBold(true);
 		$spreadsheet->getActiveSheet()->getStyle('B4:N5')->getFill()->setFillType(Fill::FILL_SOLID);
 		$spreadsheet->getActiveSheet()->getStyle('B4:N5')->getFill()->getStartColor()->setARGB('236e09');
 		$spreadsheet->getActiveSheet()->getStyle('B4:N5')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
		$spreadsheet->getActiveSheet()->getStyle('B4:N5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('B4:N5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A6:J7')->getFont()->setSize(11);
		$spreadsheet->getActiveSheet()->getStyle('A6:J7')->getFont()->setBold(true);
 		$spreadsheet->getActiveSheet()->getStyle('A6:J7')->getFill()->setFillType(Fill::FILL_SOLID);
 		$spreadsheet->getActiveSheet()->getStyle('A6:J7')->getFill()->getStartColor()->setARGB('d4efdf');
		$spreadsheet->getActiveSheet()->getStyle('A6:J7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A6:J7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('K6')->getFont()->setSize(20);
		$spreadsheet->getActiveSheet()->getStyle('K6')->getFont()->setBold(true);
 		$spreadsheet->getActiveSheet()->getStyle('K6')->getFill()->setFillType(Fill::FILL_SOLID);
		$spreadsheet->getActiveSheet()->getStyle('K6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('K6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A8:J9')->getFont()->setSize(11);
		$spreadsheet->getActiveSheet()->getStyle('A8:J9')->getFont()->setBold(true);
 		$spreadsheet->getActiveSheet()->getStyle('A8:J9')->getFill()->setFillType(Fill::FILL_SOLID);
 		$spreadsheet->getActiveSheet()->getStyle('A8:J9')->getFill()->getStartColor()->setARGB('d6eaf8');
		$spreadsheet->getActiveSheet()->getStyle('A8:J9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A8:J9')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A11:O11')->getFont()->setSize(11);
		$spreadsheet->getActiveSheet()->getStyle('A11:O11')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A11:O11')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
 		$spreadsheet->getActiveSheet()->getStyle('A11:O11')->getFill()->setFillType(Fill::FILL_SOLID);
		$spreadsheet->getActiveSheet()->getStyle('A11:O11')->getFill()->getStartColor()->setARGB('808080');
		$spreadsheet->getActiveSheet()->getStyle('A11:O11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A11:O11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('7')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('8')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('9')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('10')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('11')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getStyle('A1:O9')->applyFromArray(
		    [
		        'borders' => [
		            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
		        ],
		    ]
		);
		$spreadsheet->getActiveSheet()->getStyle('A11:O11')->applyFromArray(
		    [
		        'borders' => [
		            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
		        ],
		    ]
		);
		$spreadsheet->getActiveSheet()->getStyle('A1:A5')->applyFromArray(
		    [
			    'alignment' => [
			        'wrapText' => TRUE
			    ]
		    ]
		);
		ob_end_clean();
		header('Content-Type:application/vnd.ms-excel');
		header('Content-Disposition:attachment;filename=' . $nombreArchivo);
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}





	/**
	 * Generar Reporte Funcionarios
	 */
    public function employees()
	{
		$listaFuncionarios = $this->reportes_model->get_employees();
		$nombreArchivo = 'reporte_funcionarios.xlsx';
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle('Reporte Funcionarios');
		$spreadsheet->getActiveSheet(0)
							->setCellValue('A1', 'Tipo Documento')
							->setCellValue('B1', 'Número Documento')
							->setCellValue('C1', 'Nombres')
							->setCellValue('D1', 'Apellidos')
							->setCellValue('E1', 'Tipo Funcionario')
							->setCellValue('F1', 'Cargo')
							->setCellValue('G1', 'Correo Electrónico')
							->setCellValue('H1', 'Teléfono')
							->setCellValue('I1', 'Fecha Entrada')
							->setCellValue('J1', 'Fecha Salida');
		$j=2;
		if($listaFuncionarios){
			foreach ($listaFuncionarios as $lista):
				$spreadsheet->getActiveSheet()
							->setCellValue('A'.$j, $lista['tipo_documento'])
							->setCellValue('B'.$j, $lista['numero_documento'])
							->setCellValue('C'.$j, $lista['nombres'])
							->setCellValue('D'.$j, $lista['apellidos'])
							->setCellValue('E'.$j, $lista['tipo_funcionario'])
							->setCellValue('F'.$j, $lista['cargo'])
							->setCellValue('G'.$j, $lista['correo'])
							->setCellValue('H'.$j, $lista['telefono'])
							->setCellValue('I'.$j, $lista['fecha_entrada'])
							->setCellValue('J'.$j, $lista['fecha_finaliza']);
				$j++;
			endforeach;
		}
		// Set column widths
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(40);
		// Set fonts
		$spreadsheet->getActiveSheet()->getStyle('A1:J1')->getFont()->setSize(11);
		$spreadsheet->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A1:J1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
 		$spreadsheet->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(Fill::FILL_SOLID);
		$spreadsheet->getActiveSheet()->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('808080');
		$spreadsheet->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('7')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('8')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getStyle('A1:J1')->applyFromArray(
		    [
		        'borders' => [
		            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
		        ],
		    ]
		);
		ob_end_clean();
		header('Content-Type:application/vnd.ms-excel');
		header('Content-Disposition:attachment;filename=' . $nombreArchivo);
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	/**
	 * Generar Reporte Visitantes
	 */
    public function visitors()
	{
		$listaVisitantes = $this->reportes_model->get_visitors();
		$nombreArchivo = 'reporte_visitantes.xlsx';
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle('Reporte Visitantes');
		$spreadsheet->getActiveSheet(0)
							->setCellValue('A1', 'Tipo Documento')
							->setCellValue('B1', 'Número Documento')
							->setCellValue('C1', 'Nombres')
							->setCellValue('D1', 'Apellidos')
							->setCellValue('E1', 'Correo Electrónico')
							->setCellValue('F1', 'Teléfono')
							->setCellValue('G1', 'Motivo')
							->setCellValue('H1', 'Fecha Entrada')
							->setCellValue('I1', 'Fecha Salida');
		$j=2;
		if($listaVisitantes){
			foreach ($listaVisitantes as $lista):
				$spreadsheet->getActiveSheet()
							->setCellValue('A'.$j, $lista['tipo_documento'])
							->setCellValue('B'.$j, $lista['numero_documento'])
							->setCellValue('C'.$j, $lista['nombres'])
							->setCellValue('D'.$j, $lista['apellidos'])
							->setCellValue('E'.$j, $lista['correo'])
							->setCellValue('F'.$j, $lista['telefono'])
							->setCellValue('G'.$j, $lista['motivo'])
							->setCellValue('H'.$j, $lista['fecha_entrada'])
							->setCellValue('I'.$j, $lista['fecha_finaliza']);
				$j++;
			endforeach;
		}
		// Set column widths
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(80);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(40);
		// Set fonts
		$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getFont()->setSize(11);
		$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
 		$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(Fill::FILL_SOLID);
		$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getFill()->getStartColor()->setARGB('808080');
		$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('7')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('8')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getStyle('A1:I1')->applyFromArray(
		    [
		        'borders' => [
		            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
		        ],
		    ]
		);
		ob_end_clean();
		header('Content-Type:application/vnd.ms-excel');
		header('Content-Disposition:attachment;filename=' . $nombreArchivo);
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	/**
	 * Generar Reporte Integrantes
	 */
    public function members()
	{
		$listaIntegrantes = $this->reportes_model->get_members();
		$nombreArchivo = 'reporte_integrantes.xlsx';
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle('Reporte Integrantes');
		$spreadsheet->getActiveSheet(0)
							->setCellValue('A1', 'Tipo Documento')
							->setCellValue('B1', 'Número Documento')
							->setCellValue('C1', 'Nombres')
							->setCellValue('D1', 'Apellidos')
							->setCellValue('E1', 'NIT')
							->setCellValue('F1', 'Escuela')
							->setCellValue('G1', 'Tipo Función')
							->setCellValue('H1', 'Correo Electrónico')
							->setCellValue('I1', 'Teléfono')
							->setCellValue('J1', 'Fecha Entrada')
							->setCellValue('K1', 'Fecha Salida');
		$j=2;
		if($listaIntegrantes){
			foreach ($listaIntegrantes as $lista):
				$spreadsheet->getActiveSheet()
							->setCellValue('A'.$j, $lista['tipo_documento'])
							->setCellValue('B'.$j, $lista['numero_documento'])
							->setCellValue('C'.$j, $lista['nombres'])
							->setCellValue('D'.$j, $lista['apellidos'])
							->setCellValue('E'.$j, $lista['nit'])
							->setCellValue('F'.$j, $lista['nombre_escuela'])
							->setCellValue('G'.$j, $lista['tipo_funcion'])
							->setCellValue('H'.$j, $lista['correo'])
							->setCellValue('I'.$j, $lista['telefono'])
							->setCellValue('J'.$j, $lista['fecha_entrada'])
							->setCellValue('K'.$j, $lista['fecha_finaliza']);
				$j++;
			endforeach;
		}
		// Set column widths
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(40);
		$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(40);
		// Set fonts
		$spreadsheet->getActiveSheet()->getStyle('A1:K1')->getFont()->setSize(11);
		$spreadsheet->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('A1:K1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
 		$spreadsheet->getActiveSheet()->getStyle('A1:K1')->getFill()->setFillType(Fill::FILL_SOLID);
		$spreadsheet->getActiveSheet()->getStyle('A1:K1')->getFill()->getStartColor()->setARGB('808080');
		$spreadsheet->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
		$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('5')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('7')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getRowDimension('8')->setRowHeight(20);
		$spreadsheet->getActiveSheet()->getStyle('A1:K1')->applyFromArray(
		    [
		        'borders' => [
		            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
		        ],
		    ]
		);
		ob_end_clean();
		header('Content-Type:application/vnd.ms-excel');
		header('Content-Disposition:attachment;filename=' . $nombreArchivo);
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}
}