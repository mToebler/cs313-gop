<?php 
// try
// {
//    // THIS NEEDS TO CHANGE BEFORE COMMIT AND SUBMIT
//    //$db = new PDO("pgsql:host=your_host_name;port=your_database_port;dbname=your_database_name", your_user_name, your_password);
//   $user = 'postgres';
//   $password = 'perunga4dmin';
//   $db = new PDO('pgsql:host=localhost;dbname=mark', $user, $password);

//   // this line makes PDO give us an exception when there are problems,
//   // and can be very helpful in debugging! (But you would likely want
//   // to disable it for production environments.)
//   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// }
// catch (PDOException $ex)
// {
//   echo 'Error!: ' . $ex->getMessage();
//   die();
// }

// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// trying to just have one for both databases local and heroku

// default Heroku Postgres configuration URL
$dbUrl = getenv('DATABASE_URL');

if (empty($dbUrl)) {
   // example localhost configuration URL with postgres username and a database called cs313db
   $dbUrl = "postgres://postgres:password@localhost:5432/mark";
}

$dbopts = parse_url($dbUrl);

//print "<p>$dbUrl</p>\n\n";

$dbHost = $dbopts["host"];
$dbPort = $dbopts["port"];
$dbUser = $dbopts["user"];
$dbPassword = $dbopts["pass"];
$dbName = ltrim($dbopts["path"],'/');

//print "<p>pgsql:host=$dbHost;port=$dbPort;dbname=$dbName</p>\n\n";

try {
      $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
}
catch (PDOException $ex) {
      print "<p>error: $ex->getMessage() </p>\n\n";
      die();
}


?>