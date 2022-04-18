<?

class Controller{

	public function __construct(){
		$this->view = new View();
		$this->modelName = strtolower(get_class($this)).'_m';

		$fileName = './models/'.$this->modelName.'.php';
		if(file_exists($fileName)){
			require_once('./models/'.$this->modelName.'.php');
			$this->model = new $this->modelName;
		}
	}

	public function index() {
		$this->view->render(strtolower(get_class($this)));
	}

	public function sendReq($response){
		if($response->isOk) {
			echo json_encode($response->message);
		} else {
			echo json_encode($response);
		}
	}

}