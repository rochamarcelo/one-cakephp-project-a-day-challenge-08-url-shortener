<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/4/en/views.html#the-app-view
 */
class AppView extends View
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadHelper('Paginator', [
            'templates' => [
                'nextActive' => '<li class="next"><a rel="next" class="btn btn-outline-dark m-1" href="{{url}}">{{text}}</a></li>',
                'nextDisabled' => '<li class="next disabled"><a class="btn btn-outline-secondary m-1" disabled href="" onclick="return false;">{{text}}</a></li>',
                'prevActive' => '<li class="prev"><a rel="prev" class="btn btn-outline-dark m-1" href="{{url}}">{{text}}</a></li>',
                'prevDisabled' => '<li class="prev disabled"><a class="btn btn-outline-secondary m-1" disabled href="" onclick="return false;">{{text}}</a></li>',
            ]
        ]);
        $this->loadHelper('Form', [
            'templates' => [
                'inputContainer' => '<div class="input {{type}}{{required}} mb-3">{{content}}</div>',
                // Container element used by control() when a field has an error.
                'inputContainerError' => '<div class="input {{type}}{{required}} error mb-3">{{content}}{{error}}</div>',

            ],
        ]);
    }
}
