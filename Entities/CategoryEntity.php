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
 * @Table(name="blogCategory")
 */
class CategoryEntity extends \DoctrineModule\ORM\BaseEntity {

	
	/**
	 * @var string
	 * @Column(type="text")
	 */
	protected $name = '';

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @param $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	
	public function __toString() {
	    return $this->getName();
	}


}
