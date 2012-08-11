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
 * @Table(name="blogArticle")
 * @DiscriminatorEntry(name="blogArticle")
 */
class ArticleEntity extends \CmsModule\Content\Entities\PageEntity
{	
	/**
	 * @ManyToMany(targetEntity="CategoryEntity", cascade={"all"})
	 * @JoinTable(name="blogArticleCategoryLink",
	 *	  joinColumns={@JoinColumn(name="article_id", referencedColumnName="id", onDelete="CASCADE")},
	 *	  inverseJoinColumns={@JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")}
	 *	  )
	 */
	protected $categories;

	/**
	 * @var string
	 * @Column (type="text")
	 */
	protected $notation;
		
	/**
	 * @var string
	 * @Column (type="text")
	 */
	protected $text;
	

	public function __construct()
	{
		parent::__construct();
		$this->mainRoute->type = 'Blog:Default:default';
		$this->notation = '';
		$this->text     = '';
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

	public function getNotation()
	{
		return $this->notation;
	}



	public function setNotation($notation)
	{
		$this->notation = $notation;
	}
	
	
	public function getText()
	{
		return $this->text;
	}


	public function setText($text)
	{
		$this->text = $text;
	}


}
