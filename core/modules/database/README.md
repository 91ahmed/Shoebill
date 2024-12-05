```php
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
```