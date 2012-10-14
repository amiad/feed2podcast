<?php
require('convert2podcast.php');
class PodcastCreatorFromList extends Convert2Podcast{
    	
	public function setTitle($title){
		$this->title=$title;
	}
	public function setDesc($desc){
		$this->desc=$desc;
	}

	public function processFeed() {
		$list=$this->source;
		$type=$this->type;
		$lines=file($list);
		$feed_str="<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
		<rss version=\"2.0\">
		<channel>
		<title>$this->title</title>
		<description>$this->desc</description>
		<link>$list</link>
		</channel>
		</rss>";
		$sxe = new SimpleXMLElement($feed_str);
		$sxe=$this->addImage($sxe);
		foreach ($lines as $line) {
			$list($file,$title)=explode("|",$line);
			$item=$sxe->channel->addChild('item');
			$item->addChild('title',$title);
			$item->addChild('description',$title);
			$item->addChild('link',$file);
			$item->addChild('guid',$file);
			$enclosure=$item->addChild('enclosure');
			$enclosure->addAttribute('url',$file);
			$enclosure->addAttribute('type',$this->mime(strtolower(substr($file,-3))));
		}
		$xml=$sxe->asXML();
		$this->save_cache($xml);
		return $xml;
	}
}
