<?php
	
	namespace Core\Modules\Database\Pdo;

	trait Connect 
	{
		public $config = [
			'driver'   => DB_DRIVER, // mysql - sqlsrv - pgsql - sqlite
			'host'     => DB_HOST, // localhost - 127.0.0.1 - https://www.example.com
			'database' => DB_NAME, // database name
			'user'     => DB_USER, // database username
			'password' => DB_PASSWORD, // database password
			'port'     => DB_PORT, // mysql (3306) - pgsql (5432) - sqlsrv (1433)
			'charset'  => DB_CHARSET,
			'sslmode'  => DB_SSLMODE,// 'disable'
			'sqlite'   => DB_SQLITE // 'storage/sqlite/restful.db'
		];

		/**
		 *	@var array $options, PDO mysql options.
		 */
		private $options = [
			\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
		];

		/**
		 *	@var object $connect, Holds PDO connection object.
		 */
		private $connect;

		/**
		 *	@var string $sqlite, store the sqlite file path.
		 */
		private $sqlite = 'storage/sqlite/restful.db';

		/**
		 *	Connect to MySQL.
		 *
		 *	@return void
		 */
		private function mysql ()
		{
			$this->connect = new \PDO("mysql:host={$this->config['host']};port={$this->config['port']};dbname={$this->config['database']};charset={$this->config['charset']}", $this->config['user'], $this->config['password'], $this->options);
		}

		/**
		 *	Connect to PostgreSQL.
		 *
		 *	@return void
		 */
		private function postgresql ()
		{
			$this->connect = new \PDO("pgsql:host={$this->config['host']};port={$this->config['port']};dbname={$this->config['database']};sslmode={$this->config['sslmode']}", $this->config['user'], $this->config['password']);
		}

		/**
		 *	Connect to Microsoft SQL Server.
		 *
		 *	@return void
		 */
		private function sqlserver ()
		{
			$this->connect = new \PDO("sqlsrv:Server=".$this->config['host'].";Database=".$this->config['database']."", $this->config['user'], $this->config['password']);
		}

		/**
		 *	Connect to SQLite
		 *
		 *	@return void
		 */
		private function sqlite ()
		{
			$this->connect = new \PDO("sqlite:".$this->config['sqlite']);
		}

		/**
		 *	Set connection information.
		 *
		 *	@param string $key, database config key
		 *	@param mixed $value, database config value
		 *	@return void
		 */
		public function set ($key, $value)
		{
			$this->config[$key] = $value;
		}

		/**
		 *	Detect the database driver.
		 *
		 *	@return void
		 */
		private function detect ()
		{
			switch ($this->config['driver'])
			{
				case 'mysql':
					$this->mysql();
					break;
				case 'pgsql':
					$this->postgresql();
					break;
				case 'sqlsrv':
					$this->sqlserver();
					break;
				case 'sqlite':
					$this->sqlite();
					break;
				default:
					throw new \Exception("Undefined database driver ({$this->config['driver']})", 1);
			}
		}

		/**
		 *	Open database connection
		 *
		 *	@return object, PDO connection
		 */
		public function pdo ()
		{
			try 
			{
				$this->detect();
				//$this->connect->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
				$this->connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
				$this->connect->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
				$this->connect->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_NATURAL);
			}
			catch (\PDOException $e) 
			{
				throw new \Exception($e->getMessage(), 1);
			}

			return $this->connect;
		}
	}
?>