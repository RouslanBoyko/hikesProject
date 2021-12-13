<?php
$servername = "188.166.24.55";
$username = "jepsen5-anishanderson";
$password = "m4xM0z,)C&4gGrg}XN2<";
$dbname = "jepsen5-anishanderson";
$port = "";

$pdo = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];
$title = '';
$distance = '';
$description = '';
$imagePath = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title']; // test
    $description = $_POST['description'];
    $distance = $_POST['distance'];


    if (!$title) {
        $errors[] = 'Hike title is required';
    }
    if (!$distance) {
        $errors[] = 'Hike distance is required';
    }

    if (!is_dir('images')) {
        mkdir('images');
    }

    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;
        if ($image && $image['tmp_name']) {

            $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
            mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        $statement = $pdo->prepare("INSERT INTO hikes(title,image,description,distance)
                    VALUES (:title, :image, :description, :distance)");
        $statement->bindValue(':title', $title);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':distance', $distance);
        $statement->execute();
        header('Location:index.php');
    }
}
function randomString($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $str .= $characters[$index];
    }
    return $str;
}

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>Hikes CRUD</title>
</head>
<body>
<h1>Create new Hike</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <div><?php echo $error ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form action="" method="post" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Hike Image</label><br>
        <input type="file" name="image">
    </div>

    <div class="mb-3">
        <label>Hike title</label>
        <input type="text" name="title" class="form-control" value="<?php echo $title ?>">
    </div>

    <div class="mb-3">
        <label>Hike Description</label>
        <textarea class="form-control" name="description"><?php echo $description ?></textarea>
    </div>

    <div class="mb-3">
        <label>Hike Distance</label>
        <input type="number" step=".01" name="distance" value="<?php echo $distance ?>" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

</form>
</body>
</html>


