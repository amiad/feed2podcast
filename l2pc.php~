<?php

/* required */
$page='http://example.com'; //page url

/* optional */
$title=''; // feed title
$desc=''; // feed description
$type=array('mp3','wma'); // type of audio files, default mp3
$exclude=''; // links with this string not adding to feed
$delType=true; // to delete file extension from item title, default true
$image=''; // feed image
$delStr=''; // delete substring in file url. for sites that redirect the download via other
$updateHours=5; //How often the cache is updated (in hours), default 5

/* not touch */
require('links2podcast.php');
$l2pc=new PodcastCreatorFromLinks($page);
$l2pc->setTitle($title);
$l2pc->setDesc($desc);
$l2pc->setType($type);
$l2pc->setExcludeLink($exclude);
$l2pc->setDelType($delType);
$l2pc->setImage($image);
$feed2podcast->setDelStr($delStr);
$feed2podcast->setUpdateHours($updateHours);
$l2pc->getFeed();
