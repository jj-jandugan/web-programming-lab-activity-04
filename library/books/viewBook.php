<?php

require_once "../classes/book.php";
$bookObj = new Book();

$search="";
$filter="";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $search = isset($_GET["search"])? trim(htmlspecialchars($_GET["search"])): "";
    $filter = isset($_GET["filter"])? trim(htmlspecialchars($_GET["filter"])): "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book</title>
     <style>
        table, tr, td {border-collapse: collapse;}
        tr, th, td {padding: 10px;}
        th, a {font-weight: bold;}
        td, a{text-align: center; text-decoration: none;}
    </style>
</head>
<body>
    <h1>List of Books</h1>
    <form action="" method="get">
        <label for="">Search: </label>
        <input type="text" name="search" id="search" value="<?= $search ?>">
        <input type="submit" value="Search"><br>

        <label for="">Filter: </label>
        <select name="filter" id="filter">
            <option value="">--Select Genre</option>
            <option value="History" <?=($filter=="History")? "selected":"" ?>>History</option>
            <option value="Science" <?=($filter=="Science")? "selected":"" ?>>Science</option>
            <option value="Fiction" <?=($filter=="Fiction")? "selected":"" ?>>Fiction</option>
        </select>
        <input type="submit" value="Filter">
    </form>

    <button><a href="addbook.php">Add Book</a></button>
    <table border="1">
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Publication Year</th>
        </tr>
        <?php
        $id = 1;
        foreach($bookObj->viewBook($search,$filter) as $book){
        ?>

        <tr>
            <td><?= $id++?></td>
            <td><?= $book["title"]?></td>
            <td><?= $book["author"]?></td>
            <td><?= $book["genre"]?></td>
            <td><?= $book["publication_year"]?></td>
        </tr>
        <?php
        }

        ?>
    </table>
</body>
</html>