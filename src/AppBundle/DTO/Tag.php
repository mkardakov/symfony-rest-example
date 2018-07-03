<?php
/**
 * Created by PhpStorm.
 * User: mkardakov
 * Date: 7/3/18
 * Time: 2:34 PM
 */

namespace AppBundle\DTO;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tag
 * @package AppBundle\DTO
 */
class Tag implements DataTransfertInterface
{
    /**
     * @Type("string")
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Tag name must be at least {{ limit }} characters long",
     *      maxMessage = "Tag name cannot be longer than {{ limit }} characters"
     * )
     * @var string
     */
    public $title;

    /**
     * @Assert\Regex("/^[0-9a-fA-F]{6}$/")
     * @Type("string")
     * @var int
     */
    public $color;
}