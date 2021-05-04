<?php $render("partial/header", $data); ?>
<h1>List of books</h1>

<nav class="nav nav-pills nav-fill  my-3">
<?php foreach($data['categories'] as $cat) {
    $cssClass = 'nav-link' . ($data['selectedCategoryId'] == $cat->getId() ? ' active' : '');
    $link($cat->getName(), 'Books', 'Index', ['cid' => $cat->getId()], $cssClass);
} ?>
</nav>

<?php $render("partial/books", $data); ?>

<?php $render("partial/footer", $data); ?>