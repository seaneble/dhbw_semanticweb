<?php 
// Author: John Wright
// Website: http://johnwright.me/blog
// This code is live @ 
// http://johnwright.me/code-examples/sparql-query-in-code-rest-php-and-json-tutorial.php


function getUrlDbpediaAbstract($term)
{
   $format = 'xml';
 
   $query = 
   "SELECT *
   WHERE {
      ?s ?p ?o
   }";
 
   $searchUrl = 'http://localhost:3030/ds/'
      .'query='.urlencode($query)
      .'&format='.$format;
	  
   return $searchUrl;
}


function request($url){
 
   // is curl installed?
   if (!function_exists('curl_init')){ 
      die('CURL is not installed!');
   }
 
   // get curl handle
   $ch= curl_init();
 
   // set request url
   curl_setopt($ch, 
      CURLOPT_URL, 
      $url);
 
   // return response, don't print/echo
   curl_setopt($ch, 
      CURLOPT_RETURNTRANSFER, 
      true);
 
   /*
   Here you find more options for curl:
   http://www.php.net/curl_setopt
   */		
 
   $response = curl_exec($ch);
 
   curl_close($ch);
 
   return $response;
}



$term = "Honda_Legend";

$requestURL = getUrlDbpediaAbstract($term);

$response = request($requestURL)

?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml">
 
<head>
 
<title>Using SPARQL in code: REST, PHP and JSON [EXAMPLE CODE]</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
 
<body>
<h1>DBPedia Abstract for 
<?php echo $term ?></h1>
 
<h3>Request URL:</h3>
<?php echo $requestURL ?>
<br/>
 
<h3>Parsed Response: </h3>
<?php echo $response; ?>
<br/>
 
<h3>Abstract: </h3>

   <br/>
</body>
</html>