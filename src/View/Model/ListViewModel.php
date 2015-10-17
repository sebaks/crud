<?php

namespace Sebaks\Crud\View\Model;

use Zend\View\Model\ViewModel;
use T4webBase\Domain\Collection;

class ListViewModel extends ViewModel
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @return Collection
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param Collection $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }
}
