<?

class Heroes_m extends Model{

	const T = 'heroes';

	public function __construct(){
		parent::__construct();
	}

	public function getHeroes(){
		$heroes = dbh()->sel()->from('heroes')->fetchAll();

		$response = new stdClass();

		if($heroes){
			$response->message['results'] = $heroes;
			$response->isOk = true;
		}else{
			$response->message = 'Ошибка получения героев';
			$response->isOk = false;
		}

		return $response;
	}

	public function getHero(){
		$id = req('hero_id');
		$hero = dbh()->sel()->from(Heroes_m::T)->w('`id` = '.(int)$id)->fetchAll();

		$response = new stdClass();
		if($hero){
			$response->message['results'] = $hero[0];
			$response->isOk = true;
		}else{
			$response->message = 'Ошибка получения героя';
			$response->isOk = false;
		}

		return $response;
	}

	public function getRandom(){
		$heroIds = dbh()->sel('`id`')->from('`heroes`')->fetchAll(PDO::FETCH_COLUMN);

		$randHeroId = $heroIds[array_rand($heroIds, 1)];
		$_REQUEST['hero_id'] = $randHeroId;

		return $this->getHero();;
	}

	public function addHero(array $set){
		$insertFields = [
			'name',
			'description',
			'image'
		];

		$dbh = dbh()->insert(Heroes_m::T, false, $insertFields)->appendQuery(' VALUES ');
		$dbh->setValues($set);

		$res = $dbh->exec();

		$response = new stdClass();
		if($res){
			$response->message = 'Герой добавлен';
			$response->isOk = true;
		}else{
			$response->message = 'Ошибка добавления героя';
			$response->isOk = false;
		}

		return $response;
	}

	public function delHero(){
		$id = req('hero_id');
		$hero = dbh()->del(Heroes_m::T)->w('`id` = '.(int)$id)->exec();

		$response = new stdClass();
		if($hero){
			$response->message = $hero;
			$response->isOk = true;
		}else{
			$response->message = 'Ошибка получения героя';
			$response->isOk = false;
		}

		return $response;
	}

}