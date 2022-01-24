<?php
include "csv_object.php";
include "sql_sender.php";
$resultdata = array();
$csv = array();
function file_force_download($file) {
    if (file_exists($file)) {
      if (ob_get_level()) {
        ob_end_clean();
      }
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename=' . basename($file));
      header('Content-Transfer-Encoding: binary');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($file));
      readfile($file);
      exit;
    }
  }
function isNotValid($str) { 
    if (! preg_match_all('/[^A-Za-zА-Яа-я0-9.\\-]/', $str, $s)) {
        return FALSE;
    } else {
        return 'Недопустимый символ ' . join(' ', $s[0]) . ' в поле Название';
    }
}
if($_FILES['csv']['error'] == 0){
    $name = $_FILES['csv']['name'];
    $ext = strtolower(end(explode('.', $_FILES['csv']['name'])));
    $type = $_FILES['csv']['type'];
    $tmpName = $_FILES['csv']['tmp_name'];
    if($ext === 'csv'){
        if(($handle = fopen($tmpName, 'r+')) !== FALSE) {
            $row = 0;
            while(($data = fgetcsv($handle, ',')) !== FALSE) {
                $col_count = count($data);
                if($row == 0 && $data[0] == 'Код'){
                    array_push($csv, array($data[0], $data[1]));
                    continue;
                }
                if(isNotValid($data[1])){
                    array_push($csv, array($data[0], $data[1], isNotValid($data[1])));
                    continue;
                } else {
                    array_push($csv, array($data[0], $data[1]));
                    array_push($resultdata,  new CSVObj($data[0], $data[1]));               
                }
                $row++;
            }
            ftruncate($handle, 0);
            fseek($handle,0);
            foreach ($csv as $line) {
                fputcsv($handle, $line);
            }
            fclose($handle);
        }
        sendToSql($resultdata);
        file_force_download($tmpName);
    }
}
?>