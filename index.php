<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="include/smoothscroll.js"></script>
  <link rel="stylesheet" href="css/jquery-ui-1.10.1.custom.min.css"/>
  <!--   This will be exported to a file later for performance - but now we can just worry about the cache -->
  <style>
  body, body div {
    margin:0px;
    padding:0px;
  }
  body {
    position:absolute;
    right:0px;
    left:0px;
    top:0px;
    bottom:0px;
    height: 100%;
    width:100%;
    display: table;
  }
  body div.content {
    display: table-cell;
    vertical-align: top;
    width:100%;
  }
  .fromFeed{
	float:right;
  }
  h3.read{
	color:#bbb;
  }
  body div.sidebar {
    display: table-cell;
    vertical-align: top;
    min-width:200px;
    background-image: linear-gradient(right top, #DBDBDB 29%, #FFFFFF 65%);
    background-image: -o-linear-gradient(right top, #DBDBDB 29%, #FFFFFF 65%);
    background-image: -moz-linear-gradient(right top, #DBDBDB 29%, #FFFFFF 65%);
    background-image: -webkit-linear-gradient(right top, #DBDBDB 29%, #FFFFFF 65%);
    background-image: -ms-linear-gradient(right top, #DBDBDB 29%, #FFFFFF 65%);
  }
  .ui-accordian-content {
	padding:2px;
	overflow:auto;
	font-size:12px;
  }
  </style>
  <script>
	var o = {};
	var l = {
		loading:"Loading Articles, Please wait...",
		end:"There are no more items to view",
		none:"There are no items in this category"
	}
	function loadBox(text){
	console.log("Loadbox:",text)
		if(text){
			$(o.l).fadeIn().text(text);
		} else {
			$(o.l).fadeOut();
		}
	}
	$(function() {
		o = {
			f:document.getElementById("feedlist"),
			l:document.getElementById("load")
		}
		loadBox(l.loading);
		fetchData();
	});
	function destroyAccordion(){
		var active = false;
		if($(o.f).hasClass("ui-accordion")){
			active = $(o.f).accordion('option', 'active');
			$(o.f).accordion("destroy");
		}
		return active;
	}
	function refreshAccordion(a){
		$(o.f).accordion({
			active: a,
			beforeActivate:function(event,ui){
				console.log(ui.newHeader[0].getAttribute("name"));
				ui.newHeader.addClass("read");
				$.post("");
				return true;
				//send 'read' notification
			},
			heightStyle: "content",
			collapsible : true
		});
	}
	function fetchData(more){
		loadBox(l.loading);
		$.ajax("activity/fetch.php",{
			data:{start:more?more:0,length:more?30:(screen.height/50+10),folder:0},
			dataType:"json",
			type:"GET",
			success:function(a){
				//add results to accordian
				var lb = "";
				var active = destroyAccordion();
				var len = a.length;
				if(a.length==0) lb = l.end;
				else for(var i=0;i<len;i++){
					$(o.f).append("<h3 name="+a[i].id+">"+
						(a[i].subject.length<60?a[i].subject:a[i].subject.substring(0,60)+"...")+
						"</a><span class=\"fromFeed\">"+
						a[i].feed
						+"</span></h3><div>"+
						"<h2><a target= \"_blank\" href=\""+a[i].link+"\">"+
						a[i].subject+"</a></h2>"+
						a[i].content+
						"</div>");
				}
				refreshAccordion(active);
				loadBox(lb);
			},
			error:function(a,b,c){console.log(a,b,c);}
		});
	}
	function loadFolder(ref){
		loadBox(l.loading);
		destroyAccordion();
		o.f.innerHTML="";
		//stuff
		fetchData();
	}
	//event handler for infinite scrolling
	$(window).scroll(function(){  
		if($(window).scrollTop() == $(document).height() - $(window).height()){  
			fetchData($("h3").length);
		}
    });
	//keystrokes 
	$(window).keypress(function(event){
		console.log(event.keyCode);
		switch (event.keyCode){
			case 106: //j - next item
				var j = $(".ui-accordion-header.ui-state-active");
				if(j.length==0) $("h3",o.f).first().trigger("click");
				else j.next().next("h3").trigger("click");
				break;
			case 107: //k - previous item
				$(".ui-accordion-hejader.ui-state-active").prev().prev("h3").trigger("click");
				break;
			
		}
	});
  </script>
</head>
<body>
<!-- I guess there should be a sidebar if we want to follow Google's example - though sidebars generally are a pain in the butt -->
<div class="sidebar">
  <h1 onclick="window.open('exe/updateThreads.php')">SR</h1>
  <ul>
    <li><a href="javascript:loadFolder();">All items</a></li>
    <li>Starred items</li>
    <li>Trends</li>
    <br/>
    <li>Subscriptions</li>
    <ul>
      <li>IHC</li>
      <li>Books of Adam</li>
      <li>The Oatmeal</li>
      <li>(this is a lie)</li>
    </ul>
  </ul>
</div>
<!-- Main content -->
<div class="content">
  <div id="feedlist"><!-- Populated with javascript --></div>
  <div id="load" style="margin:10px;" class="ui-state-highlight ui-corner-all"><noscript>This webpage requires JAVASCRIPT and COOKIES to be enabled.</noscript></div>
</div>
</body>
</html>