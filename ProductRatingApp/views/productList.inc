<?php $render("partial/header", $data); ?>
    <h1>List of products</h1>

<?php if($data['products'] !== null) { ?>
    <?php if(sizeof($data['products']) > 0) { ?>
        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Producer</th>
                    <th>Average Rating</th>
                    <th>Total rating count</th>
                    <th>Created user</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($data['products'] as $product) { ?>
                    <tr>
                        <td><?php $htmlOut($product->getName()); ?></td>
                        <td><?php $htmlOut($product->getProducer()); ?></td>
                        <td><?php  $htmlOut($product->getRating()); ?></td>
                        <td><?php $htmlOut($product->getRatingCount()); ?></td>
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