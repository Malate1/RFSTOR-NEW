<?php
	require('fpdf/fpdf.php');

class PDF extends FPDF{
	function Header(){
		
	    $this->Image('img/alturaslogo.png',10,6,30);	    
	    $this->SetFont('Arial','',12);
	    $this->SetTextColor(0,0,0);
	    $this->setXY(70,10);
	    $this->Cell(10,10,'INFORMATION SYSTEM REQUEST (ISR) FORM',0,0,'L');
	    $this->Ln(8);
	}
}



// $pdf = new PDF('P','mm',array(279.4,215.9)); //letter 
$pdf = new PDF('P','mm',array(216,279)); //letter 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Helvetica','',10);
$pdf->SetFillColor(230,230,230);
$pdf->Cell(0,0,'',1,'','',true);

// $row_req = mysqlm_fetch_array(mysqlm_query("select LPAD(requestnumber,5,0) as requestnumber,
// 											c.companyname2 as companyname,
// 											b.businessunit as businessunit, 
// 											b.address as address,
// 											a.date as `date`,
// 											a.requesttypevalue as details,
// 											concat(u.firstname,' ',u.lastname) as requestedby,
// 											a.executed as executed,
// 											a.buheadid as buhead,
// 											r.requesttype as typeofrequest,
// 											s.systemtype as systemtype,
// 											a.purpose as purpose,
// 											a.generals as general,
// 											a.security as security,
// 											a.output as output,
// 											a.userexecute as programmer,
// 											g.groupname as usergroup,	
// 											a.userid as userid,
// 											a.reqbu as requestingbu,
// 											a.reqby as reqby,
// 											a.reqposition as reqposition									
// 											from requests a,tblbusinessunit b, users u, tblcompany c, typeofrequest r, systemtype s, usergroups g
// 											where a.userid = u.id and b.id = u.businessunitid and c.id = b.companyid and a.typeofrequest = r.id 
// 											and a.systemtype = s.id and g.id = a.togroup and a.id=".$requestid));

// // if user is not the requesting party //
// $requestedby  =$row_req['reqby'];
// $requestedbyposition = $row_req['reqposition'];
// $requestingbuname = ($row_req['requestingbu']!=''?$bus[$row_req['requestingbu']]:''); //BU Name of requestingbu
// // if user is not the requesting party //

// $executed = ($row_req['executed']!=''?$users[$row_req['executed']]:''); //MIS
// $buhead = ($row_req['buhead']!=''?$users[$row_req['buhead']]:''); //BU Head
// $programmer = ($row_req['programmer']!=''?$users[$row_req['programmer']]:''); //Programmer

// $req_position = ($row_req['userid']!=''?$jobs[$row_req['userid']]:''); //position of the user
// $req_bu = ($row_req['buhead']!=''?$jobs[$row_req['buhead']]:''); //position of the BU Head
// $headbuid = ($row_req['buhead']!=''?$buid[$row_req['buhead']]:'');//BU id of BU Head
// $buname = ($headbuid!=''?$bus[$headbuid]:''); //BU Name of BU Head
// $bu_position = ($row_req['buhead']!=''?$jobs[$row_req['buhead']]:''); //position of the bu head


$pdf->setXY(10,17);$pdf->Cell(0,15,'TO : ');
$pdf->SetFont('Helvetica','B',10);
$pdf->setXY(20,17);$pdf->Cell(0,15, $result->groupname. ' TEAM - '.$result->executedby);


$pdf->SetFont('Helvetica','',10);
$pdf->setXY(110,17);$pdf->Cell(0,15,'ISR No : ');
$pdf->SetFont('Helvetica','B',11);
$pdf->SetTextColor(225,0,0);
$pdf->setXY(130,17);$pdf->Cell(0,15,$result->requestnumber);
$pdf->SetTextColor(0,0,0);

$pdf->SetFont('Helvetica','',10);
$pdf->setXY(110,22);$pdf->Cell(0,15,'Date:');
$pdf->SetFont('Helvetica','B',10);
$pdf->setXY(130,22);$pdf->Cell(0,15,$row_req['date']);

