<?php
$zip = zip_open("depot.zip");

if ($zip)
{
    while ($zip_entry = zip_read($zip))
    {

        echo "<p>";
        echo "Name: " . zip_entry_name($zip_entry) . "<br />";
        if (strpos(zip_entry_open($zip, $zip_entry),'.xml')!==false)
        {
           echo 'xml dans '.zip_entry_name($zip_entry).' a la position '.strpos(zip_entry_open($zip, $zip_entry),'xml');
        }
        echo "</p>";
    }
    zip_close($zip);
}
?>