<html>
<head>
<title></title>
</head>
<body>
<?php

function pg_connection_string_from_database_url() {
  extract(parse_url($_ENV["DATABASE_URL"]));
  return "user=$user password=$pass host=$host dbname=" . substr($path, 1); # <- you may want to add sslmode=require there too
}

$pg_conn = pg_connect(pg_connection_string_from_database_url());

$prodName=$_POST["searchText"];
echo $prodName;

$result = pg_query($pg_conn, "SELECT Id, Name, sfid, isactive, country__c, state__c FROM salesforce.Product2 Where Name=".$prodName);
print "<pre>\n";

  print "Records in the Products:\n";
  while ($row = pg_fetch_row($result)) { print("- $row[0]\n"); }

print "\n";

?>
</body>
</html>