$pdf->setXY(10,40);$pdf->Cell(0,15,'1.0 Requesting Party Info');
$pdf->SetFont('Helvetica','',9);
if($requestedby == "" and  $requestedbyposition == "" and  $requestingbuname == ""){
	$pdf->setXY(10,45);$pdf->Cell(0,15,'Full Name:');
	$pdf->setXY(35,45);$pdf->Cell(0,15,strtoupper($row_req['requestedby']));
	$pdf->setXY(10,50);$pdf->Cell(0,15,'Representing:');
	$pdf->setXY(35,50);$pdf->Cell(0,15,strtoupper($row_req['businessunit']));
	$pdf->setXY(10,55);$pdf->Cell(0,15,'Job Position:');
	$pdf->setXY(35,55);$pdf->Cell(0,15,strtoupper($req_position));

}
else{ //if the user is not the requesting party
	$pdf->setXY(10,45);$pdf->Cell(0,15,'Full Name:');
	$pdf->setXY(35,45);$pdf->Cell(0,15,strtoupper($requestedby));
	$pdf->setXY(10,50);$pdf->Cell(0,15,'Representing:');
	$pdf->setXY(35,50);$pdf->Cell(0,15,strtoupper($requestingbuname));
	$pdf->setXY(10,55);$pdf->Cell(0,15,'Job Position:');
	$pdf->setXY(35,55);$pdf->Cell(0,15,strtoupper($requestedbyposition));

}

$pdf->SetFont('Helvetica','B',10);
$pdf->setXY(10,70);$pdf->Cell(0,15,'1.2 Request Approved By');
$pdf->SetFont('Helvetica','',9);
$pdf->setXY(10,75);$pdf->Cell(0,15,'Full Name:');
$pdf->setXY(10,80);$pdf->Cell(0,15,'Representing:');
$pdf->setXY(10,85);$pdf->Cell(0,15,'Job Position:');
if($buhead == ""){
	
	$pdf->setXY(35,75);$pdf->Cell(0,15,'___________________');
	$pdf->setXY(35,80);$pdf->Cell(0,15,'___________________');
	$pdf->setXY(35,85);$pdf->Cell(0,15,'___________________');
}
else{

	$pdf->setXY(35,75);$pdf->Cell(0,15,strtoupper($buhead));
	$pdf->setXY(35,80);$pdf->Cell(0,15,strtoupper($buname));
	$pdf->setXY(35,85);$pdf->Cell(0,15,strtoupper($bu_position));
}

$pdf->SetFont('Helvetica','B',10);
$pdf->setXY(10,105);$pdf->Cell(0,0,'2.0 Nature of Request');
$pdf->SetFont('Helvetica','',9);
$pdf->setXY(15,110);$pdf->MultiCell(90,4,$row_req['typeofrequest'],0,'L',0);


$pdf->SetFont('Helvetica','B',10);
$pdf->setXY(10,130);$pdf->Cell(0,0,'3.0 Purpose');
$pdf->SetFont('Helvetica','',9);
$pdf->setXY(15,135);$pdf->MultiCell(90,4,strtoupper($row_req['purpose']),0,'L',0);


$pdf->SetFont('Helvetica','B',10);
$pdf->setXY(110,47);$pdf->Cell(0,0,'4.0 General Specifications/Explanations');
$pdf->SetFont('Helvetica','',9);
$pdf->setXY(115,51);$pdf->Cell(0,0,'(effects as inputs, processes, database, etc.)');
$pdf->SetFont('Helvetica','',9);
if($row_req['general']=="" or is_null($row_req['general'])){
	$pdf->setXY(115,53);$pdf->Cell(0,15,'______________________________________________');
	$pdf->setXY(115,58);$pdf->Cell(0,15,'______________________________________________');
	$pdf->setXY(115,63);$pdf->Cell(0,15,'______________________________________________');
	$pdf->setXY(115,68);$pdf->Cell(0,15,'______________________________________________');
	$pdf->setXY(115,73);$pdf->Cell(0,15,'______________________________________________');
}
else{
	$pdf->setXY(115,53);$pdf->MultiCell(90,4,strtoupper($row_req['general']),0,'L',0);
}

