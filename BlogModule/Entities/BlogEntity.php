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
use Nette\Utils\Strings;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @ORM\Entity(repositoryClass="\DoctrineModule\Repositories\BaseRepository")
 * @ORM\Table(name="blog")
 * @ORM\HasLifecycleCallbacks
 */
class BlogEntity extends \DoctrineModule\Entities\NamedEntity
{
	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $notation;

	/**
	 * @var string
	 * @ORM\Column(type="text")
	 */
	protected $text;

	/**
	 * @var \CmsModule\Content\Entities\FileEntity
	 * @ORM\OneToOne(targetEntity="\CmsModule\Content\Entities\FileEntity", cascade={"all"}, orphanRemoval=true)
	 * @ORM\JoinColumn(onDelete="SET NULL")
	 */
	protected $photo;

	/**
	 * @var PageEntity
	 * @ORM\ManyToOne(targetEntity="\BlogModule\Entities\PageEntity", inversedBy="blogs")
	 * @ORM\JoinColumn(onDelete="CASCADE")
	 */
	protected $page;

	/**
	 * @var \CmsModule\Content\Entities\RouteEntity
	 * @ORM\OneToOne(targetEntity="\CmsModule\Content\Entities\RouteEntity", cascade={"persist"}, orphanRemoval=true)
	 * @ORM\JoinColumn(onDelete="CASCADE")
	 */
	protected $route;

	/**
	 * @var \CmsModule\Security\Entities\UserEntity
	 * @ORM\ManyToOne(targetEntity="\CmsModule\Security\Entities\UserEntity")
	 * @ORM\JoinColumn(onDelete="CASCADE")
	 */
	protected $author;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $created;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $updated;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $expired;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $released;


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
		$this->released = new \Nette\DateTime();

		$this->route = new \CmsModule\Content\Entities\RouteEntity;
		$this->route->setType('Blog:Blog:default');
		$this->page->routes[] = $this->route;
		$this->route->setPage($this->page);
		$this->route->setParent($this->page->mainRoute);
	}


	/**
	 * @ORM\PreUpdate()
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
	 * @param \DateTime $released
	 */
	public function setReleased($released)
	{
		$this->released = $released;
	}


	/**
	 * @return \DateTime
	 */
	public function getReleased()
	{
		return $this->released;
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


	/**
	 * @param \CmsModule\Content\Entities\FileEntity $photo
	 */
	public function setPhoto($photo)
	{
		$this->photo = $photo;

		if ($this->photo) {
			$this->photo->setParent($this->page->getDir());
			$this->photo->setInvisible(TRUE);
		}
	}


	/**
	 * @return \CmsModule\Content\Entities\FileEntity
	 */
	public function getPhoto()
	{
		return $this->photo;
	}
}
