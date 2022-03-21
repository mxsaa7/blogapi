<?php 

class DB{



    function conn(){
        try{
            $username = 'root';
            $password = '';
            $db = new PDO('mysql:host=localhost; dbname=phprest', $username, $password);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            return $db;
        }
        catch(PDOException $e){
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
    }
        


    
}




?>