<?

function dbh(): dbh{
//	throw new Exception(L('Message_dbh_remote'), 503);

	return new dbh($GLOBALS['dbh_main'], MVC::$config);
}

class dbh{

	static $debugQueriesUserId = null; // записывать все запросы и их время выполнения в сообщения ядра, для отладки
	protected $db_config;
	protected $availableUTF8mb4 = false;
	protected $autoEncodeJson = false;
	var $dbh;
	protected $PDOStatement;
	var $query = '';
	var $error = false;
	var $errorMessage = '';
	var $count_error = 0;

	function __construct(&$dbh, &$config){
		$this->db_config = &$config;
		if(!$dbh) $dbh = $this->dbh_init($this->db_config);

		$this->dbh = &$dbh;
	}

	function dbh_init($config){
		try{
			$dbh = new PDO('mysql:host=localhost;dbname='.$config['db_name'], $config['user_name'], $config['password']);
		}catch(PDOException $Exception){
			throw new Exception($Exception->getMessage());
		}

		return $dbh;
	}

	function setAvailableUTF8mb4(bool $availableUTF8mb4 = true){
		$this->availableUTF8mb4 = $availableUTF8mb4;

		return $this;
	}

	function setAutoEncodeJson(bool $autoEncodeJson = true){
		$this->autoEncodeJson = $autoEncodeJson;

		return $this;
	}

	function prepare_table_name($table_name){
		return str_replace(['`', '.'], ['', '`.`'], $table_name);
	}

	static function prepare_column_name($column_name){
		return str_replace(['`', '.'], ['', '`.`'], $column_name);
	}

	static function prepareSql(string $sql, $availableUTF8mb4 = false): string{
		if(!$availableUTF8mb4) $sql = dbh::stripUTF8mb4($sql);

		$sql = preg_replace("/(^|[^\\\])'/", "$1\'", $sql); // экранировать кавычку
		$sql = preg_replace("/(^|[^\\\])((\\\{2})+)'/", "$1$2\'", $sql); // добавить нечетное экранирование кавычки
		$sql = str_replace("''", "'\'", $sql);
		$sql = preg_replace('/(?:^|[^\\\])(?:[\\\][\\\])*\\\$/', '$0\\', $sql); // экранировать нечетный обратный слеш в конце строки

		return $sql;
	}

