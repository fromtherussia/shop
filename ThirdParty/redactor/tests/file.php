<?php

include "../config.php";

if (isset($_GET['file']))
{
	get_file($_GET['file']);
	exit;
}

if (isset($_GET['delete']))
{
	unlink(FILES_ROOT.$_GET['delete']);
	exit;
}

if (!empty($_FILES['file']['name']))
{		
	
	$file_size = $_FILES['file']['size'];
	$file_type = info($_FILES['file']['name'], 'type');
	$file_name = str_replace('.'.$file_type, '', $_FILES['file']['name']);		

	// $file_id = md5(date('YmdHis').$file_name);
	
	$file_name = get_filename(FILES_ROOT, $_FILES['file']['name'], $file_type);


	$file_ico = get_ico($file_type);
	
	$file = FILES_ROOT.$file_name;
	copy($_FILES['file']['tmp_name'], $file);
	
	
	echo '<a href="javascript:void(null);" rel="'.$file_name.'" class="redactor_file_link redactor_file_ico_'.$file_ico.'">'.$file_name.'</a>';
}	

function get_file($file)
{
	download(FILES_ROOT.$file);
}

function get_ico($type)
{
	$fileicons = array('other' => 0, 'avi' => 'avi', 'doc' => 'doc', 'docx' => 'doc', 'gif' => 'gif', 'jpg' => 'jpg', 'jpeg' => 'jpg', 'mov' => 'mov', 'csv' => 'csv', 'html' => 'html', 'pdf' => 'pdf', 'png' => 'png', 'ppt' => 'ppt', 'rar' => 'rar', 'rtf' => 'rtf', 'txt' => 'txt', 'xls' => 'xls', 'xlsx' => 'xls', 'zip' => 'zip');

	if (isset($fileicons[$type])) return $fileicons[$type];
	else return 'other';
}

function get_filename($path, $filename, $file_type)
{
	if (!file_exists($path.$filename)) return $filename;

	$filename = str_replace('.'.$file_type, '', $filename);
	
	$new_filename = '';
	for ($i = 1; $i < 100; $i++)
	{			
		if (!file_exists($path.$filename.$i.'.'.$file_type))
		{
			$new_filename = $filename.$i.'.'.$file_type;
			break;
		}
	}

	if ($new_filename == '') return false;
	else return $new_filename;		
}	

function info($file, $key = false)
{
	$info = array();
	$array = explode(".", $file);

	$info['size'] = @filesize($file);
	//$info['time'] = filectime($file);
   	$info['type'] = end($array);
	$info['name'] = str_replace('.'.$info['type'], '', $file);
	$info['image'] = false;

	if ($info['type'] == 'JPG' ||
		$info['type'] == 'jpg' ||
		$info['type'] == 'gif' ||
		$info['type'] == 'png')
	{
		$info['image'] = true;
	}

	if (!$key) return $info;
	else return $info[$key];

}


function download($filename, $filenamef = false, $mimetype='application/octet-stream')
{
	if (!file_exists($filename)) die('File not found');

	$from = $to = 0;
	$cr = NULL;

	if (isset($_SERVER['HTTP_RANGE']))
	{
		$range = substr($_SERVER['HTTP_RANGE'], strpos($_SERVER['HTTP_RANGE'], '=')+1);
		$from = strtok($range, '-');
		$to = strtok('/');
		if ($to>0) $to++;
		if ($to) $to-=$from;
		header('HTTP/1.1 206 Partial Content');
		$cr = 'Content-Range: bytes ' . $from . '-' . (($to)?($to . '/' . $to+1):filesize($filename));
	}
	else header('HTTP/1.1 200 Ok');

	if ($filenamef === false) $filenamef = $filename;

	$etag = md5($filename);
	$etag = substr($etag, 0, 8) . '-' . substr($etag, 8, 7) . '-' . substr($etag, 15, 8);
	header('ETag: "' . $etag . '"');
	header('Accept-Ranges: bytes');
	header('Content-Length: ' . (filesize($filename)-$to+$from));
	if ($cr) header($cr);
	header('Connection: close');
	header('Content-Type: ' . $mimetype);
	header('Last-Modified: ' . gmdate('r', filemtime($filename)));
	$f = fopen($filename, 'r');
	header('Content-Disposition: attachment; filename="' . basename($filenamef) . '";');
	if ($from) fseek($f, $from, SEEK_SET);
	if (!isset($to) || empty($to)) $size=filesize($filename)-$from;
	else $size=$to;
	$downloaded = 0;
	while(!feof($f) && !connection_status() && ($downloaded<$size))
	{
		echo fread($f, 512000);
		$downloaded+=512000;
		flush();
	}
	fclose($f);
}
	
?>