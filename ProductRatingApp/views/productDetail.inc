<?php $render("partial/header", $data); ?>


<?php if($data['product'] !== null) { ?>
    <?php $product = $data['product'] ?>

    <h1>Product</h1>

    <ul class="list-group">
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
            / <small class="text-primary"><?php $htmlOut($product->getRatingCount())?></small>
        </li>
    </ul>

    <h2 class="mt-4">Ratings</h2>

    <?php if(sizeof($product->getRatings()) > 0) { ?>
        <div class="accordion" id="accordionExample">
            <?php foreach($product->getRatings() as $rating) { ?>
            <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#rating<?php $htmlOut($rating->getId()) ?>" >
                    <div class="d-flex justify-content-between w-100">
                        <span>
                            <?php for ($i = 0; $i < 5; $i++) {
                                if($i < $rating->getRating()) {?>
                                    <i class="bi bi-star-fill text-warning"></i>
                                <?php } else {?>
                                    <i class="bi-star"></i>
                                <?php } ?>
                            <?php }?>
                            <span class="ms-2">by <?php $htmlOut($rating->getUser()->getUserName()) ?></span>
                        </span>
                        <span class="me-2">from <?php $htmlOut($rating->getCreatedDate()) ?></span>
                    </div>
                </button>
            </h2>
            <div id="rating<?php $htmlOut($rating->getId()) ?>" class="accordion-collapse collapse <?php ($rating->getComment() !== null) ? $htmlOut('show') : $htmlOut('')?>">
                <div class="accordion-body">
                    <?php if($rating->getComment() !== null) {
                         $htmlOut($rating->getComment());
                    } else { ?>
                        <div class="alert alert-secondary" role="alert">
                            This rating includes no comment!
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-info" role="alert">
            This product contains zero ratings!
        </div>
    <?php } ?>
   <?php } ?>

<?php $render("partial/footer", $data); ?>