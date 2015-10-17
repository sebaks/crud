<?php

namespace Sebaks\Crud\View\Model;

use Zend\View\Model\ViewModel;
use T4webBase\Domain\Entity;

class ReadViewModel extends ViewModel
{
    /**
     * @var Entity
     */
    private $entity;

    /**
     * @return Entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param Entity $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }
}
