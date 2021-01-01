<?php 

    function resolution_util($premise)
    {
        
        echo "resolution_util recieved ".sizeof($premise)."\n";
        print_r($premise);
        for($i = 0; $i < sizeof($premise); $i++)
        {
            echo $i;
            if (empty($premise[$i]))
            {
                // match found
                echo "match found \n";
                array_splice($premise, $i, 1);
            }
        }
        
        echo "returned \n";
        print_r($premise);
        
        return $premise;
    }

?>

<?php
function resolution($premise1, $premise2, $neg_literal)
{
    // return resolved premises
    // $premise1 is negated
    echo "data recieved in resolutnion \n";
    print_r($premise1);
    print_r($premise2);
    echo $neg_literal."\n";
    
    for($i = 0; $i < sizeof($premise1); $i++)
    {
        echo "working on ".$premise1[$i]."\n";
        if (strpos($premise1[$i], $neg_literal) !== false)
        {
            // match found
            echo "match found \n";
            array_splice($premise1, $i, 1);
        }
    }
    
    for($i = 0; $i < sizeof($premise2); $i++)
    {
        if (strpos($premise2[$i], $neg_literal) !== false)
        {
            // match found
            array_splice($premise2, $i, 1);
        }
    }
    
    $premise1 = resolution_util($premise1);
    $premise2 = resolution_util($premise2);
    
    
    return [implode($premise1, "<OR>"), implode($premise2, "<OR>")];
    
}

?>

<?php 
function simplify_by_resolution($premises)
{
    echo "primese recieved in main funcitno as \n";
    print_r($premises);
    $neg_found_once = false;
    $appropriate_premise_found_once = false;
    foreach ($premises as $premise)
{
  
    // now we have to find the appropriate premise
    $temp_array = explode("<OR>", $premise);
    //print_r($temp_array);
    
    // finding if any negated literal is present
    $neg_pres = false;
    $appropriate_premise_found = false;
    $cnt = 0;
    foreach ($temp_array as $literal)
    {
        //echo "working on ".$literal." returning ". strpos($literal, "<NEG>");
        if (strpos($literal, "<NEG>") !== false)
        {
            // echo "Negation is present ".$literal."<br>";
            
            // negation is found
            $neg_pres = true;
            $neg_found_once = true;
            $negated_literal_index = $cnt;
            
            // now an appropriate non negated form is to be found
            // if it is not found, we should iterate to the next one
            break;
            
        }
        
        $cnt ++;
        
    }
    
    if ($neg_pres === true)
    {
        // negation is already found
        echo "NEGATION FOUND IN ".$literal."<br>";
        // now an appropriate premise is to be found
        // if it is not found, we should iterate to the next one
        foreach ($premises as $other)
        {
            $temp_other = explode("<OR>", $other);
            // now the literals are exploded
            print_r($temp_other);
            $cnt = 0;
            foreach ($temp_other as $other_literal)
            {
                //echo "line no 44 <br>";
                //print_r(explode("<NEG>", $literal));
                
                
                if (strpos($other_literal, explode("<NEG>", $literal)[1]) !== false && strpos($other_literal, $literal) === false)
                {
                    // appropriate match for resolution found
                    $appropriate_premise_found = true;
                    $appropriate_premise_found_once = true;
                    
                    // now matching should be done
                    $param1 = implode($temp_array, "<OR>");
                    $param2 = implode($temp_other, "<OR>");
                    echo "candidates found as ".$param1." ".$param2." for ".$literal."\n";
                    
                    $resolved_val = resolution($temp_array, $temp_other, explode("<NEG>", $literal)[1]);
                    
                    
                    // echo "DELETING ".$premises[$negated_literal_index]." AND ".$premises[$cnt]." \n";
                    //array_splice($premises, $negated_literal_index, 1);
                    //array_splice($premises, $cnt - 1, 1);
                    
                    echo "resoved value ".$resolved_val[0]." and ".$resolved_val[1]." ".strlen($resolved_val[0])."\n";
                    
                    $push = true;
                    if ((strlen($resolved_val[0]) != 0) && (strlen($resolved_val[1])!=0))
                    {
                        echo "cond 1\n";
                        $new_premise = $resolved_val[0]."<OR>".$resolved_val[1];
                    }
                    else
                    {
                        echo "cond 2\n";
                        if (!empty($resolved_val[0]))
                        {
                            echo "cond 2.1\n";
                            $new_premise = $resolved_val[0];
                        }
                        
                        else if (!empty($resolved_val[1]))
                        {
                            echo "cond 2.2\n";
                            $new_premise = $resolved_val[1];
                        }
                        
                        else
                        {
                            $push = false;
                        }
                            
                    }
                    
                    // $new_premise = $resolved_val[0]."<OR>".$resolved_val[1];
                    if ($push)
                    {
                        array_push($premises, $new_premise);   
                    }
                    
                    print_r($resolved_val);
                    
                    // making the new array
                    $new_prm = [];
                    
                    
                    print_r($premises);
                    
                    echo "not adding ".$param1." ".$param2."\n";
                    foreach ($premises as $prem)
                    {
                        echo "ATTEMPTING TO ADD ".$prem." \n";
                        if ($prem == $param1 or $prem == $param2)
                        {
                            
                        }
                        else
                        {
                            if (!in_array($prem, $new_prm))
                            {
                                array_push($new_prm, $prem);
                            }
                            
                        }
                    }
                    
                    // now adding the new premises
                    if (!in_array($new_premise, $new_prm))
                    {
                        array_push($new_prm, $new_premise);
                    }
                    
                    
                    
                    $premises = $new_prm;
                    
                    echo "NEW PREMISES FOUND AS \n";
                    print_r($premises);
                    
                    
                    // now the the param1 and param 2 are to be deleted
                    break;
                }
                
                $cnt ++;
                
            }
        }
        
    }
    else
    {
        continue;
    }
}


print_r($premises);

if ($neg_found_once && $appropriate_premise_found_once)
{
    return simplify_by_resolution($premises);
}
else
{
    return $premises;
}
}

?>

<?php
$premises = ["<NEG>A", "A<OR>K<OR>C<OR>D", "<NEG>K", "T", "<NEG>T", "<NEG>C"];
$premises = simplify_by_resolution($premises);

echo "fully resolved premises \n";

print_r($premises);




?>
