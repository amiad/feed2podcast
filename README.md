# feed2podcast
Convert feed rss with audio files or html page with audio files to podcast feed with enclosure element.

##  Instructions
* Copy f2pc.php (for to convert feed) or l2pc.php (for convert html page with links) and rename.
* Edit the new file and change the settings according to what you want.

### Settings
* feed - feed url for proccess (f2pc only, required)
* page - page url for proccess (l2pc only, required)
* type - type of audio files, default mp3. multi types in array. example: array('mp3','wma') 
* image - url of feed image
* delStr - delete substring in file url. for sites that redirect the download via other
* updateHours - how often the cache is updated (in hours), default 5
* title - feed title (l2pc only)
* desc - feed description (l2pc only)
* exclude - links with this string not adding to feed (l2pc only)
* delType - to delete file extension from item title, default true (l2pc only)
