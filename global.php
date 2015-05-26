<?php 
set_time_limit(0);
//error_reporting(E_ALL);
//ini_set("display_errors", 1);
ini_set('memory_limit', -1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
<div id="container">
<?php

$found = false;

// Start the timer - will be used with stats switch only
//$startTime = microtime(true);
function mysearch($pattern = '' , $file_type='' , $path = ''){

global $found;

foreach(glob($path.'*.'.$file_type) as $filename)
{
    //echo 'checking in file : ' . $filename. '<br><br>';
  foreach(file($filename) as $fli=>$fl)
  {
    if(strpos($fl, $pattern)!==false)
    {
        $found = true;
      echo $filename.' on line '.($fli+1) . '<br><br>';
    }
  }
}

$paths = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR);

foreach ($paths as $patht) { 
        mysearch($pattern,$file_type,$patht);
    }

}


if(isset($_POST['submit'])){
// Get passed args
$pattern = $_POST['pattern'];
$path = $_POST['path'];
$file_type = $_POST['file_type'];
//$format = $_POST['format'];

$current_file_path = dirname(__FILE__);

//echo $current_file_path;exit;

echo 'Search For : ' . $pattern . '<br><br>';

if(!($found)){
    //echo 'No result found';
}

$path_to_check =  $current_file_path . DIRECTORY_SEPARATOR . $path;

//echo $path_to_check;exit;

mysearch($pattern , $file_type ,$path_to_check);
} else {
//exit;

?>

<form action="" method="post" class="niceform">
	<fieldset>
    	<legend>Search Options</legend>
        <dl>
            <dt><label for="pattern">Search Pattern</label></dt>
            <dd><input type="text" name="pattern" id="pattern" size="32" maxlength="128" /></dd>
        </dl>
        <dl>
            <dt><label for="path">Work Path</label></dt>
            <dd><input type="text" name="path" id="path" value="" size="32"  /></dd>
        </dl>
        <dl>
            <dt><label for="file_type">File Type</label></dt>
            <dd><select id="file_type" name="file_type"  >
                <option value="*" selected="" >All</option>
                <option value="php"  >PHP</option>
                <option value="html" >HTML</option>
                <option value="sql" >SQL</option>
                <option value="tpl" >tpl</option>
                <option value="css" >css</option>
                <option value="js" >js</option>
                <option value="xml" >xml</option>
                <option value="phtml" >phtml</option>
            </select></dd>
        </dl>
    </fieldset>
    <fieldset class="action">
    	<input type="submit" name="submit" id="submit" value="Search" />
    </fieldset>
</form>

<?php
}
?>
</div>
</body>
</html>