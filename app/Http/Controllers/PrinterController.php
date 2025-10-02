<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;


class PrinterController extends MainController
{
	protected $spreadsheet;
	protected $styleArray = [];
	protected $sheelSheet = [
		'CHART OF ACCOUNT',
		'TRIAL BALANCE',
		'GENERAL LEDGER',
		'INCOME STATEMENT',
		'SUBSIDIARY LEDGER'
	];
	function __construct() {
		$this->spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path()."/templates/report_template_1.xlsx");
		$this->styleArray = [
			'borders' => [
				'bottom' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
				],
			],
		];

	}
	
	function subsidiary_ledger_print($data,$sheetname)
	{
		$sheet = $this->spreadsheet->getSheetByName($sheetname);
		$sheet->setCellValue('A2',$sheetname);
		$sheet->setCellValue('B1', Carbon::now()->toDayDateTimeString());
		foreach($this->sheelSheet as $sh)
		{
			if($sh != $sheetname)
			{
				$sheetIndex = $this->spreadsheet->getIndex(
					$this->spreadsheet->getSheetByName($sh)
				);
				$this->spreadsheet->removeSheetByIndex($sheetIndex);
			}
		}
		$counter = 5;
		if(count($data) > 0)
		{
			foreach($data as $key => $value){
				$sheet->setCellValue('A'.$counter,trim(ucwords($value['sub_name'],' ')));
				$sheet->setCellValue('B'.$counter,trim(ucwords($value['sub_address'],' ')));
				$sheet->setCellValue('C'.$counter,trim(ucwords($value['sub_tel'],' ')));
				$sheet->setCellValue('D'.$counter,trim(ucwords($value['sub_per_branch'],' ')));
				$sheet->setCellValue('E'.$counter,trim(ucwords($value['created_at'],' ')));
				$sheet->setCellValue('F'.$counter,trim(ucwords($value['sub_amount'],' ')));
				$sheet->setCellValue('G'.$counter,trim(ucwords($value['sub_date_post'],' ')));
				$counter++;
			}
		}
		$writer = new Xlsx($this->spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORT.xlsx"'); 
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); // download file
	}
	function generate_chart_of_account($data,$sheetname){
		
		$sheet = $this->spreadsheet->getSheetByName($sheetname);
		$sheet->setCellValue('A2',$sheetname);
		$sheet->setCellValue('B1', Carbon::now()->toDayDateTimeString());
		foreach($this->sheelSheet as $sh)
		{
			if($sh != $sheetname)
			{
				$sheetIndex = $this->spreadsheet->getIndex(
					$this->spreadsheet->getSheetByName($sh)
				);
				$this->spreadsheet->removeSheetByIndex($sheetIndex);
			}
		}
		$counter = 4;
		if(count($data) > 0)
		{
			foreach($data as $key => $value){
				foreach($value['content'] as $content){
					$sheet->setCellValue('A'.$counter,$key);
					$sheet->setCellValue('B'.$counter,trim(ucwords($content['account_name'],' ')));
					$counter++;
				}
			}
		}
		$writer = new Xlsx($this->spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORT.xlsx"'); 
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); // download file
	} 

	function generate_trial_balance($data, $sheetname){
		$sheet = $this->spreadsheet->getSheetByName($sheetname);
		$sheet->setCellValue('A2',$sheetname);
		foreach($this->sheelSheet as $sheet)
		{
			if($sheet != $sheetname)
			{
				$sheetIndex = $this->spreadsheet->getIndex(
					$this->spreadsheet->getSheetByName($sheetname)
				);
				$this->spreadsheet->removeSheetByIndex($sheetIndex);
			}
		}
		// if(count($data) > 0)
		// {
		// 	foreach($data as $value){

		// 	}
		// }
		$filename = 'REPORT-'.$sheetname;
		$writer = new Xlsx($this->spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); // download file
	} 

	function generate_general_ledger($data, $sheetname){
	
		$sheet = $this->spreadsheet->getSheetByName($sheetname);
		$sheet->setCellValue('A2',$sheetname);
		foreach($this->sheelSheet as $sheet)
		{
			if($sheet != $sheetname)
			{
				$sheetIndex = $this->spreadsheet->getIndex(
					$this->spreadsheet->getSheetByName($sheetname)
				);
				$this->spreadsheet->removeSheetByIndex($sheetIndex);
			}
		}
		// if(count($data) > 0)
		// {
		// 	foreach($data as $value){

		// 	}
		// }
		$filename = 'REPORT-'.$sheetname;
		$writer = new Xlsx($this->spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); // download file
	} 

	function generate_income_statement($data, $sheetname){
		$sheet = $this->spreadsheet->getSheetByName($sheetname);
		$sheet->setCellValue('A2',$sheetname);
		foreach($this->sheelSheet as $sheet)
		{
			if($sheet != $sheetname)
			{
				$sheetIndex = $this->spreadsheet->getIndex(
					$this->spreadsheet->getSheetByName($sheetname)
				);
				$this->spreadsheet->removeSheetByIndex($sheetIndex);
			}
		}
		// if(count($data) > 0)
		// {
		// 	foreach($data as $value){

		// 	}
		// }
		$this->download($sheetname);
	} 

	function download($sheetname)
	{
		$filename = 'REPORT-'.$sheetname;
		$writer = new Xlsx($this->spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); // download file
	}

}
