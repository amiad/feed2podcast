<?php
require('convert2podcast.php');
class PodcastFeedCreator extends Convert2Podcast{
	public function processFeed() {
		$feed=$this->source;
		$type=$this->type;
		$feed_str=file_get_contents($feed);
		$sxe = new SimpleXMLElement($feed_str);
		foreach ($sxe->channel->item as $item) {
			$file = $this->findEnclosureLink($item->link,$type);
			if($this->delStr) $file=str_replace($this->delStr,'',$file);
			$enclosure=$item->addChild('enclosure');
			$enclosure->addAttribute('url',$file);
			$enclosure->addAttribute('type',$this->mime($this->inType($file)));
		}
		$sxe=$this->addImage($sxe);
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
			if($this->inType($url)) {
				return $url;
			}
		}
	}
}

