<?php

require_once("sparqllib.php");
$db = sparql_connect("http://localhost:3030/ds/query");
$builder = new sparql_builder();

if ($urlParam = isset($_GET['query'])) {
    $query = $_GET['query'];
    $sparql_query = $builder->create_sparql_query($query);
    $xml = $db->dispatchQuery($sparql_query, 3, urlencode($query));
    # Führt zu Download statt Anzeige
//    header('Content-type: application/sparql-results+xml');
    header('Content-type: application/xml');
    echo $xml;
} else {
    header('Content-type: text/html');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Semantic Search</title>
        <link rel="stylesheet" type="text/css" media="all" href="search.css">
    </head>
    <body>
        <h1>Movie Query Engine</h1>
        <form method="get">
            <div class="formbody">
                <input name="query" type="search" placeholder="Search for a movie, actor or genre. Or leave blank for all results.">
                <input type="submit" value="Query">
            </div>
        </form>
    </body>
</html>
<?php } ?>
