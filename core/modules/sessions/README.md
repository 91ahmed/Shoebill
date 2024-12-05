# SecureSessionHandler
Session handler class to create, read, delete and secure session data

#### How to use it

```php
	use \Modules\Sessions\Session;

	// Start Session
	$session = new Session();
	$session->start();

	// Set session data
	Session::set('name', 'ahmed hassan');

	// Get session data
	echo Session::get('name');

	// Delete session variable
	Session::delete('name');

	// Destroy session
	Session::destroy();

	// Check if session exists or not
	if (Session::exists('name')) {
		// true
	} else {
		// false
	}
```
