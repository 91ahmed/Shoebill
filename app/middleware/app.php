<?php
	namespace App\Middleware;

	use Core\Modules\Sessions\Session;

	class App
	{
		public function __construct ()
		{
			$session = new Session();
			$session->start();
		}
	}
?>