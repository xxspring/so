<?php  
/**
 * 一个简单的模版引擎
 */
class Template{

	private $arrayConfig = array(
			'suffix' => '.m', //设置模版文件的后缀
			'templateDir' => 'template/', //设置模版所在的文件夹
			'compiledir' => 'cache', //设置编译后存放的目录
			'cache_htm' => false, //是否需要编译成静态的HTML
			'suffix_htm' => '.htm', //设置编译文件的后缀
			'cache_time' => 7200 //多长时间自动更新，单位：秒
		);
	public $file; //模版文件名，不带后缀
	private $value = array(); 
	private $compileTool; //编译器
	static private $instance = NULL;

	public function __construct($arrayConfig = array()){
		$this->arrayConfig = $arrayConfig + $this->arrayConfig;
		include_once('Compile.Class.php');
		$this->compileTool = new CompileClass;
	}

	//取得模版引擎的实例
	public static function getInstance(){
		if(is_null(self::$instance)){
			self::$instance = new Template();
		}
		return self::$instance;
	}

	// 单步设置引擎
	public function setConfig($key,$value = null){
		if(is_array($key)){
			$this->arrayConfig = $key + $this->arrayConfig;
		}else{
			$this->arrayConfig[$key] = $value;
		}
	}

	// 获取当前的模版引擎配置，仅供调试使用
	public function getConfig($key = null){
		if($key){
			return $this->arrayConfig[$key];
		}else{
			return $this->arrayConfig;
		}
	}

	// 注入单个变量
	public function assign($key,$value){
		$this->value[$key] = $value;
	}

	//注入变量数组
	public function assignArray($array){
		if(is_array($array)){
			foreach($array as $k=>$v){
				$this->value[$k] = $v;
			}
		}
	}

	public function path(){
		return $this->arrayConfig['templateDir'].$this->file.$this->arrayConfig['suffix'];
	}

	public function show($file){
		$this->file = $file;
		if(!is_file($this->path())){
			exit("找不到对应的模版");
		}
		$compileFile = $this->arrayConfig['compiledir'].'/'.md5($file).'.php';
		var_dump($compileFile);
		var_dump($this->path());
		if(!is_file($compileFile)){
			mkdir($this->arrayConfig['compiledir']);
			$this->compileTool->compile($this->path(),$compileFile);
			readfile($compileFile);
		}else{
			readfile($compileFile);
		}
	}
}

?>