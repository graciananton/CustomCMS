<?php
function calculateOperations($n){
    $operations = 0;
    // n = 5
    for($i=1;$i<=$n;$i++){
        //i=1
        //i=2
        //i=3
        //i=4
        for($j=1;$j<=$i;$j++){

            $operations++;
        }
    }
    return $operations;
}
$n = 1;
echo "".calculateOperations($n);