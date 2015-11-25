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
    public function getFilter();

    /**
     * @param array $filter
     */
    public function setFilter(array $filter);
}
