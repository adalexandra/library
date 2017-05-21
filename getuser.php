<!DOCTYPE html>
<html>
<head>
<style>
table {
    width: 100%;
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
    padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$q = $_GET['q'];
    echo $q;

include 'dbconnect.php';

$sql="SELECT * FROM books WHERE title LIKE '".$q."%'";
$result = mysqli_query($connection,$sql);

echo "<table>
<tr>
<th>Title</th>
<th>Author</th>
<th>Price</th>
<th>Available</th>
<th>Published by</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['title'] . "</td>";
    echo "<td>" . $row['author'] . "</td>";
    echo "<td>" . $row['price'] . "</td>";
    echo "<td>" . $row['available'] . "</td>";
    echo "<td>" . $row['published_by'] . "</td>";
    echo "</tr>";
}
echo "</table>";
mysqli_close($connection);
?>
</body>
</html>