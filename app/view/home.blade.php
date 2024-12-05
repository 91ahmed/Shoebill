<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Home</title>
	</head>
	<body>
		<h1>Admin ({{ $admin }})</h1>
		<ul>
			@foreach($all as $key => $value)
			<li>{{ $value->name }}</li>
			@endforeach
		</ul>
	</body>
</html>