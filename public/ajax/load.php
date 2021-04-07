<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    include '../../engine/new_resolution.php';
    
    
    //print_r (explode("\n",$_POST['inp']));
    $raw = explode("\n",trim($_POST['inp']));
    for ($i = 0; $i < sizeof($raw); $i++)
    {
        $val = strtoupper(trim($raw[$i]));
        $val = str_replace(" ","", $val);
        $raw[$i] = $val;
    }

    

    // print_r($raw);

    $vrdct = simplify_by_resolution($raw);

    for ($i = 0; $i < sizeof($vrdct); $i++)
    {
        $vrdct[$i] = str_replace("<NEG>","<or>~</or>", $vrdct[$i]);
        $vrdct[$i] = str_replace("<OR>","<ng>OR</ng>", $vrdct[$i]);

    }

    $report = [];
    $cnt = 0;

    for ($i = 0; $i < sizeof($vrdct); $i++)
    {
        if ($vrdct[$i] != " " and $vrdct[$i] != "")
        {
            array_push($report, $vrdct[$i]);
        }
    }


    print_r(implode("<and> AND </and>", $report));
   
     