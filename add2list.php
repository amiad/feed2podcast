<?php
// Example to form for add links to the list for list2podcast

// list filename 
$list='list.txt';
?>
<!DOCTYPE html>
<html>
<head><title>Add link to the list</title></head>
<body>
<?php
if($_POST['submit']){
	echo '<p id="message">The link added</p>';
	file_put_contents($list,"$_POST['url']|$_POST['title']", FILE_APPEND);
}
?>
<form method="post">
<label for="url">URL file:</label><input type="text" id="url" name="url" /><br />
<label for="title">Title</label><input type="text" id="title" name="title" /> <br />
<input type="submit" id="submit" name="submit" value="Add" />
</form>
</body>
</html>

