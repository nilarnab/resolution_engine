<?php

// will get the file name by get method
// then the data will be read by this file
// then again we are sending this data to the resolutnion engine
$myfile = fopen("../text_files/test.txt", "r") or die("Unable to open file!");
echo fread($myfile,filesize("../text_files/test.txt"));
fclose($myfile);
?>