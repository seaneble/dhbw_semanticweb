<?php

require_once("sparqllib.php");
$db = sparql_connect("http://localhost:3030/ds/query");
$builder = new sparql_builder();

if ($urlParam = isset($_GET['query'])) {
    $query = $_GET['query'];
    $sparql_query = $builder->create_sparql_query($query);
    $result = $db->query($sparql_query);
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
                <input name="query" type="search" required placeholder="Enter SPARQL here">
                <input type="submit" value="Query">
            </div>
        </form>

<?php } if (0): ?>
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
