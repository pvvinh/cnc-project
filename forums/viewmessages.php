<?php

include("config.php");

if(isset($_GET['id']) == TRUE) {
	if(is_numeric($_GET['id']) == FALSE) {
		$error = 1;
	}

	if($error == 1) {
		header("Location: " . $config_basedir);
	}
	else {
		$validtopic = $_GET['id'];
	}
}
else {
	header("Location: " . $config_basedir);
}

require("header.php");

$topicsql = "SELECT topics.subject, topics.forum_id, forums.name FROM topics, forums WHERE topics.forum_id = forums.id AND topics.id = " . $validtopic . ";";
$topicresult = mysql_query($topicsql);

$topicrow = mysql_fetch_assoc($topicresult);

echo "<h2>" . $topicrow['subject'] . "</h2>";

echo "<a href='index.php'>" . $config_forumsname . " forums</a> -> <a href='viewforum.php?id=" . $topicrow['forum_id'] . "'>" . $topicrow['name'] . "</a>	<br /><br />";

$threadsql = "SELECT messages.*, users.username FROM messages, users WHERE messages.user_id = users.id AND messages.topic_id = " . $validtopic . " ORDER BY messages.date;";
$threadresult = mysql_query($threadsql);

echo "<table>";
	
while($threadrow = mysql_fetch_assoc($threadresult)) {
	echo "<tr class='head'><td><strong>Posted by <i>" . $threadrow['username'] . "</i> on " . date("D jS F Y g.iA", strtotime($threadrow['date'])) . " - <i>" . $threadrow['subject'] . "</i></strong></td></tr>";
	echo "<tr><td>" . $threadrow['body']. "</td></tr>";
	echo "<tr></tr>";
}
echo "<tr><td>[<a href='reply.php?id=" . $validtopic . "'>reply</a>]</td></tr>";
echo "</table>";


require("footer.php");

?>