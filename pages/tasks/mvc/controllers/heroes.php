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

	function show_hero(){
		$heroId = req('hero_id', '', true);

		vd('Hero id is '.$heroId);
	}

}