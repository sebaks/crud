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
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param array $filter
     */
    public function setFilter(array $filter)
    {
        $this->filter = $filter;
    }
}
