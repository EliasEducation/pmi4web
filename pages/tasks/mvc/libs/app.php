<?

class App{

	public function __construct(){
		$url = $_GET['url']??'';
		if($url) $url = explode('/', rtrim($url, '/'));

		$controllerName = 'index';
		if(isset($url[0]) && $url[0]) $controllerName = $url[0];

		$fileName = 'controllers/'.$controllerName.'.php';
		if(file_exists($fileName)){
			// подключили контроллер
			require_once($fileName);

			$controller = new $controllerName;
			if(isset($url[1])){
				header('Content-Type: application/json');

				if(method_exists($controller, $url[1])){
					$controller->{$url[1]}();
				}else{
					echo 'Error method dose not extists';
				}
			}else{
				$controller->index();
			}
		}else{
			echo 'Error file dose not exists';
		}
	}

}