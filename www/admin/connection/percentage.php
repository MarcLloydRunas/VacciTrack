<?php
//GET THE PERCENTAGE OF EACH ENTRIES IN PIE GRAPH
try{
//$handle = $pdo->prepare("INSERT INTO pie_graph (percent_of_total) SELECT vaccination_site, entries, entries * 100 / t.s AS percent_of_total CROSS JOIN (SELECT SUM(entries) AS s FROM pie_graph) t");
    
$handle =$pdo->prepare("INSERT INTO pie_graph (percent_of_total) SELECT vaccination_site, entries, entries * 100 / (SELECT SUM(entries)");
$handle->execute();
$result = $handle->fetchAll(\PDO::FETCH_OBJ);

$link = null;
}catch (\PDOException $ex){
print($ex->getMessage());
 }
?>