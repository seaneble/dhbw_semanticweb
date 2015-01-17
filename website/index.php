<?php
    
    if ($results = isset($_GET['query'])) {
        require_once("sparqllib.php");
        $db = sparql_connect("http://localhost:3030/ds/query");
        $builder = new sparql_builder();
        $query = htmlspecialchars($_GET['query']);
        $sparql_query = $builder->create_sparql_query($query);
        $result = $db->query($sparql_query);
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Semantic Search</title>
    </head>
    <body>
        <h1>Movie Query Engine</h1>
        <form method="get">
            <div class="formbody">
                <input name="query" type="search" placeholder="Enter SPARQL here"<?php if ($results): ?> value="<?php echo $query; ?>"<?php endif; ?>>
                <input type="submit" value="Query">
            </div>
        </form>
<?php if (isset($result)): ?>
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
