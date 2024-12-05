<?php
	namespace Core\Modules\Database\Sql;

	class Builder 
	{
		protected $table;
		protected $data = array();
		protected $query;
		protected $info = array();

		public function table (string $table = '') 
		{
			$this->table = $table;
		}

		public function select (array $columns = ['*']) 
		{
			$columns = (string) implode(', ', $columns);
			$columns = trim($columns, ' ');

			$this->query .= "SELECT {$columns} FROM ".$this->table;

			return $this;
		}
		public function where (string $column)
		{
			$column = trim($column, ' ');
			$this->query .= " WHERE {$column}";

			return $this;
		}

		public function equal ($value)
		{
			$value = trim($value, ' ');
			array_push($this->data, $value);
			$this->query .= ' = ?';

			return $this;
		}

		public function notEqual ($value)
		{
			$value = trim($value, ' ');
			array_push($this->data, $value);
			$this->query .= ' != ?';

			return $this;
		}

		public function greaterThan ($value)
		{
			$value = trim($value, ' ');
			array_push($this->data, $value);
			$this->query .= ' > ?';

			return $this;
		}

		public function greaterThanOrEquel ($value)
		{
			$value = trim($value, ' ');
			array_push($this->data, $value);
			$this->query .= ' >= ?';

			return $this;
		}

		public function lessThan ($value)
		{
			$value = trim($value, ' ');
			array_push($this->data, $value);
			$this->query .= ' < ?';

			return $this;
		}

		public function lessThanOrEquel ($value)
		{
			$value = trim($value, ' ');
			array_push($this->data, $value);
			$this->query .= ' <= ?';

			return $this;
		}

		public function and (string $column)
		{
			$this->query .= " AND {$column}";

			return $this;
		}

		public function or (string $column)
		{
			$this->query .= " OR {$column}";

			return $this;
		}

		public function isNull ()
		{
			$this->query .= " IS NULL";

			return $this;
		}

		public function isNotNull ()
		{
			$this->query .= " IS NOT NULL";

			return $this;
		}


		public function limit (int $value)
		{
			array_push($this->data, $value);

			$this->query .= " LIMIT ?";

			return $this;
		}

		public function like (string $pattern)
		{
			array_push($this->data, $pattern);

			$this->query .= " LIKE ?";

			return $this;
		}

		public function in (array $values) 
		{
			$this->data = array_merge($this->data, $values);

			$in  = str_repeat('?,', count($values) - 1) . '?';

			$this->query .= " IN ($in)";

			return $this;
		}

		public function between ($value1, $value2)
		{
			array_push($this->data, $value1);
			array_push($this->data, $value2);

			$this->query .= " BETWEEN ? AND ?";

			return $this;
		}

		public function innerJoin (string $table2, string $column1, string $operator, string $column2)
		{
			$this->query .= ' INNER JOIN '.$table2.' ON '.$column1.' '.$operator.' '.$column2;

			return $this;
		}

		public function leftJoin (string $table2, string $column1, string $operator, string $column2)
		{
			$this->query .= ' LEFT JOIN '.$table2.' ON '.$column1.' '.$operator.' '.$column2;

			return $this;
		}

		public function leftOuterJoin (string $table2, string $column1, string $operator, string $column2)
		{
			$this->query .= ' LEFT OUTER JOIN '.$table2.' ON '.$column1.' '.$operator.' '.$column2;

			return $this;
		}

		public function rightJoin (string $table2, string $column1, string $operator, string $column2)
		{
			$this->query .= ' RIGHT JOIN '.$table2.' ON '.$column1.' '.$operator.' '.$column2;

			return $this;
		}

		public function rightOuterJoin (string $table2, string $column1, string $operator, string $column2)
		{
			$this->query .= ' RIGHT OUTER JOIN '.$table2.' ON '.$column1.' '.$operator.' '.$column2;

			return $this;
		}

		public function fullJoin (string $table2, string $column1, string $operator, string $column2)
		{
			$this->query .= ' FULL OUTER JOIN '.$table2.' ON '.$column1.' '.$operator.' '.$column2;

			return $this;
		}

		public function crossJoin (string $table2)
		{
			$this->query .= ' CROSS JOIN '.$table2;

			return $this;
		}

		public function union (array $columns, string $table2)
		{
			// Convert columns array to string
			$columns = (string) implode(', ', $columns);

			$this->query .= ' UNION SELECT '.$columns.' FROM '.$table2;

			return $this;
		}

		public function unionAll (array $columns, string $table2)
		{
			// Convert columns array to string
			$columns = (string) implode(', ', $columns);

			$this->query .= " UNION ALL SELECT {$columns} FROM {$table2}";

			return $this;
		}

		public function groupBy (array $columns)
		{
			// Convert columns array to string
			$columns = (string) implode(', ', $columns);

			$this->query .= " GROUP BY {$columns}";

			return $this;
		}

		public function having (string $column)
		{
			$this->query .= " HAVING {$column}";

			return $this;
		}

		public function orderBy (array $columns, string $sort = 'DESC')
		{
			$order = ['DESC', 'ASC'];

			// Convert columns array to string
			$columns = (string) implode(', ', $columns);

			if (in_array($sort, $order)) {
				$this->query .= " ORDER BY {$columns} {$sort}";
			} else {
				$this->query .= " ORDER BY {$columns} DESC";
			}
			
			return $this;
		}

		public function delete ()
		{
			$this->query = "DELETE FROM $this->table";
			return $this;
		}

		public function insert (array $data)
		{
			$this->data = array_merge($this->data, array_values($data));

			$this->query = "INSERT INTO $this->table (";

			foreach ($data as $column => $value) {
				$this->query .= $column.', ';
			}

			$this->query = trim($this->query, ', ');
			$this->query .= ') VALUES (';

			foreach ($data as $column => $value) {
				$this->query .= '?, ';
			}

			$this->query = trim($this->query, ', ');
			$this->query .= ');';

			return $this;
		}

		public function update (array $data)
		{
			$this->data = array_merge($this->data, array_values($data));

			$this->query = "UPDATE $this->table SET ";
			
			foreach ($data as $column => $value) {
				$this->query .= $column . " = ?, ";
			}

			$this->query = trim($this->query, ', ');
			
			return $this;
		}

		public function custom ($custom)
		{
			$this->query = $custom;
			return $this;
		}
	}
?>