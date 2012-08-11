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
 * @Entity(repositoryClass="\DoctrineModule\ORM\BaseRepository")
 * @Table(name="blogList")
 * @DiscriminatorEntry(name="blogList")
 */
class ListEntity extends \CmsModule\Content\Entities\PageEntity {

	/**
	 * @ManyToMany(targetEntity="CategoryEntity", cascade={"all"})
	 * @JoinTable(name="blogListCategoryLink",
	 *	  joinColumns={@JoinColumn(name="list_id", referencedColumnName="id", onDelete="CASCADE")},
	 *	  inverseJoinColumns={@JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")}
	 *	  )
	 */
	protected $categories;

	/** @Column (type="integer") */
	protected $itemsPerPage;



	public function __construct()
	{
		parent::__construct();
		$this->mainRoute->type = 'Blog:List:default';
		$this->itemsPerPage = 10;
		$this->categories = new \Doctrine\Common\Collections\ArrayCollection;
	}



	public function getCategories()
	{
		return $this->categories;
	}



	public function setCategories($categories)
	{
		$this->categories = $categories;
	}



	public function getItemsPerPage()
	{
		return $this->itemsPerPage;
	}



	public function setItemsPerPage($itemsPerPage)
	{
		$this->itemsPerPage = $itemsPerPage;
	}

}
