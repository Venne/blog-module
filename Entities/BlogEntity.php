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
use Nette\Utils\Strings;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @Entity(repositoryClass="\DoctrineModule\Repositories\BaseRepository")
 * @Table(name="blog")
 * @HasLifecycleCallbacks
 */
class BlogEntity extends \DoctrineModule\Entities\NamedEntity
{
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


	/**
	 * @var PageEntity
	 * @ManyToOne(targetEntity="\BlogModule\Entities\PageEntity", inversedBy="blogs")
	 * @JoinColumn(onDelete="CASCADE")
	 */
	protected $page;

	/**
	 * @var \CmsModule\Content\Entities\RouteEntity
	 * @OneToOne(targetEntity="\CmsModule\Content\Entities\RouteEntity", cascade={"persist"}, orphanRemoval=true)
	 * @JoinColumn(onDelete="CASCADE")
	 */
	protected $route;

	/**
	 * @var \CmsModule\Security\Entities\UserEntity
	 * @ManyToOne(targetEntity="\CmsModule\Security\Entities\UserEntity")
	 * @JoinColumn(onDelete="CASCADE")
	 */
	protected $author;

	/**
	 * @var \DateTime
	 * @Column(type="datetime")
	 */
	protected $created;

	/**
	 * @var \DateTime
	 * @Column(type="datetime", nullable=true)
	 */
	protected $updated;

	/**
	 * @var \DateTime
	 * @Column(type="datetime", nullable=true)
	 */
	protected $expired;


	/**
	 * @param PageEntity $pageEntity
	 */
	public function __construct(PageEntity $pageEntity)
	{
		parent::__construct();

		$this->page = $pageEntity;
		$this->notation = '';
		$this->text = '';
		$this->name = '';
		$this->created = new \Nette\DateTime();

		$this->route = new \CmsModule\Content\Entities\RouteEntity;
		$this->route->setType('Blog:Blog:default');
		$this->page->routes[] = $this->route;
		$this->route->setPage($this->page);
		$this->route->setParent($this->page->mainRoute);
	}


	/**
	 * @PreUpdate()
	 */
	public function preUpdate()
	{
		$this->updated = new \Nette\DateTime();
	}


	public function setName($name)
	{
		parent::setName($name);

		$this->route->setLocalUrl(Strings::webalize($this->name));
		$this->route->setTitle($name);
	}


	public function getNotation()
	{
		/** @var $page PageEntity */
		$page = $this->page;
		if ($page->getAutoNotation()) {
			$text = html_entity_decode($this->text, ENT_QUOTES, 'UTF-8');
			$ret = Strings::truncate(strip_tags($text), $page->getNotationLength());
		} else {
			$ret = $this->notation;
		}

		if (!$page->getNotationInHtml()) {
			$ret = htmlspecialchars($ret);
		}

		return $ret;
	}


	public function getRawNotation()
	{
		return $this->notation;
	}


	public function setRawNotation($notation)
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


	/**
	 * @param \BlogModule\Entities\PageEntity $page
	 */
	public function setPage($page)
	{
		$this->page = $page;
	}


	/**
	 * @return \BlogModule\Entities\PageEntity
	 */
	public function getPage()
	{
		return $this->page;
	}


	/**
	 * @return \CmsModule\Content\Entities\RouteEntity
	 */
	public function getRoute()
	{
		return $this->route;
	}


	/**
	 * @return \DateTime
	 */
	public function getUpdated()
	{
		return $this->updated;
	}


	/**
	 * @return \DateTime
	 */
	public function getCreated()
	{
		return $this->created;
	}


	/**
	 * @param \DateTime $expired
	 */
	public function setExpired($expired)
	{
		$this->expired = $expired;
	}


	/**
	 * @return \DateTime
	 */
	public function getExpired()
	{
		return $this->expired;
	}


	/**
	 * @param \CmsModule\Security\Entities\UserEntity $author
	 */
	public function setAuthor($author)
	{
		$this->author = $author;
	}


	/**
	 * @return \CmsModule\Security\Entities\UserEntity
	 */
	public function getAuthor()
	{
		return $this->author;
	}
}
