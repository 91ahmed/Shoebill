<?php
	namespace App\Controller;

	use Core\Modules\Template\Render;
	use App\Model\Users;

	class HomeController 
	{
		public function index () 
		{
			$users = new Users();
			$all = $users->select(['*'])->fetch();

			Render::view('home', compact('all'));
		}

		public static function admin () 
		{
			return 'ahmed hassan';
		}
	}
?>