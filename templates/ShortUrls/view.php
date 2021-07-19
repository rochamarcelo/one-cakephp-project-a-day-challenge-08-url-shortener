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
            <hr />
            <p class="text-white"><?=__('Here is your short URL')?></p>
            <p class="text-white"><strong><?=
                $this->Url->build(
                    ['action' => 'go', 'code' => $shortUrl->id],
                    ['fullBase' => true]
                )?></strong>
            </p>
            <?= $this->Html->link(
                __('Create Other URL'),
                ['action' => 'add'],
                ['class' => 'btn btn-primary btn-lg']
            )?>
        </div>
    </div>
</div>
