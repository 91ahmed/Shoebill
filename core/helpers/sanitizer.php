<?php

	//	Sanitize numbers [-2, -1, 0, 1, 2, 3.5, 5.8]
	function sz_numeric ($value) 
	{
		$value = trim($value);
		return trim(preg_replace('/[^-?\d+(\.\d+)?]/', '', $value), '.');
	}	

	// Sanitize positive digits
	function sz_digits ($value) 
	{
		$value = trim($value);
		return preg_replace('/[^\d]/', '', $value);
	}

	// Sanitize integers
	function sz_integer ($value) 
	{
		$value = trim($value);
		return preg_replace('/[^-0-9]/', '', $value);
	}

	// Sanitize alphabetic characters
	function sz_alpha ($value)
	{
		$value = trim($value);
		return (string) preg_replace('/[^A-Za-z]/', '', $value);
	}	

	// Sanitize alphabetic characters + spaces
	function sz_alphas ($value)
	{
		$value = trim($value);
		return (string) preg_replace('/[^A-Za-z\s]/', '', $value);
	}

	// Sanitize alphanumeric
	function sz_alnum ($value)
	{
		$value = trim($value);
		return (string) preg_replace('/[^A-Za-z0-9]/', '', $value);
	}	

	// Sanitize alphanumeric + spaces
	function sz_alnums ($value)
	{
		$value = trim($value);
		return (string) preg_replace('/[^A-Za-z0-9\s]/', '', $value);
	}

	// Sanitize URL
	function sz_url ($value) 
	{
		$value = trim($value);
		return (string) filter_var($value, FILTER_SANITIZE_URL);
	}

	// Sanitize email
	function sz_email ($value) 
	{
		$value = trim($value);
		return (string) filter_var($value, FILTER_SANITIZE_EMAIL);
	}

	// Remove Special characters
	function sz_special ($value)
	{
	    // Allow letters, numbers, and spaces in any language
	    $value = preg_replace('/[^\p{L}\p{N}\s]/u', '', $value);
	    $value = trim($value);

	    return $value;
	}	

	// Remove Special characters and spaces
	function sz_special_s ($value)
	{
	    // Allow letters, numbers in any language
	    $value = preg_replace('/[^\p{L}\p{N}]/u', '', $value);
	    $value = trim($value);

	    return $value;
	}

?>