<?php
class Post
{
    private $connect;
    private $table = 'posts';

    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $author;
    public $created_at;

    public function __construct($db)
    {
        $this->connect = $db;
    }

    public function read()
    {
        //create query
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
        FROM ' . $this->table . ' p
        LEFT JOIN
            categories c ON p.category_id = c.id
        ORDER BY
            p.created_at DESC';

        //prepare statemetm
        $stmt = $this->connect->prepare($query);
        //execute query 
        $stmt->execute();
        return $stmt;
    }


    public function read_single()
    {
        $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
        FROM ' . $this->table . ' p
        LEFT JOIN
            categories c ON p.category_id = c.id
        WHERE
        p.id = ?
        LIMIT 0,1';

        //prepare statemetm
        $stmt = $this->connect->prepare($query);

        $stmt->bindParam(1, $this->id);

        //execute query 
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . '
        SET
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id';


        $stmt = $this->connect->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            return true;
        }
        //print error if something goes wrong
        printf("error: %s.\n", $stmt->error);
        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->table . '
        SET
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id
        WHERE
            id = :id';


        $stmt = $this->connect->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));


        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        //print error if something goes wrong
        printf("error: %s.\n", $stmt->error);
        return false;
    }


    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->connect->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        //print error if something goes wrong
        printf("error: %s.\n", $stmt->error);
        return false;
    }
}
