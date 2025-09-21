<?php
    require_once "../classes/book.php";
    $bookObj= new Book();
    $existingBooks = $bookObj->viewBook();

    $book =["title"=>"", "author"=>"", "genre"=>"", "publication_year"=>""];
    $errors =["title"=>"", "author"=>"", "genre"=>"", "publication_year"=>""];

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $book["title"] = trim(htmlspecialchars($_POST["title"]));
        $book["author"] = trim(htmlspecialchars($_POST["author"]));
        $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
        $book["publication_year"] = trim(htmlspecialchars($_POST["publication_year"]));

    if (empty($book["title"])) {
        $errors["title"] = "Title is required.";
    } else {
        foreach ($existingBooks as $existingBook) {
            if (strcasecmp($book["title"], $existingBook["title"]) === 0) {
                $errors["title"] = "Title already exists.";
                break;
        }
    }
}

    if(empty($book["author"])){
        $errors["author"]= "Author name is required.";
    }

    if(empty($book["genre"])){
        $errors["genre"]= "Genre is required.";
    }

    if(empty($book["publication_year"])){
        $errors["publication_year"]= "Publication year is required.";
    }else if (!is_numeric($book["publication_year"])){
        $errors["publication_year"]= "Publication year must be a number.";
    }else if($book["publication_year"]>2025){
        $errors["publication_year"]= "Publication year can't be in the future.";
    }

    if(empty(array_filter($errors))){
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->genre = $book["genre"];
        $bookObj->publication_year = $book["publication_year"];

        if($bookObj->addBook()){
            header("Location:viewBook.php");
        }else{
            echo "failed";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        label{display: block;}
        span, .error{color: red; margin: 0;}
        label {
            font-weight: bold;
            display: block;
        }
        input, select {margin-bottom: 10px;}
    </style>
</head>
<body>
    <h1>Add Book</h1>
    <form action="" method="post">
        <label for="">Title</label><br>
        <input type="text" name="title" id="title" value="<?= $book["title"]?>"><br>
        <p class="error"><?= $errors["title"] ?></p>

        <label for="">Author</label><br>
        <input type="text" name="author" id="author" value="<?= $book["author"]?>"><br>
        <p class="error"><?= $errors["author"] ?></p>
        
        <label for="">Genre</label><br>
        <select name="genre" id="genre"><br>
            <option value="">--Select Genre</option>
            <option value="History" <?=($book["genre"]=="History")? "selected":"" ?>>History</option>
            <option value="Science" <?=($book["genre"]=="Science")? "selected":"" ?>>Science</option>
            <option value="Fiction" <?=($book["genre"]=="Fiction")? "selected":"" ?>>Fiction</option>
        </select><br>
        <p class="error"><?= $errors["genre"] ?></p>

        <label for="">Publication Year</label><br>
        <input type="number" name="publication_year" id="publication_year" value="<?= $book["publication_year"]?>"><br>
        <p class="error"><?= $errors["publication_year"] ?></p>

        <input type="submit" value="Submit">
    </form>
</body>
</html>