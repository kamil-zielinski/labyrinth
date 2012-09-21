<?php

require_once "Labyrinth.php";

/*
 * Labyrinth structure model
 * Each tile has movement possibility represented by binary number - 1 means opportunity to pass
 * Four walls counting starts from top, clockwise
 * e.g. tile with left and righ wall is represented as 0101(2) = 5(10)
 */
$labStructure = array(
                    array(6,10,14,14,14,10,12,4),
                    array(5,2,9,1,5,4,7,9),
                    array(5,4,1,4,5,5,1,4),
                    array(5,5,6,9,1,7,14,13),
                    array(5,5,3,14,14,9,5,1),
                    array(5,3,10,13,5,4,3,12),
                    array(5,6,10,9,1,7,12,5),
                    array(3,11,10,10,10,9,1,1)
                );

/* Test structure
$labStructure2 = array(
                    array(6,10,14,14,14,10,12,4),
                    array(5,2,9,1,5,4,7,9),
                    array(5,4,1,4,5,5,1,4),
                    array(7,13,6,9,1,7,14,13),
                    array(5,5,3,14,14,9,5,1),
                    array(5,3,10,13,5,4,3,12),
                    array(5,6,10,9,1,7,12,5),
                    array(1,11,10,10,10,9,1,1)
                );
*/

$lab = new Labyrinth($labStructure,array(0,0),array(7,7));
$path = $lab->findPath();

echo "Steps to pass labyrinth [x:y]:\n";
$i=1;
foreach($path as $step){
    echo $i++.'. '.$step['x'].':'.$step['y']."\n";
}
