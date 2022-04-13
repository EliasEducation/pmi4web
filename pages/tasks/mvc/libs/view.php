<?

class View{

	public function __construct(){

	}

	public function render(string $path, string $fileName = 'index'){
		$fileName = './views/'.$path.'/'.$fileName.'.php';
		if(file_exists($fileName)){
			require($fileName);
		}
	}
}
