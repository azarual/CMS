<?php

/**
 * This file is part of Bootstrap CMS by Graham Campbell.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 */

namespace GrahamCampbell\BootstrapCMS\Models;

use GrahamCampbell\Database\Models\AbstractModel;
use McCool\LaravelAutoPresenter\PresenterInterface;
use GrahamCampbell\Credentials\Models\Relations\Interfaces\BelongsToUserInterface;
use GrahamCampbell\Credentials\Models\Relations\Common\BelongsToUserTrait;
use GrahamCampbell\Credentials\Models\Relations\Interfaces\RevisionableInterface;
use GrahamCampbell\Credentials\Models\Relations\Common\RevisionableTrait;

/**
 * This is the page model class.
 *
 * @package    Bootstrap-CMS
 * @author     Graham Campbell
 * @copyright  Copyright (C) 2013-2014  Graham Campbell
 * @license    https://github.com/GrahamCampbell/Bootstrap-CMS/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Bootstrap-CMS
 */
class Page extends AbstractModel implements BelongsToUserInterface, RevisionableInterface, PresenterInterface
{
    use BelongsToUserTrait, RevisionableTrait;

    /**
     * The table the pages are stored in.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The model name.
     *
     * @var string
     */
    public static $name = 'page';

    /**
     * The revisionable columns.
     *
     * @var array
     */
    protected $keepRevisionOf = array('title', 'nav_title', 'slug', 'body', 'css', 'js', 'show_title', 'show_nav', 'icon');

    /**
     * The columns to select when displaying an index.
     *
     * @var array
     */
    public static $index = array('id', 'slug', 'title', 'nav_title');

    /**
     * The max pages per page when displaying a paginated index.
     *
     * @var int
     */
    public static $paginate = 10;

    /**
     * The columns to order by when displaying an index.
     *
     * @var string
     */
    public static $order = 'slug';

    /**
     * The direction to order by when displaying an index.
     *
     * @var string
     */
    public static $sort = 'asc';

    /**
     * The page validation rules.
     *
     * @var array
     */
    public static $rules = array(
        'title'      => 'required',
        'nav_title'  => 'required',
        'slug'       => 'required|alpha_dash',
        'body'       => 'required',
        'show_title' => 'required',
        'show_nav'   => 'required',
        'user_id'    => 'required'
    );

    /**
     * Get the presenter class.
     *
     * @var string
     */
    public function getPresenter()
    {
        return 'GrahamCampbell\BootstrapCMS\Presenters\PagePresenter';
    }

    /**
     * Before deleting an existing model.
     *
     * @return mixed
     */
    public function beforeDelete()
    {
        if ($this->slug == 'home') {
            throw new \Exception('You cannot delete the homepage.');
        }
    }
}
