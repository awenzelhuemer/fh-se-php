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

    <div class="accordion" id="accordionExample">
        <?php if($data["user"] !== null) { ?>
        <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#newRating" aria-expanded="true">
                New rating
            </button>
        </h2>
            <div id="newRating" class="accordion-collapse collapse show" data-bs-parent="#newRating">
                <div class="accordion-body">
                    <?php $beginForm('Ratings', 'Create', ["pid" => $product->getId()], method: 'post'); ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rt" id="rating1" value="1">
                        <label class="form-check-label" for="rating1">1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rt" id="rating2" value="2">
                        <label class="form-check-label" for="rating2">2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rt" id="rating3" value="3">
                        <label class="form-check-label" for="rating3">3</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rt" id="rating4" value="4">
                        <label class="form-check-label" for="rating4">4</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rt" id="rating5" value="5" checked>
                        <label class="form-check-label" for="rating5">5</label>
                    </div>
                    <div class="mb-3">
                        <label for="ct" class="form-label">Comment</label>
                        <textarea class="form-control" id="ct" name="ct" rows="3"></textarea>
                    </div>
                    <button class="btn btn-secondary">Add new rating</button>
                    <?php $endForm(); ?>
                </div>
            </div>
        </div>
        <?php } ?>
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

                    <?php if($data["user"] !== null && $data["user"]->getId() === $rating->getUser()->getId()) {?>
                        <?php $beginForm('Ratings', 'Edit', ["pid" => $product->getId(), "rid" => $rating->getId()], method: 'post'); ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rt" id="rating1" value="1" <?php ($rating->getRating()) === 1 ? $htmlOut('checked') : $htmlOut('') ?>>
                                <label class="form-check-label" for="rating1">1</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rt" id="rating2" value="2" <?php ($rating->getRating()) === 2 ? $htmlOut('checked') : $htmlOut('') ?>>
                                <label class="form-check-label" for="rating2">2</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rt" id="rating3" value="3" <?php ($rating->getRating()) === 3 ? $htmlOut('checked') : $htmlOut('') ?>>
                                <label class="form-check-label" for="rating3">3</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rt" id="rating4" value="4" <?php ($rating->getRating()) === 4 ? $htmlOut('checked') : $htmlOut('') ?>>
                                <label class="form-check-label" for="rating4">4</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rt" id="rating5" value="5" <?php ($rating->getRating()) === 5 ? $htmlOut('checked') : $htmlOut('') ?>>
                                <label class="form-check-label" for="rating5">5</label>
                            </div>
                            <div class="mb-3">
                                <label for="ct" class="form-label">Comment</label>
                                <textarea class="form-control" id="ct" name="ct" rows="3"><?php $htmlOut($rating->getComment()) ?></textarea>
                            </div>
                            <button class="btn btn-secondary">Update existing rating</button>
                        <?php $endForm(); ?>
                    <?php } else { ?>

                    <?php if($rating->getComment() !== null) {
                         $htmlOut($rating->getComment());
                    } else { ?>
                        <div class="alert alert-secondary" role="alert">
                            This rating includes no comment!
                        </div>
                    <?php } ?>
                <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
   <?php } ?>

<?php $render("partial/footer", $data); ?>