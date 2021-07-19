<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShortUrl $shortUrl
 */
?>
<div class="container py-4">
    <div class="p-5 mb-4 bg-info rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold"><?= __('op.loc short urls')?></h1>
            <p class="col-md-8 fs-4"><?=  __('A CakePHP shortener url for everyone to use')?></p>
            <?= $this->Form->create($shortUrl) ?>
            <fieldset>
                <?php
                echo $this->Form->control('url', [
                    'class' => 'form-control',
                    'label' => false,
                    'placeholder' => 'Type Your URL',
                ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-lg']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
