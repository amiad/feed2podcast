<?php

abstract class Convert2Podcast {
	private $MIME=array(
		'mp3'=>'audio/mpeg3',
		'wma'=>'audio/x-ms-wma',
		'ogg'=>'audio/ogg ',
		);
	
	protected $source;	
	protected $update_hours=5;
	protected $type=array('mp3');
	protected $image;
	protected $delStr;
	public function __construct($source) {
		$this->source=$source;
    	}
    	
    	public function getFeed(){
    		if ($this->get_cache()) return;
		else {
			header('Content-type: application/xml');
			echo $this->processFeed();
		}
	}
	
	public function setType($type){
		if(!$type) $type='mp3';
		if(!is_array($type)) $this->type=array($type);
		else $this->type=$type;
	}
	
	public function setUpdateHours($update_hours){
		$this->update_hours=$update_hours;
	}
	
	public function setImage($image){
		$this->image=$image;
 	}
	
	public function setDelStr($str){
		$this->delStr=$str;
	}
	
	public abstract function processFeed();

	protected function get_cache(){
		$source=$this->source;
    		$update_seconds=$this->update_hours*3600;
    		$cache_file='cache/'.md5($source);
		if ((file_exists($cache_file)) && ((time()-filemtime($cache_file)<$update_seconds))){
			ob_clean();
    			flush();
    			header('Content-type: application/xml');
	    		readfile($cache_file);
	    		return true;
		}
		else return false;
	}
	protected function save_cache($xml){
		$cache_file='cache/'.md5($this->source);
		if(!file_exists('cache')) mkdir('cache');
		file_put_contents($cache_file,$xml);
	}
	protected function addImage($sxe){
		if($this->image) {
			$image=$sxe->channel->addChild('image');
			$image->addChild('url',$this->image);
			$image->addChild('title',$sxe->channel->title);
			$image->addChild('link',$sxe->channel->link);
		}
		return $sxe;
	}
	protected function inType($url){
		$file_type=strtolower(substr($url,-3));
		if(in_array($file_type ,$this->type)) return $file_type;
		else return false;
	}
	protected function mime($type){
		if(array_key_exists($type,$this->MIME)) $mime=$this->MIME[$type];
		else $mime='audio/'.$type;
	}
}
