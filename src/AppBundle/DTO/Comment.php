<?php
/**
 * Created by PhpStorm.
 * User: mkardakov
 * Date: 7/3/18
 * Time: 10:48 AM
 */

namespace AppBundle\DTO;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment
 * @package AppBundle\DTO
 */
class Comment implements DataTransfertInterface
{

    /**
     * @Type("string")
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @var string
     */
    public $name;

    /**
     * @Type("string")
     * @var string
     */
    public $description;
}