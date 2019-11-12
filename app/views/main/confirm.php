<?= $this->layout('layout', ['title' => 'Confirm Email']); ?>
<div class="container">
    <h1 class="mt-4 mb-3"><?= $this->e($title) ?></h1>
    <div class="row">
        <?php echo flash()->display(); ?>
        <div class="col-lg-8 mb-4">
            <?php if ($bool) : ?>
                <a href="/login" class="btn btn-primary">Перейти ко входу</a>
            <?php endif; ?>
        </div>
    </div>
</div>