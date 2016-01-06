<?php

namespace Concrete\Core\Entity\Attribute\Key\Type;

use Concrete\Core\Entity\Attribute\Value\Value\DateTimeValue;


/**
 * @Entity
 * @Table(name="DateTimeAttributeKeyTypes")
 */
class DateTimeType extends Type
{

    public function getAttributeValue()
    {
        return new DateTimeValue();
    }

    /**
     * @Column(type="string")
     */
    protected $mode = '';

    /**
     * @return mixed
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param mixed $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function createController()
    {
        $controller = new \Concrete\Attribute\DateTime\Controller($this->getAttributeType());
        return $controller;
    }

}