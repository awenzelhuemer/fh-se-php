<?php $render('partial/header', $data); ?>

<h1>Register</h1>

<?php $beginForm('User', 'Register', method: 'post'); ?>
    <div class="mb-3">
        <label for="userName" class="form-label">Username</label>
        <input class="form-control" id="userName" name="un" value="<?php $htmlOut($data['userName']); ?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input class="form-control" id="password" name="pwd" type="password" value="<?php $htmlOut($data['password']); ?>">
    </div>
    <button class="btn btn-primary">Register</button>
<?php $endForm(); ?>

<?php $render('partial/footer', $data); ?>