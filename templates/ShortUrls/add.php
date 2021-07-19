<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShortUrl $shortUrl
 */
?>
<div class="row">
    <div class="col-12">
        <div class="contacts form content">
            <?= $this->Form->create($shortUrl) ?>
            <fieldset>
                <?php
                echo $this->Form->control('url', [
                    'class' => 'form-control',
                    'label' => [
                        'class' => 'form-label',
                    ],
                ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

