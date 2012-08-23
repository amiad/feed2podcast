<?php
require('../feed2podcast.php');
$feed2podcast = new PodcastFeedCreator('test.atom');

/* optional */
$feed2podcast->setType('mp3'); //file type, default mp3
$feed2podcast->setUpdateHours(1); //How often the cache is updated (in hours), default 5
$feed2podcast->setImage('https://www.google.com/images/srpr/logo3w.png'); //podcast logo url, default none;
$feed2podcast->setDelStr(); // delete substring in file url. for sites that redirect the download via other. file.
/* end optional */

$feed2podcast->getFeed();
