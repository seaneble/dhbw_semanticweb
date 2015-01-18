<?php

header('Content-type: text/xsl');

require_once("sparqllib.php");
$db = sparql_connect("http://localhost:3030/ds/query");
$builder = new sparql_builder();

if ($urlParam = isset($_GET['query'])) {
    $query = $_GET['query'];
} else {
    $query = "'" . 'PREFIX plants: <http://www.linkeddatatools.com/plants> SELECT * WHERE { ?name plants:family ?family}' . "'";
}

$sparql_query = $builder->create_sparql_query($query);
$result = $db->query($sparql_query);
$xml = $db->dispatchQuery($sparql_query, 3, urlencode($query));

if ($xml == '<?xml version="1.0"?>
<sparql xmlns="http://www.w3.org/2005/sparql-results#">
  <head>
    <variable name="name"/>
    <variable name="family"/>
  </head>
  <results>
  </results>
</sparql>
') {
    $empty = true;
} else {
    $empty = false;
}

echo $xml;

if (false):

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Semantic Search</title>
        <style type="text/css">
            body { font-family: sans-serif; }
            form { overflow: auto; }
            input { font-size: 120%; float: left; display: block; }
            input[type=search] { width: 90%; padding: 5px; border: 2px solid rgba(146, 178, 193, 1); height: 35px; }
            input[type=submit] { width: 9%; height: 35px; background-color: rgba(146, 178, 193, 1); border: none; color: #fff; }
            h1, h2 { font-weight: normal; }
        </style>
    </head>
    <body>
        <h1>Movie Query Engine</h1>
        <form method="get">
            <div class="formbody">
                <input name="query" type="search" required placeholder="Enter SPARQL here"<?php if (!$empty): ?> value="<?php echo $query; ?>"<?php endif; ?>>
                <input type="submit" value="Query">
            </div>
        </form>
<?php if (!$empty && isset($result)): ?>
<?php $fields = $result->field_array(); ?>
        <div class="results">
            <h2>Results (<?php echo $result->num_rows(); ?>)</h2>
            <table>
                <thead>
                    <tr>
<?php foreach ($fields as $field): ?>
                        <th><?php echo $field; ?></th>
<?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
<?php while ($row = $result->fetch_array()): ?>
                    <tr>
<?php foreach ($fields as $field): ?>
                        <td><?php echo $row[$field]; ?></td>
<?php endforeach; ?>
                    </tr>
<?php endwhile; ?>
                </tbody>
            </table>
        </div>
<?php endif; ?>
    </body>
</html>
<?php endif; ?>
