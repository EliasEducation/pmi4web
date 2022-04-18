<?

class Users_m extends Model{

	public function __construct(){
		parent::__construct();
	}

	public function authorization($login, $password){
		$password = md5($password);

		$w = "`login` = '$login' AND `password` = '$password'";
		$res = dbh()->sel()->from('`users`')->w($w)->fetchAll();

		$response = new stdClass();

		if($res){
			$response->isOk = true;

			//Преобразуем тип
			$response->message[0]['id'] = $res[0]['id'];
			$response->message[0]['isAdmin'] = (bool)$res[0]['role'];

//			$_SESSION['userId'] = $response->message[0]['id'];
//			$_SESSION['isAdmin'] = $response->message[0]['isAdmin'];

		}else{
//			http_response_code(400);
			$response->message = 'Неверный логин или пароль!';
			$response->isOk = false;
		}

		return $response;
	}

}