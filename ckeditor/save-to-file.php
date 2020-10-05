<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 777)
	die();

require_once 'JSLikeHTMLElement.php';

// XSS handling required
$contentId = $_POST['contentId'];
$content =  $_POST['content'];

$filePath = '../index.php';//preg_replace('%^(/*)[^/]+%', '$2..', $pageId);
$pageContent = file_get_contents($filePath);
$error = false;

$doc = new DOMDocument();

$doc->registerNodeClass('DOMElement', 'JSLikeHTMLElement');
if (!$doc->loadHTML(mb_convert_encoding($pageContent, 'HTML-ENTITIES', 'UTF-8'))) {
	$error = 'Could not load HTML';
} else {
	$elem = $doc->getElementById($contentId);
	
	// set innerHTML
	$elem->innerHTML = strtr($content, array('<?php'=>'&#60;?php', '?>'=>'?&#62;'));
	
	$output = trim(strtr($doc->saveHTML(), array(
		'&lt;?php' => '<?php',
		'?&gt;' => '?>',
		'<!DOCTYPE html>' => '',
		'<html' => '<!DOCTYPE html><html'
	)));
	
	if (get_magic_quotes_gpc()) {
		$output = stripslashes($output);
	}
	
	if (!file_put_contents($filePath, $output)) {
		$error = 'Could not update file.';
	}

}

if ( !empty($error) ) {
	//error_log("\nerror: ".print_r($error, true), 3, "demo-app.log");
} else {
	echo 'Content saved.';
}

?>