<?php

namespace Sebaks\Crud\View\Model;

use ArrayObject;
use Zend\View\Model\ModelInterface;

interface ListViewModelInterface extends ModelInterface
{
    /**
     * @return ArrayObject
     */
    public function getCollection();

    /**
     * @param ArrayObject $collection
     */
    public function setCollection(ArrayObject $collection);

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @param array $errors
     */
    public function setErrors(array $errors);

    /**
     * @return array
     */
    public function getInputData();

    /**
     * @param array $filter
     */
    public function setInputData(array $filter);
}
