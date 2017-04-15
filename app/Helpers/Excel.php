<?php

namespace App\Helpers;

use PHPExcel;
use PHPExcel_IOFactory;

class Excel
{
    //
    public function export($data,$filename){
    	$excel = new PHPExcel();
    	$letter=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    	$char = $letter;
    	for ($count=0;$count<2;$count++){
    	    foreach ($char as $l)
                $letter[] = $char[$count].$l;
        }

    	$num=1;
    	for($i=0;$i<count($data);$i++){
    		for($j=0;$j<count($data[$i]);$j++){
    			$excel->getActiveSheet()
    			->setCellValue($letter[$j].$num, $data[$i][$j]);

                $excel->getActiveSheet()->getStyle( $letter[$j].$num )->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel->getActiveSheet()->getStyle( $letter[$j].$num )->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
    		}
            $excel->getActiveSheet()->getRowDimension($num)->setRowHeight(20);
    		$num++;
    	}
    	$excel->getActiveSheet()->setTitle('Result');
    	$excel->setActiveSheetIndex(0);
    	foreach ($letter as $l){
            $excel->getActiveSheet()->getColumnDimension($l)->setWidth(20);
        }

        header('Content-Type: application/vnd.ms-excel');
    	header('Content-Disposition: attachment;filename='.$filename.'.xls');
    	header('Cache-Control: max-age=0');
    	$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    	$objWriter->save('php://output');
    	exit;
    }
    
    public function import($path){
//     	dd(storage_path().'/app/'.$path);
//    	$path=storage_path().'/app/'.$path;
    	
    	$objPHPExcel = PHPExcel_IOFactory::load($path);
    	$sheet = $objPHPExcel->getSheet ( 0 );
    	$data=$sheet->toArray();
    	
    	return $data;
    	
    }
}
