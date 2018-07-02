<?php
/**
 * Created by PhpStorm.
 * User: mkardakov
 * Date: 7/2/18
 * Time: 12:43 PM
 */

namespace AppBundle\Entity\Traits;


use AppBundle\DTO\DataTransfertInterface;

trait Merge
{

    /**
     * @param DataTransfertInterface $dto
     */
    public function merge(DataTransfertInterface $dto)
    {
        foreach ($dto as $name => $value) {
            if (property_exists($this, $name)) {
                $this->$name = $value;
            }
        }
    }
}