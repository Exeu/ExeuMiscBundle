<?php
namespace Exeu\MiscBundle\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class TestEntity
{
	/**
	 * @ORM\Id 
	 * @ORM\Column(type="string") 
	 * @ORM\GeneratedValue
	 */
	public $id;

	/**
	 * @ORM\Column(type="text")
	 */
	public $name;
}