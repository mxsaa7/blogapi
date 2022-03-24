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

    public function read_single(){
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
        WHERE 
            p.id = ?
        LIMIT 0,1';

        //prepared statement
        $stmt = $this->conn->prepare($query);

        //bind param (ID):
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
        return $stmt;
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->table . '
            SET title = :title, 
                body = :body,
                author = :author,
                category_id = :category_id';
        $stmt = $this->conn->prepare($query);

        //Cleanse data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //bind data

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        if($stmt->execute()){
            return true;
        }

        printf("Error %s.\n", $stmt->error);

        return false;
        
    }

    public function update(){
        $query = 'UPDATE ' . $this->table . '
            SET title = :title, 
                body = :body,
                author = :author,
                category_id = :category_id
            WHERE
                id = :id';
        $stmt = $this->conn->prepare($query);

        //Cleanse data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind data

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }

        printf("Error %s.\n", $stmt->error);

        return false;
        
    }

    public function delete(){
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return true;
        }

        printf("Error %s.\n", $stmt->error);

        return false;
    }


}

?>