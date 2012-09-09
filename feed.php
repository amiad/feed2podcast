<?php

/* required */
$feed='http://news.php.net/group.php?group=php.announce&format=rss'; //url of the feed

/* optional */
$type=''; //file type, default mp3
$updateHours=5; //How often the cache is updated (in hours), default 5
$image=''; //podcast logo url, default none;
$delStr=''; // delete substring in file url. for sites that redirect the download via other

/* not touch */
require('feed2podcast.php');
$feed2podcast = new PodcastFeedCreator($feed);

$feed2podcast->setType($type); 
$feed2podcast->setUpdateHours($updateHours); 
$feed2podcast->setImage($image); 
$feed2podcast->setDelStr($delStr); 

$feed2podcast->getFeed();
