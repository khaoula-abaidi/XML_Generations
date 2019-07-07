<?php
$xml = simplexml_load_file('password.xml');
$xml->registerXPathNamespace('xmlns','http://www.w3.org/2005/Atom');
$xml->registerXPathNamespace('xmlns:sword','http://purl.org/net/sword/');
$xml->registerXPathNamespace('xmlns:dcterms','http://purl.org/dc/terms/');
$xml->registerXPathNamespace('xmlns:hal','http://hal.archives-ouvertes.fr/');
$result1 = $xml->xpath("//xmlns:password");
foreach ($result1 as $item) echo "password : ".$item."\n";
$result1 = $xml->xpath("//xmlns:id");
foreach ($result1 as $item) echo "id : ".$item."\n";
function extractIdhal($filename){
    $xml = file_get_contents($filename);
    $ns = preg_replace('/(xmlns)[^=]*="[^"]*" ?/i','',$xml);
    $xmlElement = simplexml_load_string($ns);
    $result = $xmlElement->xpath("//password");
    return $result;
}
var_dump(extractIdhal('password.xml'));
?>