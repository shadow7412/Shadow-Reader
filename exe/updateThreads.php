#!/usr/bin/env php
<?php
$buffer = "";
function output(){
	global $buffer;
	$d = implode(func_get_args());echo "> ",$d;$buffer.=$d;
}
if(php_sapi_name() != 'cli') echo "<pre>"; //We don't need to keep the pretags... That's why we echo instead of output.
//this will probably take a while to execute.
//log in to mysql
$feedcount = $errors = $newitems = 0;
require "../include/db.php";
require "../include/feed.class.php";
//Get list of threads from mysql
if($db->connect_error) output($db->connect_error);
$feeds = $db->query("SELECT * FROM `rssfeeds`");

if(!$feeds) output($db->error);

//set up prepared query for checking to see if we already have an entry (by using the date and title of the item) as well as one for adding items
$additem = $db->prepare("INSERT INTO `rssitems` (`feed`,`link`,`subject`,`date`,`content`) VALUES (?, ?, ?, ?, ?)");
$additem->bind_param("issss",$feedid, $link,$subject,$date,$content);

$checkitem = $db->prepare("SELECT `id` FROM `rssitems` WHERE date=? AND subject=?");
$checkitem->bind_param("ss",$date,$subject);

while($row = $feeds->fetch_assoc()){
  $feedcount++;
//if thread does not update often, and it has been checked recently, Perhaps look for patterns in history?
  //download rss
  output("Scraping ",$row['title'],"...\n");
  $rss = Feed::loadRss($row['url']);
  if(!$rss){
	$errors++;
	output("Failed to scrape :(\n");
  }
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
	      output("\tAdding item",++$newitems,": ",$row['title']," - ",$subject,"... ",$additem->execute()?"Success":"Failed",$db->error,"\n");
	} else {
	      output("\tFound entry we already have - skipping rest of thread.\n");
	      break;
	}
  }
}
output("Scrape Complete - ",$time=time()-$_SERVER['REQUEST_TIME']," seconds.");
$additem->close();
$checkitem->close();
$db->query("INSERT INTO `scrapemetrics` (`feeds`,`time`,`items`,`errors`,`details`) VALUES ($feedcount,$time,$newitems,$errors,'"
	.$db->real_escape_string($buffer)
	."')");
if(php_sapi_name() != 'cli') echo "</pre>";
?>
