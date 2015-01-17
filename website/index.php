<?php
    
    if ($results = isset($_GET['query'])) {
        require_once("sparqllib.php");
        $db = sparql_connect("http://localhost:3030/ds/query");
        $query = $_GET['query'];
        $result = $db->query($query);
    }

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
                <input name="query" type="search" required placeholder="Enter SPARQL here"<?php if ($results): ?> value="<?php echo $query; ?>"<?php endif; ?>>
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
