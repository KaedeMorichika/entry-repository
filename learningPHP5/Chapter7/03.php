
<?php
    
    $dsn = 'mysql:dbname=db0414;host=localhost';
    $user = 'root';
    try {
        $dbh = new PDO($dsn, $user);
        $sql = 'SELECT * FROM dishes';
        //
        $stmt = $dbh->prepare($sql.' ORDER BY price');
        $stmt->execute();
        $records = $stmt->fetchAll();
        foreach ($records as $row) {
            print $row[0].' '.$row[1].' '.$row[2].' '.$row[3].'<br>';
        }
        //
        
        
    } catch (PDOException $e) {
        print ('Connection failed:'.$e->getMessage());
        die;
    }
    
    $dbh = null;
?>
