<?php
// fpdf -> mc_table -> fancyrow -> code128 -> htmltable -> rotate 
require("fpdf.php");
require("pdf_mc_table.php");
require("pdf_fancyrow.php");
require("pdf_code128.php");
require("pdf_htmltable.php");
require("pdf_rotate.php");


class PDF extends PDF_Rotate {
	var $header_func, $footer_func, $tbl_header_func;
	var $rptclass;
	function __construct() {
		parent::__construct('P','mm','A4');
        $this->AliasNbPages();
    	$this->SetMargins(10,20,10);
		
	}
	function header() {
		$company_name = "BIO HERBA INDONESIA ";
		$address1 = "Jl. Dramaga KM 7, Margajaya Bogor 16116";
		$address2 = "Jawa Barat";
		
		$phone_fax = "Tel : 0251 - 4799456, hotline : 0817 6898 120" ;
		$email = "  Email : bhisejahtera@yahoo.com";
		$this->setY(5);
		$this->setFont("Arial","B",14);
		$this->Cell(190,5, "$company_name",0,1,'C');
		$this->setFont("Arial","",10);
		$this->Cell(190,4, "$address1",0,1,'C');
		$this->Cell(190,4, "$address2",0,1,'C');
		$this->Cell(190,4, "$phone_fax",0,1,'C');
		$this->Cell(190,4, "$email",0,1,'C');
		$img_logo = realpath(APPPATH . "../includes/images/") . "/report-logo.jpeg";
		$this->Image($img_logo, 10, 7 , 25);
	
		$this->Ln(3);
		$this->Cell(190,0.2,'','B',1,'C');
		$this->Ln(3);
		if(is_callable(array($this->rptclass,$this->header_func),false,$fname)) {
			call_user_func($fname,$this);
		}
                
                if(is_callable(array($this->rptclass,$this->tbl_header_func),false,$fname)) {
			call_user_func($fname,$this);
		}

	}
	function footer() {
		if(is_callable(array($this->rptclass,$this->footer_func),false,$fname)) {
			call_user_func($fname,$this);
		}
	}
}


?>