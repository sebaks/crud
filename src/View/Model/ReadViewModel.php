<?php

namespace Sebaks\Crud\View\Model;

use Zend\View\Model\ViewModel;
use T4webDomainInterface\EntityInterface;

class ReadViewModel extends ViewModel implements ReadViewModelInterface
{
    /**
     * @var EntityInterface
     */
    private $entity;

    /**
     * @return EntityInterface
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param EntityInterface $entity
     */
    public function setEntity(EntityInterface $entity)
    {
        $this->entity = $entity;
    }
}
