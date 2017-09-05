<?php  

class CompileClass{
	private $template; // 待编译的文件
	private $content; // 需要替换的文本
	private $comfile; // 编译后的文件
	private $left = '{'; // 左定界符
	private $right = '}'; // 右定界符
	private $value = array();

	public function __construct(){

	}

	public function compile($source,$destFile){
		file_put_contents($destFile,file_get_contents($source));
	}
}
?>