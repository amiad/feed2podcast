<?php

/* required */
$list='list.txt'; //list path or url

/* optional */
$title=''; // feed title
$desc=''; // feed description
$image=''; // feed image
$updateHours=5; //How often the cache is updated (in hours), default 5

/* not touch */
require('core/list2podcast.php');
$lst2pc=new PodcastCreatorFromList($list);
$lst2pc->setTitle($title);
$lst2pc->setDesc($desc);
$lst2pc->setImage($image);
$lst2pc->setUpdateHours($updateHours);
$lst2pc->getFeed();