$pdf->SetFont('Helvetica','B',10);
$pdf->setXY(110,105);$pdf->Cell(0,0,'5.0 Security Control Specification');
$pdf->SetFont('Helvetica','',9);
if($row_req['security']=="" or is_null($row_req['security'])){
	$pdf->setXY(115,105);$pdf->Cell(0,15,'______________________________________________');
	$pdf->setXY(115,110);$pdf->Cell(0,15,'______________________________________________');
	$pdf->setXY(115,115);$pdf->Cell(0,15,'______________________________________________');
}
else{
	$pdf->setXY(115,110);$pdf->MultiCell(90,4,strtoupper($row_req['security']),0,'L',0);
}

$pdf->SetFont('Helvetica','B',10);
$pdf->setXY(110,130);$pdf->Cell(0,0,'6.0 Output Specification');
$pdf->SetFont('Helvetica','',9);
$pdf->setXY(115,134);$pdf->Cell(0,0,'(Report format/Textfile copy format, target drive/location)');
$pdf->SetFont('Helvetica','',9);
if($row_req['output']=="" or is_null($row_req['output'])){
	$pdf->setXY(115,134);$pdf->Cell(0,15,'______________________________________________');
	$pdf->setXY(115,139);$pdf->Cell(0,15,'______________________________________________');
	$pdf->setXY(115,144);$pdf->Cell(0,15,'______________________________________________');
	$pdf->setXY(115,149);$pdf->Cell(0,15,'______________________________________________');
}
else{
	$pdf->setXY(115,138);$pdf->MultiCell(90,4,strtoupper($row_req['output']),0,'L',0);
}


/*                    REQUESTED BY                             */
$pdf->SetFont('Helvetica','B',10);
$pdf->setXY(10,220);$pdf->Cell(0,0,'Requested By:');
$pdf->SetFont('Helvetica','',10);
$pdf->setXY(10,230);$pdf->Cell(0,0,'Signature:  __________________');
$pdf->setXY(10,235);$pdf->Cell(0,0,'Full Name:');
$pdf->SetFont('Helvetica','U',10);
if($requestedby == "" &&  $requestedbyposition == "" &&  $requestingbuname == ""){
	$pdf->setXY(28,235);$pdf->Cell(0,0,strtoupper($row_req['requestedby']));
}
else{
	$pdf->setXY(28,235);$pdf->Cell(0,0,strtoupper($requestedby));	
}
$pdf->SetFont('Helvetica','',10);
$pdf->setXY(10,240);$pdf->Cell(0,0,'Date:          __________________');
/*                    REQUESTED BY                             */


/*                    APPROVED BY                             */
$pdf->SetFont('Helvetica','B',10);
$pdf->setXY(80,220);$pdf->Cell(0,0,'Approved By:');
$pdf->SetFont('Helvetica','',10);
$pdf->setXY(80,230);$pdf->Cell(0,0,'Signature:  __________________');
if($buhead == ""){
	$pdf->setXY(80,235);$pdf->Cell(0,0,'Full Name: __________________');
	
}

else{
	$pdf->SetFont('Helvetica','',10);
	$pdf->setXY(80,235);$pdf->Cell(0,0,'Full Name:');
	$pdf->SetFont('Helvetica','U',10);
	$pdf->setXY(98,235);$pdf->Cell(0,0,strtoupper($buhead));
}
$pdf->SetFont('Helvetica','',10);
$pdf->setXY(80,240);$pdf->Cell(0,0,'Date:          __________________');
/*                    APPROVED BY                             */


/*                    RECEIVED BY                             */
$pdf->SetFont('Helvetica','B',10);
$pdf->setXY(150,220);$pdf->Cell(0,0,'Received By:');
$pdf->SetFont('Helvetica','',10);
$pdf->setXY(150,230);$pdf->Cell(0,0,'Signature:  __________________');
$pdf->setXY(150,235);$pdf->Cell(0,0,'Full Name: __________________');
$pdf->setXY(150,240);$pdf->Cell(0,0,'Date:          __________________');
/*                    RECEIVED BY                             */


$pdf->Output();

?>