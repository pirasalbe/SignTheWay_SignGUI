<?php
if (isset($_POST['invio']))
{
    $Key = getKey();
   // $Key = require("readFile.php");
    $Codice = $_POST["Type"];

    $StartDate = $_POST["startDate"];
    
    $EndDate = $_POST["endDate"];
    if ($EndDate=="")
    {
        $EndDate="-1";
    }
    $Coordinate = $_POST["Coordinate"];

    $CoordinateSplitted = split (" ", $Coordinate);
    
    $lat= $CoordinateSplitted[0];
    $lon= $CoordinateSplitted[1];
    
    $side =  $_POST['side'];
    
    
    
    $StartDate= ParseDate($StartDate);
    $EndDate = ParseDate($EndDate);
    
    $smpStart= getTimeStamp($StartDate);
    $smpEnd = getTimeStamp($EndDate);

    if ($side == "D")
    {
        $sideChar="1";
    }
    else
    {
        $sideChar= "0";
    }
    if ($smpEnd== "941328000")
    {
        $smpEnd= "-1";
    }
    $output= $Key.";".$Codice.";".$smpStart.";".$smpEnd.";".$lon.";".$lat.";".$sideChar;
    PrintFile($output);
    echo "<script>$.notify('Inviato correttamente!','success');</script>";
}

function PrintFile($output)
{
    $File = fopen("/home/pi/Desktop/clientconf.txt", "w+") or die("Unable to open file!");
    fwrite($File, $output);

}


function ParseDate($Date)
{
    $i=0;
    while ($i<strlen($Date))
    {
        if ($Date[$i]== " " || $Date[$i]== "/" || $Date[$i]== ":" )
        {
            $Date[$i]="/";
        }
        $i++;
    }
    return $Date;
}
function getTimeStamp($Date)
{
    $DateParse=split("/", $Date);
    
    if ($DateParse[5]=="PM")
    {
       $DateParse[3]= intval($DateParse[3]+12);
    }
    
   return mktime(intval($DateParse[3]), intval($DateParse[4]), 0, intval($DateParse[0]),intval($DateParse[1]),intval($DateParse[2]));

}

function getKey()
{
      $File = fopen("/home/pi/Desktop/clientconf.txt", "r+") or die("Unable to open file!");
  

  while (($line = fgets($File)) !== false) 
  {
    $splitted= split (";",$line);
  }
  
  if (array_key_exists(0, $splitted))
  {
    return $splitted[0];
  }
  else
  {
    return "error";
  }
  fclose($File);
}
?>