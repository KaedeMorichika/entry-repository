
<?php
    
    $dsn = 'mysql:dbname=db0414;host=localhost';
    $user = 'root';
    try {
        $dbh = new PDO($dsn, $user);
        $sql = 'SELECT * FROM players WHERE name=? OR name=?';
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array('harden', 'westbrook'));
        $records = $stmt->fetchAll();
        foreach ($records as $row) {
            echo('<pre>');
            var_dump($row);
            echo('</pre>');
            print $row[0].$row[1].$row[2].'<br>';
        }
    } catch (PDOException $e) {
        print ('Connection failed:'.$e->getMessage());
        die;
    }
    
    $dbh = null;
?>
