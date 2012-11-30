<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule\Elements;

use Venne;
use DoctrineModule\Repositories\BaseRepository;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 */
class BlogSliderElement extends BlogElement
{
	/**
	 * @return string
	 */
	protected function getEntityName()
	{
		return get_class(new \BlogModule\Elements\Entities\BlogSliderEntity());
	}


	public function render()
	{
		$this->template->width = $this->getEntity()->width;
		$this->template->height = $this->getEntity()->height;

		parent::render();
	}
}
