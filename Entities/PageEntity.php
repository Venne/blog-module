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

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @Entity(repositoryClass="\DoctrineModule\Repositories\BaseRepository")
 * @Table(name="blogPage")
 * @DiscriminatorEntry(name="blogPage")
 */
class PageEntity extends \CmsModule\Content\Entities\PageEntity
{

	/**
	 * @var ArrayCollection|BlogEntity[]
	 * @OneToMany(targetEntity="BlogEntity", mappedBy="page")
	 */
	protected $blogs;

	/**
	 * @var string
	 * @Column (type="integer")
	 */
	protected $itemsPerPage;


	public function __construct()
	{
		parent::__construct();
		$this->mainRoute->type = 'Blog:Default:default';
		$this->itemsPerPage = 10;
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
}
