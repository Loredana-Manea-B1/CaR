<?php


include_once 'db-conn.php';
 
$sql = "SELECT * FROM curse ORDER BY data_cursa ASC";
$stmt = $connector->getConnection()->prepare($sql);
$stmt->execute(); 
 
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $delimiter = ","; 
    $filename = "curse-data_" . date('Y-m-d') . ".csv"; 
    $f = fopen('php://memory', 'w'); 
    $fields = array('ID', 'PISICA 1', 'PISICA 2', 'DATA CURSEI', 'DATA LIMITA', 'CASTIGATOR'); 
    fputcsv($f, $fields, $delimiter); 
     
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){  
        $lineData = array($row['id'], $row['id_pisica1'], $row['id_pisica2'], $row['data_cursa'], $row['data_limita'], $row['castigator']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    fseek($f, 0); 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";');  
    fpassthru($f); 
} 
exit; 
 
?>
