<?php 
    function remove_premises($premises)  
    {
        $new_premises = [];
        
        foreach ($premises as $p)
        {
            if (in_array($p, $new_premises) === false)
            {
                array_push($new_premises, $p);
            }
        }
        
        return $new_premises;
        
    }

?>

<?php function intra_premise($s)
{
    $a = explode("<OR>", $s);
    
    // echo "a \n";
    // print_r($a);
    $new = [];
    $del = [];
    
    for ($i = 0; $i < count($a); $i++)
    {
        // echo "working on ".$a[$i]." \n";
        if (strpos($a[$i], "<NEG>") !== false)
        {
            // echo "negation found \n";
            array_push($del, $a[$i]);
        }
    }
    
    // print_r($del);
    // echo "\n";
    
    for ($i = 0; $i < count($a); $i++)
    {
        if (in_array($a[$i], $del) === false && in_array("<NEG>".$a[$i], $del) === false && in_array($a[$i], $new) === false)
        {
            array_push($new, $a[$i]);
        }
    
    }
    
    for ($i = 0; $i < count($del); $i++)
    {
        if (in_array(substr($del[$i], 5, strlen($del[$i])), $a) === false)
        {
            array_push($new, $del[$i]);
        }
    
    }
    
    return implode("<OR>", $new);
}
    
?>

<?php 

    function resolution_util($premise)
    {
        
        // echo "resolution_util recieved ".sizeof($premise)."\n";
        // print_r($premise);
        for($i = 0; $i < sizeof($premise); $i++)
        {
            // echo $i;
            if (empty($premise[$i]))
            {
                // match found
                // echo "match found \n";
                array_splice($premise, $i, 1);
                
                return resolution_util($premise);
            }
        }
        
        // echo "returned \n";
        // print_r($premise);
        
        return $premise;
    }

?>

<?php
function resolution($premise1, $premise2, $neg_literal)
{
    // return resolved premises
    // $premise1 is negated
    // echo "data recieved in resolutnion \n";
    // print_r($premise1);
    // echo "\n";
    // print_r($premise2);
    // echo "\n";
    // echo $neg_literal."\n";
    
    $premise1 = explode("<OR>", $premise1);
    $premise2 = explode("<OR>", $premise2);
    
    for($i = 0; $i < sizeof($premise1); $i++)
    {
        // echo "working on ".$premise1[$i]."\n";
        if (strpos($premise1[$i], $neg_literal) !== false)
        {
            // match found
            // echo "match found \n";
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
    
      
    
    if (count($premise1) == 0)
    {
        
        if (count($premise2) == 0)
        {
            
            return [];
        }
        
        else
        {
            return [implode("<OR>", $premise2)];
        }
        
    }
    else
    {
        if (empty($premise2))
        {
            
            return [implode("<OR>", $premise1)];
        }
        
        else
        {
            return [implode("<OR>", $premise1), implode("<OR>", $premise2)];
        }
        
        
    }
    
    
    
}

?>

<?php 
function simplify_by_resolution($premises)
{
    
    echo "primeses recievied as \n";
    print_r($premises);
    
    
    $work = false;
    $deletable = [];
    // loop one
    // for getting each premise
    for($l1 = 0; $l1 < count($premises); $l1 ++)
    {
        
        // echo "premise 1 ".$premises[$l1]."\n";
        //now exploding each premise
        $candidate = explode("<OR>", $premises[$l1]);
        
        
        // loop2 for each literal of a premise
        for($l2 = 0; $l2 < count($candidate); $l2++)
        {
            // now $candidate[$l2] has the words
           
            // if there is a negation, then we can proceed
            if (strpos($candidate[$l2], "<NEG>") !== false)
            {
                // starting the loop now
                // findig pair
                
                $findable = substr($candidate[$l2], 5, strlen($candidate[$l2]));
                // loop 3 for premieses
                for($l3 = 0; $l3 < count($premises); $l3 ++)
                {
                    $poss_match = explode("<OR>", $premises[$l3]);
                    //echo "checking in ".$premises[$l3]."\n";
                    
                    
                    // now loop for poss match
                    for($l4 = 0; $l4 < count($poss_match); $l4 ++)
                    {
                        
                        
                        // finding between $poss_match[$l4] == $findable
                        //echo "finding between ".$poss_match[$l4]." and ".$findable."\n";
                        
                        if ($poss_match[$l4] == $findable)
                        {
                            // match found
                            echo "match is found between ".$premises[$l1]." and ".$premises[$l3]."\n";
                            
                            array_push($deletable, $premises[$l1]);
                            array_push($deletable, $premises[$l3]);
                            
                            
                            // echo "omitting ".$findable."\n";
                            $work = true;
                            
                            $ret = resolution($premises[$l1], $premises[$l3], $findable);
                            
                            
                            
                            // print_r($ret);
                            
                            if (count($ret) == 2)
                            {
                                $ins = $ret[0]."<OR>".$ret[1];
                                
                            }
                            
                            else if (count($ret) > 0)
                            {
                                $ins = $ret[0];
                            }
                            
                            $ins = intra_premise($ins);
                            
                            if (count($ret) > 0)
                            {
                                array_push($premises, $ins);
                            }
                            
                            
                        }
                        
                        
                        if ($work === true)
                        {
                            break;
                        }
                        
                        
                        
                    }
                    
                    if ($work === true)
                        {
                            break;
                        }
                    
                    
                }
                
                
            }
            
            if ($work === true)
                        {
                            break;
                        }
            
            
        }
        
        if ($work === true)
                        {
                            break;
                        }
        
    }
    
    
    if ($work === true)
    {
        // deleting the previous ones
        for($d1 = 0; $d1 < count($premises); $d1++)
        {
            if ($premises[$d1] == $deletable[0])
            {
                // echo "deleting ".$deletable[0]."\n";
                array_splice($premises, $d1, 1);
                break;
            }
        }
    
        for($d2 = 0; $d2 < count($premises); $d2++)
        {
            if ($premises[$d2] == $deletable[1])
            {
                //echo "deleting ".$deletable[1]."\n";
                array_splice($premises, $d2, 1);
                break;
            }
        }
    }
    
    $premises = resolution_util($premises);
    $premises = remove_premises($premises);
    
    if ($work === true)
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
$premises = ["A<OR>B<OR>C<OR>D", "<NEG>A<OR>B", "<NEG>D<OR>B"];
$premises = simplify_by_resolution($premises);

echo "fully resolved premises \n";

print_r($premises);

// $s = "<NEG>C";
// echo intra_premise($s)."\n";


// echo intra_premise("<NEG>C<OR>B<OR>C<OR><NEG>B");
// echo "\n";




?>
