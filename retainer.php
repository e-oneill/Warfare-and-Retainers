<?php 
    session_start();

if(isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: index.php");
}
?>

<!doctype html>
<html>
    
<head>
    <title>Monkehh's DM Tools</title>
   <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
     <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="dom-to-image.min.js"></script>
<!--<script src="html2canvas.js"></script>-->
<script>
function URL_add_parameter(url, param, value)
    {
    var hash       = {};
    var parser     = document.createElement('a');

    parser.href    = url;

    var parameters = parser.search.split(/\?|&/);

    for(var i=0; i < parameters.length; i++) {
        if(!parameters[i])
            continue;

        var ary      = parameters[i].split('=');
        hash[ary[0]] = ary[1];
    }

    hash[param] = value;

    var list = [];  
    Object.keys(hash).forEach(function (key) {
        list.push(key + '=' + hash[key]);
    });

    parser.search = '?' + list.join('&');
//    return parser.href;
    location.href = parser.search;
}    

	// A function to convert the required div to image
	function doCapture() {
	window.scrollTo(0, 0);

	html2canvas(document.getElementById("capture")).then(function (canvas) {

		// Create an AJAX object
		var ajax = new XMLHttpRequest();

		// Setting method, server file name, and asynchronous
		ajax.open("POST", "savecapture.php", true);

		// Setting headers for POST method
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		// Sending image data to server
		ajax.send("image=" + canvas.toDataURL("image/jpeg", 0.9));

		// Receiving response from server
		// This function will be called multiple times
		ajax.onreadystatechange = function () {

			// Check when the requested is completed
			if (this.readyState == 4 && this.status == 200) {

				// Displaying response from server
				console.log(this.responseText);
			}
		};
	});
}

    

</script>     

<link href="dmtools.css" rel="stylesheet" type="text/css">
    
    </head>
<body>
<?php include "page-header.php"; ?>

    
    
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
    <li class="breadcrumb-item"><a href="myretainers.php">My Retainers</a></li>
  </ol>
</nav>
    
<div id="retainer-container" class="container-flex retainer-container">
    <div class="row">
        <div id="retainer-col" class="col-md-12">
    <?php
    
        include "retainercardgenerator.php";
        
        ?>
    
        </div>
    </div>
</div>
    
