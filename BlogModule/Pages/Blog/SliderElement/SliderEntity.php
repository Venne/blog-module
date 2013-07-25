<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule\Pages\Blog\SliderElement;

use BlogModule\Pages\Blog\BlogElement\BlogEntity;
use Doctrine\ORM\Mapping as ORM;
use CmsModule\Content\Entities\ElementEntity;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @ORM\Entity(repositoryClass="\DoctrineModule\Repositories\BaseRepository")
 * @ORM\Table(name="blogSliderElement")
 */
class SliderEntity extends BlogEntity
{

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	protected $width;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
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
