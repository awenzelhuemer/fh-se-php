<?php $render("partial/header", $data); ?>
    <h1>Products</h1>

<?php if($data['products'] !== null) { ?>
    <?php if(sizeof($data['products']) > 0) { ?>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Rating</th>
                    <th>Created user</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data['products'] as $product) { ?>
                    <tr>
                        <td>
                            <?php $link($product->getName(), 'Products', 'Detail', ['pid' => $product->getId()], cssClass: 'link'); ?>
                        </td>
                        <td><?php $htmlOut($product->getProducer()); ?></td>
                        <td data-bs-placement="top" title="<?php $htmlOut($product->getRating())?> out of 5">
                            <?php for ($i = 0; $i < 5; $i++) {
                            if($i < $product->getRating()) {?>
                                <i class="bi bi-star-fill text-warning"></i>
                            <?php } else {?>
                                <i class="bi-star"></i>
                            <?php }?>

                        <?php }?>/
                        <small class="text-primary"><?php $htmlOut($product->getRatingCount())?></small></td>
                        <td><?php $htmlOut($product->getUserName()); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-info" role="alert">
            No products in this category.
        </div>
    <?php } ?>
<?php } ?>

<?php $render("partial/footer", $data); ?>