<?php

namespace Sebaks\CrudTest\Controller\Admin;

use Sebaks\Crud\Controller\ListController;
use Sebaks\Crud\View\Model\ListViewModel;
use T4webBase\Domain\Collection;

class ListControllerTest extends \PHPUnit_Framework_TestCase {

    public function testListAction()
    {
        $query = ['foo' => 'bar'];
        $filteredQuery = $query;
        $collection = new Collection();

        $inputFilterMock = $this->getMockBuilder('T4webBase\InputFilter\Filter')
            ->disableOriginalConstructor()
            ->getMock();

        $inputFilterMock->method('filter')
            ->with($query)
            ->will($this->returnValue($filteredQuery));

        $finderMock = $this->getMockBuilder('T4webBase\Domain\Service\BaseFinder')
            ->disableOriginalConstructor()
            ->getMock();

        $finderMock->method('findMany')
            ->with($filteredQuery)
            ->will($this->returnValue($collection));

        $listViewModel = new ListViewModel();

        $controller = new ListController(
            $query,
            $inputFilterMock,
            $finderMock,
            $listViewModel
        );
        $actualViewModel = $controller->indexAction();

        $this->assertSame($listViewModel, $actualViewModel);
        $this->assertSame($collection, $actualViewModel->getCollection());
    }

}