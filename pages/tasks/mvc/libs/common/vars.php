<?

// получить данные из запроса (краткая запись)
function req($name, $default = '', $important_required = false, $sanitize = true, $sanitize_quotes2entity = true){
	return request($name, $default, $important_required, $sanitize, $sanitize_quotes2entity);
}

// получить данные из запроса (GET, POST)
function request($name, $default = '', $important_required = false, $sanitize = true, $sanitize_quotes2entity = true){
	if(isset($_REQUEST[$name])){
		$value = $_REQUEST[$name];
		if($sanitize) $value = sanitize($value, $sanitize_quotes2entity);
		return $value;
	}elseif($important_required){
		throw new Exception("Обязательный параметр не передан: '$name'");
	}

	return $default;
}

function sanitize($value, $quotes2entity = true){
	if(is_null($value) or is_bool($value)) return $value;

	if(is_array($value)){
		foreach($value as $i => $value_i) $value[$i] = sanitize($value_i, $quotes2entity);
		return $value;
	}

	if($quotes2entity){
		$value = preg_replace('~(<|&lt;)(\w|[!?\/])~i', '$1 $2', $value); // убрать открывание тэгов
		$value = str_replace("'", '&#39;', $value);
		$value = str_replace('"', '&quot;', $value);
	}

	return addslashes($value);
}