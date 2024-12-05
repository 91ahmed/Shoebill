<?php
	namespace App\Model;

	use Core\Modules\Database\Sql\Db;

	class Users extends Db
	{
		protected $table = 'users';

		/** Configure new connection
		----------------------------
		protected $connection = [
			'driver' => 'pgsql',
			'host' => 'localhost',
			'user' => 'ahmed',
			'password' => '24882533',
			'database' => 'sys',
			'port' => '5432'
		];
		**/
	}
?>