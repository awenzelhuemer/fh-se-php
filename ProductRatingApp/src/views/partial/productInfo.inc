<ul class="list-group">
    <?php $product = $data['product'] ?>
    <li class="list-group-item"><strong>Product name:</strong> <?php $htmlOut($product->getName()) ?></li>
    <li class="list-group-item"><strong>Created from:</strong> <?php $htmlOut($product->getUsername())  ?></li>
    <li class="list-group-item"><strong>Brand:</strong> <?php $htmlOut($product->getProducer()) ?></li>
    <li class="list-group-item"
        data-bs-placement="top" title="<?php $htmlOut($product->getRating())?> out of 5">
        <strong>Average Rating:</strong>
        <?php for ($i = 0; $i < 5; $i++) {
            if($i < $product->getRating()) {?>
                <i class="bi bi-star-fill text-warning"></i>
            <?php } else {?>
                <i class="bi-star"></i>
            <?php } ?>
        <?php }?>
        / <small class="text-secondary"><?php $htmlOut($product->getRatingCount())?> ratings</small>
    </li>
</ul>