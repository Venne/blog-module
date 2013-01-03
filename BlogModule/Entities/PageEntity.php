<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace BlogModule\Entities;

use Venne;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @ORM\Entity(repositoryClass="\DoctrineModule\Repositories\BaseRepository")
 * @ORM\Table(name="blogPage")
 * @ORM\DiscriminatorEntry(name="blogPage")
 */
class PageEntity extends \CmsModule\Content\Entities\PageEntity
{

	/**
	 * @var ArrayCollection|BlogEntity[]
	 * @ORM\OneToMany(targetEntity="BlogEntity", mappedBy="page")
	 */
	protected $blogs;

	/**
	 * @var string
	 * @ORM\Column(type="integer")
	 */
	protected $itemsPerPage;

	/**
	 * @var bool
	 * @ORM\Column(type="boolean")
	 */
	protected $autoNotation;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	protected $notationLength;

	/**
	 * @var bool
	 * @ORM\Column(type="boolean")
	 */
	protected $notationInHtml;


	public function __construct()
	{
		parent::__construct();
		$this->mainRoute->type = 'Blog:Default:default';
		$this->itemsPerPage = 10;

		$this->autoNotation = true;
		$this->notationLength = 200;
		$this->notationInHtml = false;
	}


	public function setBlogs($blogs)
	{
		$this->blogs = $blogs;
	}


	public function getBlogs()
	{
		return $this->blogs;
	}


	/**
	 * @param string $itemsPerPage
	 */
	public function setItemsPerPage($itemsPerPage)
	{
		$this->itemsPerPage = $itemsPerPage;
	}


	/**
	 * @return string
	 */
	public function getItemsPerPage()
	{
		return $this->itemsPerPage;
	}


	/**
	 * @param boolean $autoNotation
	 */
	public function setAutoNotation($autoNotation)
	{
		$this->autoNotation = $autoNotation;
	}


	/**
	 * @return boolean
	 */
	public function getAutoNotation()
	{
		return $this->autoNotation;
	}


	/**
	 * @param int $notationLength
	 */
	public function setNotationLength($notationLength)
	{
		$this->notationLength = $notationLength;
	}


	/**
	 * @return int
	 */
	public function getNotationLength()
	{
		return $this->notationLength;
	}


	/**
	 * @param boolean $notationInHtml
	 */
	public function setNotationInHtml($notationInHtml)
	{
		$this->notationInHtml = $notationInHtml;
	}


	/**
	 * @return boolean
	 */
	public function getNotationInHtml()
	{
		return $this->notationInHtml;
	}
}
