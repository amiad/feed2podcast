<?php
require('../feed2podcast.php');
$feed2podcast = new PodcastFeedCreator('test.atom');

/* optional */
$feed2podcast->setType('mp3'); //file type, default mp3
$feed2podcast->setUpdateHours(1); //How often the cache is updated (in hours), default 5
/* end optional */

$feed2podcast->getFeed();
