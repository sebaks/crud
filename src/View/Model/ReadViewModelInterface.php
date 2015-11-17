<?php

namespace Sebaks\Crud\View\Model;

use Zend\View\Model\ModelInterface;
use T4webDomainInterface\EntityInterface;

interface ReadViewModelInterface extends ModelInterface
{
    /**
     * @return EntityInterface
     */
    public function getEntity();

    /**
     * @param EntityInterface $entity
     */
    public function setEntity(EntityInterface $entity);
}
