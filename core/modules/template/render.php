<?php
	namespace Core\Modules\Template;

	use Jenssegers\Blade\Blade;
	use Core\Globals\Publisher;

	class Render 
	{
		public static function view (String $view, $data = []) 
		{
			// Push global data to the array
			$publisher = new Publisher();
			$globals = $publisher->data();

			foreach ($globals as $key => $val) {
				$k = array_keys($globals[$key])[0];
				$v = array_values($globals[$key])[0];

				$data[$k] = $v;
			}

			// Render Blade
			$blade = new Blade(
				ROOT.DS.'app'.DS.'view',  // Views Path
				ROOT.DS.'core'.DS.'cache'.DS.'views' // Cache Path
			);

			echo $blade->render($view, $data);
		}
	}

?>