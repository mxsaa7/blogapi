<?php 

class Post{

    private $conn;
    private $table = 'posts';
    

    //post properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $date_created;

    public function __construct($db){
        $this->conn = $db;
    }

    //GET posts
    public function read(){
        $query = 
        'SELECT 
        c.name as category_name,
        p.id, 
        p.category_id,
        p.title,
        p.body, 
        p.author,
        p.created_date
        FROM
        ' . $this->table .' p
        LEFT JOIN
            categories c ON p.category_id = c.id
        ORDER BY 
            p.created_date DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;

    }


}

?>