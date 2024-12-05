<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Home</title>
	</head>
	<body>
		<h1>Admin (<?php echo e($admin); ?>)</h1>
		<ul>
			<?php $__currentLoopData = $all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li><?php echo e($value->name); ?></li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
	</body>
</html>