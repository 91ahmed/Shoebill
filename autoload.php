<?php

	spl_autoload_register( function ($className) 
	{
		$lastNsPos = strrpos($className, '\\');
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName  = strtolower($namespace).'/'.$className.'.php';
		$file      = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, __DIR__.DIRECTORY_SEPARATOR.strtolower($fileName));

		if (file_exists($file) && is_file($file))
		{
			require ($file);
		}
	});	
?>