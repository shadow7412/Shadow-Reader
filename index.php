<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css"/>
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
  body div.sidebar {
    display: table-cell;
    vertical-align: top;
    min-width:200px;
    background-image: linear-gradient(left top, #DBDBDB 29%, #FFFFFF 65%);
    background-image: -o-linear-gradient(left top, #DBDBDB 29%, #FFFFFF 65%);
    background-image: -moz-linear-gradient(left top, #DBDBDB 29%, #FFFFFF 65%);
    background-image: -webkit-linear-gradient(left top, #DBDBDB 29%, #FFFFFF 65%);
    background-image: -ms-linear-gradient(left top, #DBDBDB 29%, #FFFFFF 65%);
  } 
  </style>
  <script>
    $(function() {
      $("#feedlist").accordion({
	heightStyle: "content",
	collapsible: true,
	active: false
      });
    });
  </script>
</head>
<body>
<!-- I guess there should be a sidebar if we want to follow Google's example - though sidebars generally are a pain in the butt -->
<div class="sidebar">
  <h1>SR</h1>
  <ul>
    <li>All items</li>
    <li>Starred items</li>
    <li>Trends</li>
    <br/>
    <li>Subscriptions</li>
    <ul>
      <li>IHC</li>
      <li>Books of Adam</li>
      <li>The Oatmeal</li>
    </ul>
  </ul>
</div>
<!-- Main content -->
<div class="content">
  <div id="feedlist">
    <h3>First item</h3>
    <div>Content of first item</div>
    <h3>Second item</h3>
    <div>Content of Second item</div>
    <h3>Third item</h3>
    <div>Content of 3rd item</div>
  </div>
</div>
</body>
</html>