<?php

namespace Sebaks\Crud\View\Model;

use Zend\View\Model\ViewModel;
use T4webDomainInterface\EntityInterface;

class UpdateViewModel extends ViewModel implements UpdateViewModelInterface
{
    /**
     * @var EntityInterface
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
    public function setErrors(array $errors)
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
    public function setInputData(array $inputData)
    {
        $this->inputData = $inputData;
    }
}
