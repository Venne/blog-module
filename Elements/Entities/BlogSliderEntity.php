<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule\Elements\Entities;

use Venne;
use CmsModule\Content\Entities\ElementEntity;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @Entity(repositoryClass="\DoctrineModule\Repositories\BaseRepository")
 * @Table(name="blogSliderElement")
 * @DiscriminatorEntry(name="blogSliderElement")
 */
class BlogSliderEntity extends BaseBlogEntity
{

	/**
	 * @var int
	 * @Column(type="integer")
	 */
	protected $width;

	/**
	 * @var int
	 * @Column(type="integer")
	 */
	protected $height;


	public function __construct()
	{
		parent::__construct();

		$this->width = 800;
		$this->height = 400;
	}


	/**
	 * @param int $height
	 */
	public function setHeight($height)
	{
		$this->height = $height;
	}


	/**
	 * @return int
	 */
	public function getHeight()
	{
		return $this->height;
	}


	/**
	 * @param int $width
	 */
	public function setWidth($width)
	{
		$this->width = $width;
	}


	/**
	 * @return int
	 */
	public function getWidth()
	{
		return $this->width;
	}
}
