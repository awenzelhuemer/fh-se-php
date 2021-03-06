<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <title>Product Rating App</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <?php $link("Product Rating App", "Home", "Index", cssClass: "navbar-brand"); ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <nav class="navbar-nav me-auto">
                    <?php $link("Home", "Home", "Index", cssClass: "nav-link"); ?>
                    <?php $link("Products", "Products", "Index", cssClass: "nav-link"); ?>
                </nav>
                <?php $render("partial/user", $data["user"])  ?>
            </div>
        </div>
    </nav>
    <div class="container my-5">
    <?php if(isset($data["errors"])) {
        $render("partial/errors", $data["errors"]);
    } ?>