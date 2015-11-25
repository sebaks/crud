<?php

namespace Sebaks\CrudTest\Controller\Admin;

use Sebaks\Crud\Controller\ListController;
use Sebaks\Crud\View\Model\ListViewModel;

class ListControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnDispatch()
    {
        $query = ['foo' => 'bar'];
        $filter = $query;
        $collection = new \ArrayObject();

        $filterMock = $this->getMock('T4webFilter\FilterInterface');

        $filterMock->method('prepare')
            ->with($query)
            ->willReturn($filter);

        $finderMock = $this->getMock('T4webDomainInterface\Infrastructure\RepositoryInterface');
        $criteriaMock = $this->getMock('T4webDomainInterface\Infrastructure\CriteriaInterface');

        $finderMock->method('createCriteria')
            ->with($filter)
            ->willReturn($criteriaMock);

        $finderMock->method('findMany')
            ->with($criteriaMock)
            ->willReturn($collection);

        $listViewModel = new ListViewModel();

        $eventMock = $this->getMock('Zend\Mvc\MvcEvent');
        $eventMock->method('setResult')
            ->with($listViewModel);

        $controller = new ListController(
            $query,
            $filterMock,
            $finderMock,
            $listViewModel
        );
        $actualViewModel = $controller->onDispatch($eventMock);

        $this->assertSame($listViewModel, $actualViewModel);
        $this->assertSame($collection, $actualViewModel->getCollection());
        $this->assertSame($filter, $actualViewModel->getFilter());
    }

}