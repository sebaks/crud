<?php

namespace Sebaks\Crud\View\Model;

use Zend\View\Model\ViewModel;
use T4webBase\Domain\Entity;

class DeleteViewModel extends ViewModel
{
    /**
     * @var Entity
     */
    private $entity;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var bool
     */
    private $result;

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

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return boolean
     */
    public function isResult()
    {
        return $this->result;
    }

    /**
     * @param boolean $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }
}
