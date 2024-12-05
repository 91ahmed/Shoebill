<?php
	/**
	 *	Generate random characters
	 *	
	 *	@param integer $length, default 10
	 *	@return string
	 */
	function gn_char (int $length = 10) 
	{
		$char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$char = str_shuffle($char);
		$charLength = strlen($char);
		$random = null;

		for ($i = 0; $i < $length; $i++) {
			$random .= $char[rand(0, $charLength - 1)];
		}

		return $random;
	}

	/**
	 *	Generate random characters include some special chars
	 *	
	 *	@param integer $length, default 10
	 *	@return string
	 */
	function gn_schar (int $length = 10) 
	{
		$char = '@#$&_0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$char = str_shuffle($char);
		$charLength = strlen($char);
		$random = null;

		for ($i = 0; $i < $length; $i++) {
			$random .= $char[rand(0, $charLength - 1)];
		}

		return $random;
	}

	/**
	 *	Generate random integer
	 *	
	 *	@param integer $length, default 10
	 *	@return integer
	 */
	function gn_int (int $length = 10) 
	{
		$char = '0123456789';
		$char = str_shuffle($char);
		$charLength = strlen($char);
		$random = null;

		for ($i = 0; $i < $length; $i++) {
			$random .= $char[rand(0, $charLength - 1)];
		}

		return $random;
	}

	/**
	 *	Generate random letters
	 *	
	 *	@param integer $length, default 10
	 *	@return string
	 */
	function gn_str (int $length = 10) 
	{
		$char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$char = str_shuffle($char);
		$charLength = strlen($char);
		$random = null;

		for ($i = 0; $i < $length; $i++) {
			$random .= $char[rand(0, $charLength - 1)];
		}

		return $random;
	}
?>