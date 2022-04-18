<?

class Users extends Controller{

	public function __construct(){
		parent::__construct();
	}

	public function authorization(){
		$requestBody = json_decode(file_get_contents('php://input'));

		$resUsers = $this->model->authorization($requestBody->login, $requestBody->password);

		$this->sendReq($resUsers);
	}
}