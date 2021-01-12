<?php

function write_file($file_name, $txt)
{
    $file_name = $file_name.".txt";
    $myfile = fopen("../text_files/".$file_name, "w") or die("Unable to open file!");
    fwrite($myfile, $txt);
    fclose($myfile);

}

function read_file($file_name)
{
    $file_name = $file_name.".txt";
    $myfile = fopen("../text_files/".$file_name, "r") or die("Unable to open file!");
    $txt = fread($myfile,filesize("../text_files/test.txt"));
    fclose($myfile);

    return $txt;
}
?>
