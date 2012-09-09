<?php
require('convert2podcast.php');
class PodcastCreatorFromLinks extends Convert2Podcast{
	private $delType,$title,$desc,$ExcludeLink;
    	
	public function setDelStr($str){
		$this->delStr=$str;
	}
	public function setTitle($title){
		$this->title=$title;
	}
	public function setDesc($desc){
		$this->desc=$desc;
	}
	public function setExcludeLink($str){
		$this->ExcludeLink=$str;
	}
	public function setDelType($bool){
		$this->delType=$bool;
	}

	public function processFeed() {
		$page=$this->source;
		$type=$this->type;
		$page_str=file_get_contents($page);
		$links=$this->findLinks($page_str,$type);
		$feed_str="<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
		<rss version=\"2.0\">
		<channel>
		<title>$this->title</title>
		<description>$this->desc</description>
		<link>$page</link>
		</channel>
		</rss>";
		$sxe = new SimpleXMLElement($feed_str);
		$sxe=$this->addImage($sxe);
		foreach ($links as $link) {
			if($this->ExcludeLink && strpos($link['name'],$this->ExcludeLink)===0) continue;
			$item=$sxe->channel->addChild('item');
			$file = $link['url'];
			if($this->delStr) $file=str_replace($this->delStr,'',$file);
			if(strpos($file,'http://')!==0) $file=$page.'/'.$file;
			if($this->delType) $link['name']=str_replace('.'.$this->type,'',$link['name']);
			$item->addChild('title',$link['name']);
			$item->addChild('description',$link['name']);
			$item->addChild('link',$file);
			$item->addChild('guid',$file);
			$enclosure=$item->addChild('enclosure');
			$enclosure->addAttribute('url',$file);
			$enclosure->addAttribute('type',$link['type']);
		}
		$xml=$sxe->asXML();
		$this->save_cache($xml);
		return $xml;
	}
    
	public function findLinks($page,$type) {
		$dom = new DOMDocument();
		@$dom->loadHTML($page);
		$xpath = new DOMXPath($dom);
		$hrefs = $xpath->evaluate("/html/body//a");
		for ($i = 0; $i < $hrefs->length; $i++) {
			$href = $hrefs->item($i);
			$url = $href->getAttribute('href');
			$name=$this->get_inner_html($href);
			$file_type=$this->inType($url);
			if($file_type) {
				$mime=$this->mime($file_type);
				$links[]=array('name'=>$name,'url'=>$url,'type'=>$mime);
			}
		}
		return $links;
	}
	private function get_inner_html( $node ) {
		$innerHTML= '';
		$children = $node->childNodes;
		foreach ($children as $child) {
			$innerHTML .= utf8_decode($child->ownerDocument->saveXML( $child ));
		}
		return $innerHTML;
	} 
}
