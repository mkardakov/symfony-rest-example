<?php
/**
 * Created by PhpStorm.
 * User: mkardakov
 * Date: 7/2/18
 * Time: 4:32 PM
 */

namespace AppBundle\DTO;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Class Goal
 * @package AppBundle\DTO
 */
class Goal implements DataTransfertInterface
{

    /**
     * @Type("string")
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "Comment author name must be at least {{ limit }} characters long",
     *      maxMessage = "Comment author name cannot be longer than {{ limit }} characters"
     * )
     * @var string
     */
    public $title;

    /**
     * @Assert\NotBlank()
     * @Type("string")
     * @var string
     */
    public $description;
    
}