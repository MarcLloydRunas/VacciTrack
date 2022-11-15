<?php

//INSERT DATA IN ENTRIES FROM VACCINATION RECORD
try{

if(empty($entries){
$handle = $pdo->prepare("INSERT INTO pie_graph (entries) (SELECT COUNT('RHU-Benguet') FROM vaccination_record WHERE site_name = 'RHU-Benguet')");
$handle = $pdo->prepare("INSERT INTO pie_graph (entries) (SELECT COUNT('San Pascual Clinic') FROM vaccination_record WHERE (site_name = 'San Pacual Clinic')");
$handle = $pdo->prepare("INSERT INTO pie_graph (entries) (SELECT COUNT('Asin Clinic') FROM vaccination_record WHERE (site_name = 'Asin Clinic')");
$handle = $pdo->prepare( "INSERT INTO pie_graph (entries) SELECT COUNT('Nangalisan Clinic') FROM vaccination_record WHERE (site_name = 'Nangalisan Clinic')");
$handle->execute();
$result = $handle->fetchAll(\PDO::FETCH_OBJ);
}
}catch (\PDOException $ex){
print($ex->getMessage());
 }

?>