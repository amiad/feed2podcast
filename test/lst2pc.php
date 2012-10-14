<?php

/* required */
$list='list.txt'; //list path or url

/* optional */
$title='Test'; // feed title
$desc='Test list'; // feed description

/* not touch */
require('../core/list2podcast.php');
$lst2pc=new PodcastCreatorFromList($list);
$lst2pc->setTitle($title);
$lst2pc->setDesc($desc);
$lst2pc->getFeed();
