<?php
  
function pg_connection_string_from_database_url() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
}

$toBeDeleted= $_POST['search'];

$pg_conn = pg_connect(pg_connection_string_from_database_url());
$toDelete = pg_query($pg_conn, "SELECT sfid, Name, isactive, country__c, state__c FROM salesforce.Product2 where sfid=". $toBeDeleted);

$res = pg_delete($pg_conn, 'post_log', $toDelete);

if($toDelete){

echo "Record found!";
  
  while ($row = pg_fetch_row($toDelete)) {
  echo "<tr>";
  echo "<td>$row[0]</td>". "<td>$row[1]</td>". "<td>$row[2]</td>". "<td>$row[3]</td>". "<td>$row[4]</td>";
  echo "</tr>";
}
  
}

if (!$res) {
  echo "Record not found";
  exit;
}

else{
  echo "the record has been deleted";
}

?>
