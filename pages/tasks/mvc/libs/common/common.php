<?

include('vars.php');

class Common{



}

function vd($var, bool $exit = false): void{

	echo '<pre>';
	var_dump($var);
	echo '</pre>';

	if($exit) exit();
}