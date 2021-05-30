<?php $render('partial/header', $data); ?>

    <h1 class="mb-3">Edit product</h1>

    <?php $product = $data['product'] ?>

    <?php if ($product !== null) {?>
        <?php $beginForm('Products', 'Edit', ["pid" => $product->getId()], method: 'post'); ?>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input class="form-control" id="name" name="nm" value="<?php $htmlOut($product->getName()) ?>" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="producer" class="form-label">Brand</label>
                <input class="form-control" id="producer" name="pd" value="<?php $htmlOut($product->getProducer()) ?>" autocomplete="off">
            </div>
            <button class="btn btn-secondary">Update</button>
        <?php $endForm(); ?>
    <?php } ?>

<?php $render('partial/footer', $data); ?>