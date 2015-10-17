<?php

namespace Sebaks\Crud\View\Model;

use Zend\View\Model\ViewModel;
use T4webBase\Domain\Entity;

class CreateViewModel extends ViewModel
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
     * @var array
     */
    private $inputData;

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
     * @return array
     */
    public function getInputData()
    {
        return $this->inputData;
    }

    /**
     * @param array $inputData
     */
    public function setInputData($inputData)
    {
        $this->inputData = $inputData;
    }
}
