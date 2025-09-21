<?php

require_once "database.php";

class Book extends Database{
    public $id="";
    public $title="";
    public $author="";
    public $genre="";
    public $publication_year="";


    public function addBook(){
        $sql="INSERT INTO book(id,title,author,genre,publication_year) VALUE (:id, :title, :author, :genre, :publication_year)";

        $query = $this->connect()->prepare($sql);

        $query->bindParam(":id", $this->id);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":publication_year", $this->publication_year);
        
        return $query->execute();
    }    

    public function viewBook($search="",$filter=""){
        $sql = "SELECT * FROM book WHERE title LIKE CONCAT('%', :search, '%') AND genre LIKE CONCAT('%', :filter, '%') ORDER BY title ASC";
        $query = $this->connect()->prepare($sql);
        $query->bindParam(":search", $search);
        $query->bindParam(":filter", $filter);

        if($query->execute()){
            return $query->fetchAll();
        }else{
            return null;
        }
    }

    public function isBookExist($title){
    $sql = "SELECT COUNT(*) as total FROM book where title=:title";
    $query =$this->connect()->prepare(sql);
    $query ->bindParam(":title", $title);
    $record=null;

    if($query->execute()){
        $record=$query->fetch();
    }

    if($record["total"] >0){
        return true;
    }else{
        return false;
       }
    }

}

// $obj=new Book();
// $obj->title="Cosmos";
// $obj->auhtor="Sagan";
// $obj->genre="Science";
// $obj->publication_year=1980;

// var_dump($obj->addBook());