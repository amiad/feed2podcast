<?php

class PodcastFeedCreator {
	private $update_hours=5;
	private $type='mp3';
	public function __construct($feed) {
        	$this->feed=$feed;
    	}
    	
    	public function getFeed(){
    		if ($this->get_cache()) return;
        	else {
        		header('Content-type: application/xml');
        		echo $this->processFeed();
        	}
        }
        
        public function setType($type){
        	$this->type=$type;
        }
        
        public function setUpdateHours($update_hours){
        	$this->update_hours=$update_hours;
        }
        
	public function processFeed() {
		$feed=$this->feed;
		$type=$this->type;
		$feed_str=file_get_contents($feed);
		$sxe = new SimpleXMLElement($feed_str);
		foreach ($sxe->channel->item as $item) {
			$file = $this->findEnclosureLink($item->link,$type);
			$enclosure=$item->addChild('enclosure');
			$enclosure->addAttribute('url',$file);
			$enclosure->addAttribute('type',$type);
		}
		$xml=$sxe->asXML();
		$this->save_cache($xml);
		return $xml;
	}
    
	public function findEnclosureLink($item,$type) {
        	$page=file_get_contents($item);
		$dom = new DOMDocument();
		@$dom->loadHTML($page);
		$xpath = new DOMXPath($dom);
		$hrefs = $xpath->evaluate("/html/body//a");
		for ($i = 0; $i < $hrefs->length; $i++) {
			$href = $hrefs->item($i);
			$url = $href->getAttribute('href');
			if(substr($url,-4)=='.'.$type) {
				return $url;
			}
        	}
	}
	private function get_cache(){
		$feed=$this->feed;
    		$update_seconds=$this->update_hours*3600;
    		$cache_file='cache/'.md5($feed);
		if ((file_exists($cache_file)) && ((time()-filemtime($cache_file)<$update_seconds))){
			ob_clean();
    			flush();
    			header('Content-type: application/xml');
	    		readfile($cache_file);
	    		return true;
		}
		else return false;
	}
	private function save_cache($xml){
		$cache_file='cache/'.md5($this->feed);
		if(!file_exists('cache')) mkdir('cache');
		file_put_contents($cache_file,$xml);
	}
}

