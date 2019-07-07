<?php
require 'Utilities.php';
function extractIdhal($filename){
    $xml = file_get_contents($filename);
    $ns = preg_replace('/(xmlns|xsi)[^=]*="[^"]*" ?/i','',$xml);
    $xmlElement = simplexml_load_string($ns);
    $result = $xmlElement->xpath("//idno[@type='halId']");
    return $result;
}
$xml = file_get_contents('tei.xml');
$ns = preg_replace('/(xmlns|xsi)[^=]*="[^"]*" ?/i','',$xml);
$xmlElement = simplexml_load_string($ns);
$result = $xmlElement->xpath("//idno[@type='halId']");
foreach ($result as $item) echo $item."\n";
echo(extractIdhal('tei.xml')[0]->__toString());
echo '---------------------------------\n\n';
$util = new Utilities();
var_dump($util->generateTei());
?>