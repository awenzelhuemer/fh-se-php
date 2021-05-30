<?php $render("partial/header", $data); ?>

    <?php if($data['product'] !== null) { ?>
        <h1>Product</h1>

        <?php $render("partial/product-info", $data); ?>
        <?php $render("partial/product-ratings", $data); ?>

    <?php } ?>

<?php $render("partial/footer", $data); ?>