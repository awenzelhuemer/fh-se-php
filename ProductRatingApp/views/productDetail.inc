<?php $render("partial/header", $data); ?>

    <?php if($data['product'] !== null) { ?>
        <h1>Product</h1>

        <?php $render("partial/productInfo", $data); ?>
        <?php $render("partial/productRatings", $data); ?>

    <?php } ?>

<?php $render("partial/footer", $data); ?>