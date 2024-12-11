<?php
	
	/**
	 *	Return the given url
	 *	@param string $route
	 */
	function url (string $route = '/') 
	{
		$url = trim(DOMAIN, '/');
		$url = $url.'/'.trim($route, '/');

		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			throw new \Exception("Not Valid URL ($url)", 1);
			exit();
		}

		return (string) trim($url, '/');
	}

	/**
	 *	Redirect web page to a specific route.
	 *
	 *	@param string, $route
	 *	@return void
	 */
	function redirect (string $route = '/')
	{
		$url = trim(DOMAIN, '/');
		$url = $url.'/'.trim($route, '/');

		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			throw new \Exception("Not Valid URL ($url)", 1);
			exit();
		}

		return header ("Location:".$url);
		exit();
	}

	/**
	 *	Redirect webpage back to the previous route.
	 *
	 *	@return void
	 */
	function redirect_back ()
	{
		if (isset($_SERVER['HTTP_REFERER'])) {
			return header ("Location:".$_SERVER['HTTP_REFERER']);
		} else {
			return header("location:javascript://history.go(-1)");
		}

		exit();
	}

	/**
	 *	Access public folder
	 *	@param string $filePath
	 */
	function assets (string $filePath = '/') 
	{
		$url = trim(DOMAIN, '/');
		$url = $url.'/public/'.trim($filePath, '/');

		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			throw new \Exception("Not Valid URL ($url)", 1);
			exit();
		}

		return (string) trim($url, '/');
	}

	function request ($value)
	{
		if (isset($_REQUEST[$value]))
		{
			if (is_array($_REQUEST[$value])) {
				$arr = [];

				if (!empty($_REQUEST[$value])) {
					foreach ($_REQUEST[$value] as $v) {
						array_push($arr, trim($v));
					}
				}

				return $arr;
			} else {
				return trim($_REQUEST[$value]);
			}
		}
		else
		{
			return false;
		}
	}

	function is_request (string $value) 
	{
		return isset($_REQUEST[$value]);
	}

	function delete_dir (string $dirPath) 
	{
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            deleteDir($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	}
?>