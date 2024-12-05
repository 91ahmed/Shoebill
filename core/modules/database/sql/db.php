<?php
	namespace Core\Modules\Database\Sql;

	use Core\Modules\Database\Sql\Builder;
	use Core\Modules\Database\Pdo\Connect;

	class Db extends Builder
	{
		use Connect;

		protected $connection = [];
		protected $db;

		public function __construct (array $connect = []) 
		{
			if (!empty($this->connection)) {
				$connect = $this->connection;
			}

			if (count($connect) > 0) {
				foreach ($connect as $key => $value) {
					$this->set($key, $value);
				}
			}

			$this->db = $this->pdo();
		}

		public function beginTransaction () 
		{
			return $this->db->beginTransaction();
		}

		public function commit () 
		{
			return $this->db->commit();
		}

		public function rollBack () 
		{
			return $this->db->rollBack();
		}

		/**
		 *	Returns an object containing all of the result set rows.
		 *	@return object
		 */
		public function fetch ()
		{
			// SQL Query
			$stmt = $this->db->prepare($this->query);
			$stmt->execute($this->data);
			$result = $stmt->fetchAll();

			$this->query = null;
			$this->data = [];

			// result
			return (object) $result;
		}

		/**
		 *	Fetches the next row from a result set.
		 *	@return object
		 */
		public function fetch_row ()
		{
			// SQL Query
			$stmt = $this->db->prepare($this->query);
			$stmt->execute($this->data);
			$result = $stmt->fetch();

			$this->query = null;
			$this->data = [];

			// result
			return (object) $result;
		}

		/**
		 *	Execute sql query.
		 *	@return void
		 */
		public function execute ()
		{
			// Execute Query
			$stmt = $this->db->prepare($this->query);
			$stmt->execute($this->data);

			$this->query = null;
			$this->data = [];
		}

		public function paginate ($rowsCount, $pageNumber = 1)
		{
			// Get rows count
			$count = $this->db->prepare("SELECT * FROM {$this->table}");
			$count->execute();
			$rows_count = $count->rowCount();
			
			// Rows at page
			$rows_at_page = $rowsCount;
			
			// Pages count
			$pages_counts = (int)ceil($rows_count / $rows_at_page);
			$this->pages = $pages_counts;
			
			if (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) {
				$pageNumber = $_REQUEST['page'];
			}

			// Start
			$start = ($pageNumber - 1) * $rows_at_page;
			
			// End
			$end = $rows_at_page;

			if ($this->config['driver'] === 'mysql' || $this->config['driver'] === 'sqlite')
			{
				$this->query .= " LIMIT {$start}, {$end}"; // LIMIT offset, limit
			} 
			else if ($this->config['driver'] === 'pgsql')
			{
				$this->query .= " offset {$start} limit {$end}";
			}

			// Execute Query
			$stmt = $this->db->prepare($this->query);
			$stmt->execute($this->data);
			$result = $stmt->fetchAll();

			$this->query = null;
			$this->data = [];

			if ($pageNumber > $this->pages) {
				return array();
			} else if (empty($result)) {
				return array();
			} else {
				return (object) $result;
			}
		}

		public function close ()
		{
			$this->db = null;
			unset($this->db);
		}

		public function __destruct ()
		{
			$this->db = null;
			unset($this->db);
		}
	}

/*
$query = new Db();

try 
{
	$query->table('users');

	$query->beginTransaction(); // Begin transaction

	$query->insert([
		'name' => 'nadia',
		'email' => 'nadia@gmail.com'
	])->execute();

	$res = $query->select(['name'])->fetch();

	var_dump($res);

	$query->commit(); // Commit
} 
catch (\Exception $e) 
{
	echo $e->getMessage();

	$query->rollBack(); // Roll back
}
*/

?>