	static function stripUTF8mb4(string $string): string{
		return preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $string)??'';
	}

	function prepare_val($val, $sanitize = false){
		if($this->autoEncodeJson and is_array($val)) $val = json_encode($val, JSON_UNESCAPED_UNICODE);

		if($val === 'null' or $val === null) return 'null';
		if($sanitize) return "'".sanitize($val)."'";
		return "'".dbh::prepareSql($val, $this->availableUTF8mb4)."'";
	}

	function query($query){
		$this->query = $query;

		return $this;
	}

	function appendQuery($query){
		$this->query .= $query;

		return $this;
	}

	function sel($fieldsNames = '', bool $calc_found_rows = false, bool $use_cache = false){
		$this->query .= "SELECT ";
		if($use_cache) $this->query .= 'SQL_CACHE ';
		if($calc_found_rows) $this->query .= 'SQL_CALC_FOUND_ROWS ';

		if($fieldsNames === ''){
			$field_str = '* ';
		}elseif(is_array($fieldsNames)){
			$field_str = implode('`, `', $fieldsNames);
			$field_str = '`'.str_replace('.', '`.`', $field_str).'` ';
		}else{
			$field_str = $fieldsNames.' ';
		}

		$this->query .= $field_str;

		return $this;
	}

	function from($table_name = '', $alias = ''){
		$table_name = $this->prepare_table_name($table_name);
		$this->query .= "FROM `$table_name` ";
		if($alias) $this->query .= "`$alias` ";

		return $this;
	}

	function join($table_name = '', $type_join = '', $alias = ''){
		$table_name = $this->prepare_table_name($table_name);

		switch($type_join){
			case 'l':
			case 'left':
				$this->query .= 'LEFT ';
				break;
			case 'r':
			case 'right':
				$this->query .= 'RIGHT ';
				break;
			default:
				$this->query .= 'INNER ';
		}

		$this->query .= "JOIN `$table_name` ";
		if($alias) $this->query .= "`$alias` ";

		return $this;
	}

	function using(string $fieldsNames = ''){
		if($fieldsNames) $this->query .= "USING ($fieldsNames) ";

		return $this;
	}

	function on($where = ''){
		if($where) $this->query .= "ON ($where) ";

		return $this;
	}

	function useIndex(string $indexName){
		if($indexName) $this->query .= " USE INDEX ($indexName) ";

		return $this;
	}

	function useIndexes(array $indexesNames){
		foreach($indexesNames as $indexName) $this->useIndex($indexName);

		return $this;
	}

	function where($where = ''){
		if($where) $this->query .= "WHERE ($where) ";

		return $this;
	}

	function w($where = ''){
		return $this->where($where);
	}

	function group($group_by = ''){
		if($group_by) $this->query .= "GROUP BY $group_by ";

		return $this;
	}

	function g($group_by = ''){
		return $this->group($group_by);
	}

	function having($having = ''){
		if($having) $this->query .= "HAVING ($having) ";

		return $this;
	}

	function h($having = ''){
		return $this->having($having);
	}

	function order($order = ''){
		if($order) $this->query .= "ORDER BY $order ";

		return $this;
	}

	function o($order = ''){
		return $this->order($order);
	}

	function limit($limit = ''){
		if($limit) $this->query .= "LIMIT $limit ";

		return $this;
	}

	function l($limit = ''){
		return $this->limit($limit);
	}

	function fetchColumn($column_number = 0){
		try{
			$this->PDOStatement = $this->dbh->query($this->query);
			if($this->PDOStatement) return $this->PDOStatement->fetchColumn($column_number);
		}catch(PDOException $Exception){

			$this->error('', $Exception);
			return $this->try_again($Exception, __FUNCTION__, func_get_args());
		}
	}

	function fetch($fetch_style = false){
		if(!$fetch_style) $fetch_style = PDO::FETCH_ASSOC;

		try{
			$this->PDOStatement = $this->dbh->query($this->query);
			if($this->PDOStatement) return $this->PDOStatement->fetch($fetch_style);
		}catch(PDOException $Exception){


			$this->error('', $Exception);
			return $this->try_again($Exception, __FUNCTION__, func_get_args());
		}
	}

	function fetchAll($fetch_style = false){
		if(!$fetch_style) $fetch_style = PDO::FETCH_ASSOC;

		try{
			$this->PDOStatement = $this->dbh->query($this->query);
			if($this->PDOStatement) return $this->PDOStatement->fetchAll($fetch_style);
		}catch(PDOException $Exception){


			$this->error('', $Exception);
			return $this->try_again($Exception, __FUNCTION__, func_get_args());
		}
	}

	function insert($table_name, $ignore = false, $fieldsNames = ''){
		$table_name = $this->prepare_table_name($table_name);

		$this->query = "INSERT ";
		if($ignore) $this->query .= "IGNORE ";
		$this->query .= "INTO `$table_name` ";

		if($fieldsNames){
			if(is_array($fieldsNames)) $field_str = '`'.implode('`, `', $fieldsNames).'`';
			else $field_str = $fieldsNames;

			$this->query .= "($field_str) ";
		}

		return $this;
	}

	function update($table_name, $ignore = false, $alias = ''){
		$table_name = $this->prepare_table_name($table_name);

		$this->query = "UPDATE ";
		if($ignore) $this->query .= "IGNORE ";
		$this->query .= "`$table_name` ";
		if($alias) $this->query .= "`$alias` ";

		return $this;
	}

	function replace($table_name){
		$table_name = $this->prepare_table_name($table_name);

		$this->query = 'REPLACE INTO ';
		$this->query .= "`$table_name` ";

		return $this;
	}

	function set($data, $duplicate_update = false, $sanitize = false){
		$this->query .= "SET ";

		if(is_array($data)){
			$data_str = '';
			foreach($data as $name => $val) $data_str .= "`".dbh::prepare_column_name($name)."` = ".$this->prepare_val($val, $sanitize).",";
			$data_str = substr($data_str, 0, strlen($data_str) - 1);
		}else{
			$data_str = $data;
		}

		$this->query .= "$data_str ";

		if($duplicate_update) $this->query .= "ON DUPLICATE KEY UPDATE $data_str ";

		return $this;
	}

	function setValues($data, $sanitize = false){
		foreach($data as &$_value) $_value = $this->prepare_val($_value, $sanitize);
		$this->query .= '('.implode(',', $data).')';

		return $this;
	}

	function del($table_name, $alias = ''){
		$table_name = $this->prepare_table_name($table_name);
		$this->query = "DELETE `".($alias?$alias:$table_name)."` FROM `$table_name` ";
		if($alias) $this->query .= "`$alias` ";

		return $this;
	}

	function exec($query = ''){
		if($query) $this->query = $query;


		try{
			return $this->dbh->exec($this->query);
		}catch(PDOException $Exception){
			$this->error('', $Exception);
			return $this->try_again($Exception, __FUNCTION__, func_get_args());
		}
	}

	function beginTransaction(){
		try{
			return $this->dbh->beginTransaction();
		}catch(PDOException $Exception){
			$this->error('', $Exception);
			return $this->try_again($Exception, __FUNCTION__, func_get_args());
		}
	}

	function commit(){
		try{
			return $this->dbh->commit();
		}catch(PDOException $Exception){
			$this->error('', $Exception);
			return $this->try_again($Exception, __FUNCTION__, func_get_args());
		}
	}

	function id(){
		return $this->dbh->lastInsertId();
	}

	function connection_id(){
		return $this->sel('CONNECTION_ID()')->fetchColumn();
	}

	// используйте функцию MySQL UNCOMPRESS(UNHEX(`fieldName`)) для разжатия на стороне сервера
	// синоним HEX(COMPRESS('string'))
	function compress(string $string): string{
		$data = gzcompress($string);
		$len = strlen($string);
		$head = pack('V', $len);

		return bin2hex($head.$data);
	}

	// необходима ли повторная попытка
	function try_again_must($Exception){
		$try_again = false;

		if($Exception and isset($Exception->errorInfo[1])){
			if($Exception->errorInfo[1] == 2006) $try_again = true; // server timeout
			if($Exception->errorInfo[1] == 1205) $try_again = true; // lock
			if($Exception->errorInfo[1] == 1213) $try_again = true; // цикличный lock
		}

		if($try_again and $this->count_error >= 2) $try_again = false;

		return $try_again;
	}

	// повторная попытка отправки команды SQL
	function try_again($Exception, $function_name, $args, $reconnect = true){
		$try_again = $this->try_again_must($Exception);
		if(!$try_again) return;

		sleep(1);

		if($reconnect) $this->dbh = $this->dbh_init($this->db_config);

		// повторить запрос
		$this->error = false;
		$this->errorMessage = '';
		$this->count_error++;
		return call_user_func_array([$this, $function_name], $args);
	}

	function error($error = '', $Exception = false){
		$try_again = $this->try_again_must($Exception);

		if(!$error){
			$error = '';

			if($this->dbh){
				$bd_errorCode = $this->dbh->errorCode();
				$bd_errorInfo = $this->dbh->errorInfo();

				$error .= $bd_errorCode.' - '.$bd_errorInfo[2].'. ('.$bd_errorInfo[1].'/'.$bd_errorInfo[0].')';
				if($phpError = error_get_last()) $error .= "\nPHP: $phpError[message]";
			}

			if($Exception){
				if(!$this->dbh or !$this->dbh->errorInfo()[2]) $error .= "\n".$Exception->getMessage().' ('.$Exception->getCode().')';

				$traces = $Exception->getTrace();
				if(count($traces) > 1) array_shift($traces); // убрать строчку о текущем файле
				if(count($traces) > 3) $traces = array_slice($traces, 0, 3); // добавить в лог 3 последних вызова

				foreach($traces as $trace){
					if(isset($trace['file'])) $error .= "\n$trace[file] ($trace[line])";
				}
			}

			$error .= "\n===== repeat: $this->count_error =====\n";
			$query = $this->query;
			if(!$query) $query = '--';
			if(mb_strlen($query) > 1024 * 10) $query = substr($query, 0, 1024 * 10).'... - full size: '.mb_strlen($query);
			$error .= $query;
			$error .= "\n=====";
		}

		$ms = round(explode(' ',microtime())[0] * 1000);
		$errorData = "\n".date("Y-m-d H:i:s:$ms O")."\n";
		$errorData .= "hostname:host=localhost\n";

		if(function_exists('user')){
			$user_id = -1;
			if(user() && user()->id) $user_id = user()->id;

			$errorData .= 'userId: '.(($user_id == -1)?'Гость':$user_id)."\n";
		}

		if(isset($_SERVER['HTTP_USER_AGENT'])) $errorData .= 'User-Agent: '.$_SERVER['HTTP_USER_AGENT']."\n";

		if(isset($_SERVER['REQUEST_URI'])){
			if(!$_POST){
				$requestData = file_get_contents('php://input');
				if($requestData) $_POST = json_decode($requestData, true);
			}

			if(strpos($_SERVER['REQUEST_URI'], '/ajax/') !== false AND isset($_SERVER['HTTP_REFERER'])){
				$errorData .= $_SERVER['HTTP_REFERER']."\n";
			}

			if(isset($_SERVER['HTTP_HOST'])) $errorData .= $_SERVER['HTTP_HOST'];
			$errorData .= $_SERVER['REQUEST_URI'];
			if($_POST) $errorData .= "\nPOST: ".json_encode($_POST, JSON_UNESCAPED_UNICODE);
		}else{
			$errorData .= 'cli';
		}

		$errorData .= "\n=====";
		$errorData .= "\n$error\n";

		$this->error = true;
		$this->errorMessage = $errorData;
	}

	function getMeta(): array{
		if(!$this->PDOStatement) return [];

		$meta = [];
		for($i = 0; $i < $this->PDOStatement->columnCount(); $i++) $meta[] = $this->PDOStatement->getColumnMeta($i);

		return $meta;
	}

}