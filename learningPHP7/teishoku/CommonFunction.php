<?php

function accessDatabase ($dbname, $user, $pwd = null) {
    
    try {
        
        $dsn = 'mysql:dbname='.$dbname.';host=localhost';
        if (empty($pwd)) {
            $dbh = new PDO($dsn, $user);
        } else {
            $dbh = new PDO($dsn, $user, $pwd);
        }
        
        return $dbh;
        
    } catch (PDOException $e) {
        print 'DB Connection failed:'.$e->getMessage();
        die;
    }
    
}

?>