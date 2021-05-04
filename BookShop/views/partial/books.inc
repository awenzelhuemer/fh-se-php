<?php if($data['books'] !== null) { ?>
    <?php if(sizeof($data['books']) > 0) { ?>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover shadow">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['books'] as $book) { ?>
                        <tr<?php if($book->isInCart()) { ?> class="table-primary"<?php } ?>>
                            <td><?php $htmlOut($book->getTitle()); ?></td>
                            <td><?php $htmlOut($book->getAuthor()); ?></td>
                            <td><?php $htmlOut($book->getPrice()); ?></td>
                            <td><?php $htmlOut($book->getCartCount()); ?></td>
                            <td>
                                <div class="d-flex">
                                    <?php $beginForm("Cart", "Add", ["bid" => $book->getId(), "ctx" => $data["context"]], "post", "form-inline"); ?>
                                        <button class="btn btn-link btn-sm">Add to cart</button>
                                    <?php $endForm(); ?>
                                    <?php $beginForm("Cart", "Remove", ["bid" => $book->getId(), "ctx" => $data["context"]], "post", "form-inline"); ?>
                                        <?php if($book->isInCart()) {?>
                                            <button class="btn btn-link btn-sm">Remove from cart</button>
                                        <?php }?>
                                    <?php $endForm(); ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="alert alert-info" role="alert">
            No books in this category.
        </div>
    <?php } ?>
<?php } ?>