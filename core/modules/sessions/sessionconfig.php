<?php
	
	namespace Core\Modules\Sessions;

	/**
	 *	Session configuration
	 *
	 *	@author   Ahmed Hassan <91ahmed.github.io>
	 *	@link     https://github.com/91ahmed
	 */
	class SessionConfig
	{
		/**
		 *	@var SessionName
		 *
		 *	Set the current session name.
		 */
		protected $SessionName = SESS_NAME;

		/**
		 *	@var SessionDomain
		 *
		 *	Cookie domain to make cookies visible on all subdomains.
		 */
		protected $SessionDomain = SESS_DOMAIN; // [ for example .example.com ]

		/**
		 *	@var SessionLifeTime
		 *
		 *	Lifetime of the session cookie, defined in seconds.
		 */
		protected $SessionLifeTime = SESS_LIFE_TIME; // [ 2678400 - expire in 30 days ]

		/**
		 *	@var SessionPath
		 *
		 *	Path on the domain where the cookie will work. 
		 *	Use a single slash ('/') for all paths on the domain.
		 */
		protected $SessionPath = SESS_DOMAIN_PATH;

		/**
		 *	@var SessionSSL
		 *
		 *	If true cookie will only be sent over secure connections.
		 */ 
		protected $SessionSSL = SESS_SSL;

		/**
		 *	@var SessionHttp
		 *
		 *	If set to true then PHP will attempt to send the httponly flag when setting the session cookie.
		 */
		protected $SessionHttp = SESS_HTTP;

		/**
		 *	@var SessionSave
		 *
		 *	Set the current session save path.
		 */
		protected $SessionSavePath = SESS_SAVE_PATH;

		protected $RegenerateSessionID = SESS_REGENERATE;

		/**
		 *	Session settings
		 *	@return void
		 */
		protected function settings ()
		{
			// Set the current session name.
			session_name($this->SessionName);

			// Set the session cookie parameters
			session_set_cookie_params(
				$this->SessionLifeTime,
				$this->SessionPath,
				$this->SessionDomain,
				$this->SessionSSL,
				$this->SessionHttp
			);

			// Set the current session save path
			session_save_path($this->SessionSavePath);
		}
	}
?>