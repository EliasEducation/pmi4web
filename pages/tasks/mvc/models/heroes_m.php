<?

class Heroes_m extends Model{

	public function __construct(){
		parent::__construct();
		vd('Heroes model');
	}

	public function getHeroes(){
		return ['1', '2', '3'];
	}

}