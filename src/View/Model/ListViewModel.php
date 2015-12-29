<?php

namespace Sebaks\Crud\View\Model;

use Zend\View\Model\ViewModel;
use ArrayObject;

class ListViewModel extends ViewModel implements ListViewModelInterface
{
    /**
     * @var ArrayObject
     */
    private $collection;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var array
     */
    private $filter;

    /**
     * @return ArrayObject
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param ArrayObject $collection
     */
    public function setCollection(ArrayObject $collection)
    {
        $this->collection = $collection;
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
        return $this->filter;
    }

    /**
     * @param array $filter
     */
    public function setInputData(array $filter)
    {
        $this->filter = $filter;
    }
}
