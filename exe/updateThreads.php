<?php
if(php_sapi_name() != 'cli') echo "<pre>";
//this will probably take a while to execute.
//log in to mysql
require "../include/db.php";
require "feed.class.php";
//Get list of threads from mysql
$feeds = $db->query("SELECT * FROM `rssfeeds`");

if(!$feeds) echo $db->error;

//set up prepared query for checking to see if we already have an entry (by using the date and title of the item) as well as one for adding items
$additem = $db->prepare("INSERT INTO `rssitems` (`feed`,`link`,`subject`,`date`,`content`) VALUES (?, ?, ?, ?, ?)");
$additem->bind_param("issss",$feedid, $link,$subject,$date,$content);

$checkitem = $db->prepare("SELECT `id` FROM `rssitems` WHERE date=? AND subject=?");
$checkitem->bind_param("ss",$date,$subject);

while($row = $feeds->fetch_assoc()){
//if thread does not update often, and it has been checked recently, skip
  //download rss
  $rss = Feed::loadRss($row['url']);
  //for each rss:
  foreach($rss->item as $item){
  //if the current one exists, break here (move to next feed).
    //echo $item->title," - ",date("Y-m-d H:i:s",(int)$item->timestamp),"\n";
	$subject = $item->title;
	$link = $item->link;
	$date = date("Y-m-d H:i:m",(int)$item->timestamp);
	$content = (string)$item->description;
	$feedid = $row['id'];
	$checkitem->execute();
	$checkitem->store_result();

	if($checkitem->num_rows==0){
		echo "Adding item: ",$row['title']," - ",$subject,"... ",$additem->execute(),$db->error,"\n";
	} else {
		echo "Skipping the rest of this feed...\n";
		break;
	}
  }
}
echo "Scrape Complete.";
$additem->close();
$checkitem->close();
if(php_sapi_name() != 'cli') echo "</pre>";
?>