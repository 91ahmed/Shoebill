<?php
	namespace Core\Globals;

	use App\Controller\HomeController;

	class Publisher
	{
		private $globals = array();

		public function __construct ()
		{
			$this->publish('admin', HomeController::admin());
			$this->publish('users', ['omar','sayed','tamer']);
			$this->publish('note',  'welcome to my framework');
		}

		public function data ()
		{
			return $this->globals;
		}

		private function publish ($key, $value)
		{
			array_push($this->globals, [$key => $value]);
		}
	}
?>