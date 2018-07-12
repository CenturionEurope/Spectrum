<?php
// Setup LESS Compiler
header("Content-type: text/css; charset: UTF-8");
chdir('Libraries/lessphp');
require("lessc.inc.php");
$less = new lessc;
chdir('../../../../LESS/');


$LESSFiles = scandir('./');
$LESSFiles = array_diff($LESSFiles, array('.', '..', '.DS_Store', 'lessCache.cache', 'lessHash.cache'));
$LESSFiles = array_values($LESSFiles);
$TotalMD5 = '';
foreach($LESSFiles as $LESSFile){
	$TotalMD5 .= md5_file($LESSFile);
}
$TotalMD5 = md5($TotalMD5);
if($TotalMD5!=file_get_contents('lessHash.cache')){
	// There has been a change in the Working copy. Update the LESS
	$CompiledLess = $less->compileFile('build.cole.less');
	$CompiledLess = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $CompiledLess );
	$CompiledLess = str_replace( array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $CompiledLess );		
	file_put_contents('lessHash.cache', $TotalMD5);
	file_put_contents('lessCache.cache', $CompiledLess);
}else{
	// Use the cache
	$CompiledLess = file_get_contents('lessCache.cache');
}


// Output the less
echo $CompiledLess;	
?>