<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShortUrl $shortUrl
 */
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= __('Short Url Was Created')?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= __('You can use it now')?></h6>
                <div class="alert alert-success" role="alert">
                    <?= $this->Url->build(['action' => 'go', $shortUrl->id], ['fullBase' => true])?>
                </div>
                <?= $this->Html->link(
                    __('Create Other'),
                    ['action' => 'add'],
                    ['class' => 'btn btn-secondary']
                )?>
            </div>
        </div>
    </div>
</div>

