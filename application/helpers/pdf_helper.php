<?php

function prep_pdf($orientation = 'portrait')
{
	$CI = & get_instance();
	
	$CI->cezpdf->selectFont(base_url() . '/fonts');	
	
	$all = $CI->cezpdf->openObject();
	$CI->cezpdf->saveState();
	$CI->cezpdf->setStrokeColor(0,0,0,1);
	if($orientation == 'portrait') {
		$CI->cezpdf->ezSetMargins(90,70,50,50);
		$CI->cezpdf->ezStartPageNumbers(500,28,8,'','{PAGENUM}',1);
		// A4 : 595.28 , 841.89
		
		//header
		$CI->cezpdf->ezSetY(830);
		$data = array();
		$data[] = array("data" => "<b>Bio Herbal Indonesia</b>");
		$CI->cezpdf->ezTable($data,array("data"=>"AAA"),"",array(
			"shaded"=>0,
			"showLines"=>0,
			"showHeadings"=>0,
			"fontSize"=>14,
			"width"=>395,
			"cols"=>array("data" => array(
				"justification" => "center"
			))
		));
		$data = array();
		$data[] = array("data" => "Jalan Darmaga km 10 Bogor");
		$data[] = array("data" => "Phone : 1234 Email : abc@bhi.com Web : http://www.bhi.com/");
		
		$y = $CI->cezpdf->ezTable($data,array("data"=>"AAA"),"",array(
			"shaded"=>0,
			"showLines"=>0,
			"showHeadings"=>0,
			"fontSize"=>10,
			"width"=>400,
			"cols"=>array("data" => array(
				"justification" => "center"
			))
		));
		$CI->cezpdf->line(20,$y-5,578, $y-5);
		$CI->cezpdf->line(20,$y-7,578,$y-7);
		$CI->cezpdf->ezSetY(760);

		//footer
		$CI->cezpdf->line(20,40,578,40);
		$CI->cezpdf->addText(50,32,8,'Printed on ' . date('m/d/Y h:i:s a'));


	}
	else {
		$CI->cezpdf->ezStartPageNumbers(750,28,8,'','{PAGENUM}',1);
		$CI->cezpdf->line(20,40,800,40);
		$CI->cezpdf->addText(50,32,8,'Printed on ' . date('m/d/Y h:i:s a'));
	}
	$CI->cezpdf->restoreState();
	$CI->cezpdf->closeObject();
	$CI->cezpdf->addObject($all,'all');
}

?>