<?php
function feed2pc($feed,$update_hours=5){
	$update_seconds=$update_hours*3600;
	//error_reporting(2147483647);
	$cache_file='cache/'.str_replace('/','-',$feed);
	if ((!file_exists($cache_file)) || ((time()-filemtime($cache_file)>$update_seconds))){
		$feed_str=file_get_contents($feed);
		$sxe = new SimpleXMLElement($feed_str);
		foreach ($sxe->channel->item as $item){
			$page=file_get_contents($item->link);
			$dom = new DOMDocument();
			@$dom->loadHTML($page);
			$xpath = new DOMXPath($dom);
			$hrefs = $xpath->evaluate("/html/body//a");
			for ($i = 0; $i < $hrefs->length; $i++) {
				$href = $hrefs->item($i);
				$url = $href->getAttribute('href');
				if(substr($url,-4)=='.mp3') {
					$file=$url;
					break;
				}
			}
			$enclosure=$item->addChild('enclosure');
			$enclosure->addAttribute('url',$file);
			$enclosure->addAttribute('type','mp3');
		}
		$xml=$sxe->asXML();
		file_put_contents($cache_file,$xml);
		echo $xml;
	}
	else {
		ob_clean();
    		flush();
	    	readfile($cache_file);
	    }
}
