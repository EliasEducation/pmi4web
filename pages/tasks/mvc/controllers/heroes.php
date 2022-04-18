<?

class Heroes extends Controller{

	public function __construct(){
		parent::__construct();
	}

	function show_heroes(){
		$heroes = $this->model->getHeroes();

		$this->view->data = $heroes;

		$this->view->render(strtolower(get_class($this).'/heroes_list'));
	}

	function getHero(){
		$res = $this->model->getHero();

		$this->sendReq($res);
	}

	function addHero(){
		$requestBody = json_decode(file_get_contents('php://input'));

		$set = [
			'name' => $requestBody->name,
			'description' => $requestBody->description,
			'image' => $requestBody->thumbnail->path.'.'.$requestBody->thumbnail->extension
		];

		$res = $this->model->addHero($set);

		$this->sendReq($res);
	}

	function delHero(){
		return $this->model->delHero();
	}

	function get(){
		$res = $this->model->getHeroes();

		$this->sendReq($res);
	}

	function getRandom(){
		$res = $this->model->getRandom();

		$this->sendReq($res);
	}

	function show_hero(){
		$heroId = req('hero_id', '', true);

		vd('Hero id is '.$heroId);
	}

}