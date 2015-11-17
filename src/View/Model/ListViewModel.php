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
}
