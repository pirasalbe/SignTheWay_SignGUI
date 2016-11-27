
<?php
  $File = fopen("/home/pi/Desktop/clientconf.txt", "r+") or die("Unable to open file!");
  

  while (($line = fgets($File)) !== false) 
  {
    $splitted= split (";",$line);
  }
  
  if (array_key_exists(0, $splitted))
  {
    echo $splitted[0];
  }
  else
  {
    echo "error";
  }
  fclose($File);
?> 