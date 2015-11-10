<?php
// ------------------------------------------------------
// dir2json - v0.1.1b
//
// by Ryan, 2015
// http://www.ryadel.com/
// ------------------------------------------------------
// Type the following for help:
//   > php dir2json -h
// ------------------------------------------------------
function dir2json($dir)
{
    $a = [];
    if($handler = opendir($dir))
    {
        while (($content = readdir($handler)) !== FALSE)
        {
            if ($content != "." && $content != ".." && $content != "Thumb.db")
            {
                if(is_file($dir."/".$content)) $a[] = $content;
				else if(is_dir($dir."/".$content)) $a[$content] = dir2json($dir."/".$content); 
            } 
        }    
        closedir($handler); 
    } 
    return $a;    
}
$argv1 = $argv[1];
if (stripos($argv1,"-h") !== false) 
{
echo <<<EOT
------------------------------------------------------
dir2json - v0.1.1b

by Ryan, 2015
http://www.ryadel.com/
------------------------------------------------------
		
USAGE (from CLI):
 > php dir2json <targetFolder> <outputFile> [JSON_OPTIONS]

EXAMPLE:
 > php dir2json ./images out.json JSON_PRETTY_PRINT

HELP:
 > php dir2json -h
		
JSON_OPTIONS is a bitmask consisting of:
  JSON_HEX_QUOT, JSON_HEX_TAG, JSON_HEX_AMP, JSON_HEX_APOS, JSON_NUMERIC_CHECK, 
  JSON_PRETTY_PRINT, JSON_UNESCAPED_SLASHES, JSON_FORCE_OBJECT, JSON_PRESERVE_ZERO_FRACTION, 
  JSON_UNESCAPED_UNICODE, JSON_PARTIAL_OUTPUT_ON_ERROR

The behaviour of these constants is described on the JSON constants page:
  http://php.net/manual/en/json.constants.php

for further info on PHP's json_encode function, read here:
  http://php.net/manual/en/function.json-encode.php

------------------------------------------------------
EOT;
    exit;
}

$argv2 = $argv[2];
$argv3 = $argv[3];
if (empty($argv3)) $argv3 = 0;
else $argv3 = constant($argv3);

if (empty($argv2)) {
    echo "invalid arguments";
	exit;
}

$arr = dir2json($argv1);
$json = json_encode($arr, $argv3);
file_put_contents($argv2, $json);
?>
