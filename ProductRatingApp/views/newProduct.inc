<?php $render('partial/header', $data); ?>

    <h1 class="mb-3">New product</h1>

    <?php $beginForm('Products', 'Create', method: 'post'); ?>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input class="form-control" id="name" name="nm" autocomplete="off">
        </div>
        <div class="mb-3">
            <label for="producer" class="form-label">Brand</label>
            <input class="form-control" id="producer" name="pd" autocomplete="off">
        </div>
        <button class="btn btn-secondary">Create</button>
    <?php $endForm(); ?>

<?php $render('partial/footer', $data); ?>