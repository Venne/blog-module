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
use Doctrine\ORM\Mapping as ORM;
use CmsModule\Content\Entities\ElementEntity;

/**
 * @author Josef Kříž <pepakriz@gmail.com>
 * @ORM\Entity(repositoryClass="\DoctrineModule\Repositories\BaseRepository")
 * @ORM\Table(name="blogElement")
 * @ORM\DiscriminatorEntry(name="blogElement")
 */
class BlogEntity extends BaseBlogEntity
{

}
