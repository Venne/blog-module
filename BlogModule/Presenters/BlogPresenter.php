<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule\Presenters;

use Venne;
use DoctrineModule\Repositories\BaseRepository;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class BlogPresenter extends \CmsModule\Content\Presenters\PagePresenter
{

	/**
	 * @var \DoctrineModule\Repositories\BaseRepository
	 */
	private $blogRepository;


	public function __construct(BaseRepository $blogRepository)
	{
		parent::__construct();
		$this->blogRepository = $blogRepository;
	}


	public function renderDefault()
	{
		$this->template->blog = $this->blogRepository->findOneBy(array('route' => $this->route->id));
	}
}