<?php
try
{
    $pdo = new PDO('mysql:host=localhost; dbname=autocompletion; charset=utf8', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}
catch (PDOException $e)
{
    die("Erreur : " . $e -> getMessage());
}
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>AutoComplétion</title>
        <!-- Link CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/recherche.css">
    </head>

    <body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">
                <img src="images/pagani.png" alt="pagani" class="d-inline-block align-text-top">
                <span>PowerCars</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <form action="" method="get">
                <div class="input-group">
                    <label for="cars">
                        <input class="form-control" id="cars" name="modele_cars" autocomplete="off">
                        <div id="matchList"></div>
                    </label>
                </div>
            </form>
        </nav>
    </header>

    <main>
        <article>
            <section class="container-fluid search">
                <?php
                if (isset($_GET['modele_cars']) && $_GET['modele_cars'] !== "")
                {
                    echo ('<div class=""><h1 id="titleSearch">Résultat de votre recherche : "' . $_GET['modele_cars'] . '"</h1></div>');
                }
                ?>
                <section class="container searchContent">
                    <?php
                    if (isset($_GET['modele_cars']))
                    {
                        $term = htmlspecialchars(trim($_GET['modele_cars']));

                        $query = $pdo -> prepare("SELECT * FROM autocompletion WHERE titre LIKE :title");
                        $query -> execute([
                            "title" => '%' . $term . '%'
                        ]);
                        $result = $query -> fetchAll();

                        foreach ($result as $key => $value)
                        {
                            echo ('
                            <div class="card bg-dark text-white">
                              <img src="' . $value['photo'] . '" alt="' . $value['titre'] . '" class="img-thumbnail">
                              <div class="card-img-overlay">
                                <h5>' . $value['titre'] . '</h5>
                                <a href="element.php?cars=' . $value['id'] . '" class="btn btn-danger">+</a>
                              </div>
                            </div>
                            ');
                        }
                    }
                    ?>
                </section>
            </section>
        </article>
    </main>

    <footer class="d-flex justify-content-center align-items-center">
        <p>Created by William Kies</p>
    </footer>
    </body>

    <!-- Link JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/script.js"></script>
</html>