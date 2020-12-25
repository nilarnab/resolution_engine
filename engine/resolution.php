<?php 
function resolution($premise1, $premise2)
{
    
    // return resolved premises
}

?>


<?php
$premises = ["<NEG>A<OR>B", "B<OR>C", "A<OR>C<OR>D"];
print_r($premises);

foreach ($premises as $premise)
{
    // now we have to find the appropriate premise
    $temp_array = explode("<OR>", $premise);
    //print_r($temp_array);
    
    // finding if any negated literal is present
    $neg_pres = false;
    $appropriate_premise_found = false;
    foreach ($temp_array as $literal)
    {
        //echo "working on ".$literal." returning ". strpos($literal, "<NEG>");
        if (strpos($literal, "<NEG>") !== false)
        {
            // echo "Negation is present ".$literal."<br>";
            
            // negation is found
            $neg_pres = true;
            
            // now an appropriate non negated form is to be found
            // if it is not found, we should iterate to the next one
            break;
            
        }
        
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
            foreach ($temp_other as $other_literal)
            {
                //echo "line no 44 <br>";
                //print_r(explode("<NEG>", $literal));
                
                
                if (strpos($other_literal, explode("<NEG>", $literal)[1]) !== false && strpos($other_literal, $literal) === false)
                {
                    // appropriate match for resolution found
                    $appropriate_premise_found = true;
                    
                    // now matching should be done
                    $param1 = implode($temp_array, "<OR>");
                    $param2 = implode($temp_other, "<OR>");
                    echo "candidates found as ".$param1." ".$param2;
                    
                    // now the the param1 and param 2 are to be deleted
                    break;
                }
                
            }
        }
        
    }
    else
    {
        continue;
    }
}
?>
