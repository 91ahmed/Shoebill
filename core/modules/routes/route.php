<?php
	namespace Core\Modules\Routes;
	
	class Route
	{
		private $web    = array();
		private $client = array();

		private $route   = array();
		private $params  = array();

		private $status = 404;
		private $middlewares = array();
		private $middlewaresGroup = array();

		private $removes = array();

		private $paramsRegex = array();

		public function get (String $route, $pattern)
		{
			if ($_SERVER['REQUEST_METHOD'] === 'GET') 
			{
				$this->execute($route, $pattern);
			}

			$this->reset();

			return $this;
		}

		public function post (String $route, $pattern)
		{
			if ($_SERVER['REQUEST_METHOD'] === 'POST') 
			{
				$this->execute($route, $pattern);
			}

			$this->reset();

			return $this;
		}

		private function match (String $route) 
		{
			$this->parse($route);

			if (isset($this->route['web']) && isset($this->route['client'])) 
			{
				if ($this->route['web'] === $this->route['client']) 
				{
					return true;
				}
			}

			return false;
		}

		private function parse (String $route) 
		{
			$this->web    = $this->webRoute();
			$this->client = $this->clientRoute($route);

			if (count($this->web) == count($this->client)) 
			{
				foreach ($this->client as $key => $value) {
					if (substr($value, 0,1) == '{') {
						$this->params[trim($value,'{}')] = $this->web[$key];
					} else {
						if (isset($this->route['web'])) {
							$this->route['web'] .= $this->web[$key];
						} else {
							$this->route['web'] = $this->web[$key];
						}
						
						if(isset($this->route['client'])) {
							$this->route['client'] .= $value;
						} else {
							$this->route['client'] = $value;
						}
					}
				}	
			}
		}

		private function webRoute ()
		{
			$webRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			$webRoute = str_replace($this->removes, '', $webRoute);
			$webRoute = trim($webRoute, '/\\');
			$webRoute = explode('/', $webRoute);

			if (empty($webRoute[0])) {
				$webRoute[0] = '/';
			}
			
			return $webRoute;
		}

		private function clientRoute (String $route)
		{
			$clientRoute = trim($route,'/\\');
			$clientRoute = str_replace(DIRECTORY_SEPARATOR, '/', $clientRoute);
			$clientRoute = explode('/', $clientRoute);

			if (empty($clientRoute[0])) {
				$clientRoute[0] = '/';
			}

			return $clientRoute;
		}

		private function call (String $pattern)
		{
			$pattern = explode('@', $pattern, 2);

			$controller = '\\App\\Controller\\' . $pattern[0];
			$action = $pattern[1];

			if (!class_exists($controller)) {
				throw new \Exception("Controller Not Found ({$controller})", 1);
				exit();
			} elseif (!method_exists($controller, $action)) {
				throw new \Exception("Controller Method Not Found ({$action})", 1);
				exit();
			} else {
				$execute = new $controller();
				if (!empty($this->params)) {
					$params = array_values($this->params);					
					call_user_func_array(array($execute, $action), $params);
					exit();
				} else {
					$execute->$action();
					exit();
				}
			}
		}

		private function execute (String $route, $pattern)
		{
			if ($this->match($route) == true)
			{
				$this->status = 200;

				define ('ROUTE_URL_PARAMS', $this->params);
				$GLOBALS['ROUTE_URL_PARAMS'] = $this->params;

				// Middleware group layer
				if (!empty($this->middlewaresGroup)) 
				{
					foreach ($this->middlewaresGroup as $md) {
						$class = ucfirst($md);
						$middleware = "\\App\\Middleware\\$class";

						if (!class_exists($middleware)) {
							throw new \Exception("Middleware class doesn't exists ({$middleware})", 1);
							exit();
						} else {
							$execute = new $middleware();
						}
					}
				}

				// Middleware layer
				if (!empty($this->middlewares)) 
				{
					foreach ($this->middlewares as $md) {
						$class = ucfirst($md);
						$middleware = "\\App\\Middleware\\$class";

						if (!class_exists($middleware)) {
							throw new \Exception("Middleware class doesn't exists ({$middleware})", 1);
							exit();
						} else {
							$execute = new $middleware();
						}
					}
				}

				// Params Regex conditions
				if (!empty($this->params))
				{
					foreach ($this->params as $key => $value)
					{
						if (isset($this->paramsRegex[$key]))
						{
							$regex = '/'.$this->paramsRegex[$key].'/';

							if (!preg_match_all($regex, $value)) {
								$this->status = 404;
							}
						}
					}
				}

				// Call the controller
				if ($this->status == 200) 
				{
					if (is_callable($pattern)) {
						if (!empty($this->params)) {
							$params = array_values($this->params);					
							call_user_func_array($pattern, $params);
						} else {
							$pattern();
						}
					} else if (is_string($pattern)) {
						$this->call($pattern);
					}

					exit();
				}
			}
		}

		public function remove (array $remove) 
		{
			foreach ($remove as $value) {
				array_push($this->removes, $value);
			}
		}

		public function middleware (array $middlewares) 
		{
			$this->middlewares = $middlewares;

			return $this;	
		}

		public function error404 ($pattern) 
		{
			if ($this->status == 404) 
			{
				if (is_callable($pattern)) {
					if (!empty($this->params)) {
						$params = array_values($this->params);					
						call_user_func_array($pattern, $params);
					} else {
						$pattern();
					}
				} else if (is_string($pattern)) {
					$this->call($pattern);
				}
			}
		}

		public function regex (array $conditions) 
		{
			$this->paramsRegex = $conditions;

			return $this;
		}

		public function middlewareGroup (array $middlewares) 
		{
			foreach ($middlewares as $key => $value) {
				array_push($this->middlewaresGroup, $value);
			}
		}

		public function middlewareEnd ()
		{
			$this->middlewaresGroup = array();
		}

		private function reset () 
		{
			$this->web = [];
			$this->client = [];
			$this->params = [];
			$this->route = [];
			$this->middlewares = [];
			$this->paramsRegex = [];
		}
	}
?>