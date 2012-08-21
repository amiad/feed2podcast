<?php

class PodcastFeedCreator {
	public function __construct($feed,$update_hours=5) {
        	if ($this->get_cache($feed,$update_hours) return;
        	else echo $this->processFeed($feed);
    	}
    
	public function processFeed($feed) {
		$feed_str=file_get_contents($feed);
		$sxe = new SimpleXMLElement($feed_str);
		foreach ($sxe->channel->item as $item) {
			$file = $this->findEnclosureLink($item->link);
			$enclosure=$item->addChild('enclosure');
			$enclosure->addAttribute('url',$file);
			$enclosure->addAttribute('type','mp3');
		}
		$xml=$sxe->asXML();
		$this->save_cache($feed,$xml);
		return $xml;
	}
    
	public function findEnclosureLink($item) {
        	$page=file_get_contents($item);
		$dom = new DOMDocument();
		@$dom->loadHTML($page);
		$xpath = new DOMXPath($dom);
		$hrefs = $xpath->evaluate("/html/body//a");
		for ($i = 0; $i < $hrefs->length; $i++) {
			$href = $hrefs->item($i);
			$url = $href->getAttribute('href');
			if(substr($url,-4)=='.mp3') {
				return $url;
			}
        	}
	}
	private function get_cache($feed,$update_hours){
    		$update_seconds=$update_hours*3600;
    		$cache_file='cache/'.md5($feed);
		if ((file_exists($cache_file)) && ((time()-filemtime($cache_file)<$update_seconds))){
			ob_clean();
    			flush();
	    		readfile($cache_file);
	    		return true;
		}
		else return false;
	}
	private function save_cache($feed,$xml){
		$cache_file='cache/'.md5($feed);
		file_put_contents($cache_file,$xml);
	}
}

