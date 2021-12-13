<?php

$servername = "188.166.24.55";
$username = "jepsen5-anishanderson";
$password = "m4xM0z,)C&4gGrg}XN2<";
$dbname = "jepsen5-anishanderson";
$port = "";

$pdo = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search = $_GET['search'] ?? '';
if ($search)
{
    $statement = $pdo->prepare('SELECT * FROM hikes WHERE title LIKE :title ORDER BY id DESC');
    $statement->bindValue(':title' ,"%$search%");

}
else
{
    $statement = $pdo->prepare('SELECT * FROM hikes ORDER BY id DESC');

}
$statement->execute();

$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
    <!doctype html>
    <html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
              crossorigin="anonymous">
        <link rel="stylesheet" href="app.css">
        <title>Hikes CRUD</title>
    </head>
    <body>
    <h1>Hikes CRUD</h1>
    <p>
        <a href="create.php" class="btn btn-success">Create Hike</a>
    </p>

    <form>
        <div class="input-group mb-3">
            <input type="text" class="form-control"
                   placeholder="Search for hikes"
                   value ="<?php echo $search ?>"
                   name="search">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Title</th>
            <th scope="col">Distance</th>
            <th scope="col">Description</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $i => $product): ?>
            <tr>
                <th scope="row"><?php echo $i + 1 ?></th>
                <td>
                    <img src="<?php echo $product['image'] ?>" alt="" class="thumb-image">
                </td>
                <td><?php echo $product['title'] ?></td>
                <td><?php echo $product['distance'] ?></td>
                <td><?php echo $product['description'] ?></td>
                <td>
                    <a href="update.php?id=<?php echo $product['id']?>" class="btn btn-sm btn-primary">Edit</a>
                    <form style="display:inline-block" method="post" action="delete.php">
                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

    </body>
    </html>


<?php
/***************************** CONNEXION BASIQUE QUI MARCHE **********************************************
 * <?php
 * $servername = "database";
 * $username = "root";
 * $password = "123";
 * $dbname = "stt_db";
 * $port = "3306";
 *
 * try{
 * $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname",$username,$password);
 * $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
 * echo "Connected succesfully";
 * } catch(PDOException $e){
 * echo "Connection failed: " . $e -> getMessage();
 * }
 * ?>
 * */

?>