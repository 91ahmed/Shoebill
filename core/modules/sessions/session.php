<?php
	
	namespace Core\Modules\Sessions;

	use Core\Modules\Sessions\SessionConfig;

	/**
	 * 	Session handler: is a special class that used to 
	 *	create, read, delete and secure session data
	 *
	 *	@author   Ahmed Hassan <91ahmed.github.io>
	 *	@link     https://github.com/91ahmed
	 */
	class Session extends SessionConfig
	{

		/**
		 *	Start / Resume session
		 */
		public function start ()
		{
			if (session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE)
			{
				// Settings
				$this->settings();
				
				// Start session
				session_start();

				// Regenerate session id
				if ($this->RegenerateSessionID == true) {
					session_regenerate_id(true);
				}
			}
		}

		/**
		 *	Set session data
		 *
		 *	@param string $key
		 *	@param string $value
		 *	@return void
		 */
		public static function set ($key, $value)
		{
			return $_SESSION[$key] = $value;
		}

		/**
		 *	Get session data
		 *
		 *	@param string $name
		 *	@return mixed
		 */
		public static function get ($name)
		{
			return $_SESSION[$name];
		}

		/**
		 *	Destroy a particular session variable
		 *
		 *	@param string $name
		 *	@return void
		 */
		public static function delete ($name)
		{
			unset($_SESSION[$name]);
		}

		/**
		 *	Destroy all the session data
		 *
		 *	@return void
		 */
		public static function destroy ()
		{
			// unset all of the session variables
			$_SESSION = array();
			unset($_SESSION);

			// if it's desired to kill the session, also delete the session cookie
			// note: this will destroy the session, and not just the session data!
			if(ini_get("session.use_cookies")) 
			{
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}

			// destroy the session
			session_destroy();
		}

		/**
		 *	Check if session exists or not
		 *
		 *	@param string $name
		 * 	@return string
		 */
		public static function exists ($name)
		{
			return isset($_SESSION[$name]);
		}
	}
?>