<?php

$connect = mysqli_connect("127.0.0.1","mhcdbuser","mhc123","mhc");

include ("PHPExcel/IOFactory.php");

$html = "<table border ='1'>";

 $objPHPExcel = PHPExcel_IOFactory::load('pricelist.xlsx');
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
  $highestRow = $worksheet->getHighestRow();
  for ($row=1; $row <= 10; $row++) {
    $html .="<tr>";
    $name = mysqli_real_escape_string($connect,$worksheet->getCellByColumnAndRow(0,$row)->getValue());
    $category_type = mysqli_real_escape_string($connect,$worksheet->getCellByColumnAndRow(1,$row)->getValue());
    $lead_source = 6;
    $city = mysqli_real_escape_string($connect,$worksheet->getCellByColumnAndRow(3,$row)->getValue());
    $varianttype = mysqli_real_escape_string($connect,$worksheet->getCellByColumnAndRow(5,$row)->getValue());
    $taxed_cost = mysqli_real_escape_string($connect,$worksheet->getCellByColumnAndRow(6,$row)->getValue());
    $price = mysqli_real_escape_string($connect,$worksheet->getCellByColumnAndRow(8,$row)->getValue());




    $serviceTime ="INSERT INTO `pricelist` ( `name`,`category_type`,`lead_source`,`city`,`varianttype`,`taxed_cost`,`price`,`commission`,`author_id`, `author_name`, `insert_date`,`update_date`,`ip`,`status`) VALUES
    ('".$name."','".$category_type."','".$lead_source."','".$city."','".$varianttype."','".$taxed_cost."','".$price."',0,1, 'Prashant', '2016-04-03 12:30:35', '2016-04-03 12:44:06', '127.0.0.1', 0)";

    mysqli_query($connect,$sql);
     $html .='<td>'.$name.'</td>';
    // $html .='<td>'.$contact_no.'</td>';
    // $html .='<td>'.$designation.'</td>';
    // $html .='<td>'.$city.'</td>';
    // $html .='<td>'.$gender.'</td>';


  }
}
$html .='</table>';
echo $html;

 ?>
