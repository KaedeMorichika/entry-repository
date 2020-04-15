
<?php
    
    $dsn = 'mysql:dbname=db0414;host=localhost';
    $user = 'root';
    try {
        $dbh = new PDO($dsn, $user);
        $sql = 'SELECT * FROM players WHERE name=? OR name=?;';
        $stmt = $dbh->prepare($sql);
        $stmt->execute(array('harden', 'westbrook'));
        $records = $stmt->fetchAll();
        echo('<pre>');
        var_dump($records);
        echo('</pre>');
        foreach ($records as $row) {
            foreach ($row as $value) {
                print $value.'<br>';
            }
        }
    } catch (PDOException $e) {
        print ('Connection failed:'.$e->getMessage());
        die;
    }
    

?>
