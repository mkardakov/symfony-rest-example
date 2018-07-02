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
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @var string
     */
    public $title;

    /**
     * @Type("string")
     * @var string
     */
    public $description;
    
}