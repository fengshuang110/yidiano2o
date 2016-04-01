<?php 
namespace Service;


class Service{
	protected $models = array();
	protected $namespace = 'Model';
	public function getModel($name,$namespace = ""){
		foreach ($this->models as $model){
			$class_name = basename(str_replace('\\', '/', get_class($model)));			
			if($name == $class_name){
				return $model;
			}
		}
		$class_name = '\\'.$this->namespace.'\\'.$name;
		if(class_exists($class_name)){
			$class  = new $class_name;
			$this->models[$name] = $class;
			return  $class;
		}else{
			throw new \Exception($name."class is not exist");
		}
		
	}
	
	public function load($object){
		if(empty($this->models)){
			$this->models[] = $object;
			return ;
		}
		if(in_array($object,$this->models)){
			return ;
		}
		$this->models[] = $object;
	}
}

?>