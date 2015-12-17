<?php

namespace Sebaks\CrudTest\Controller\Admin;

use Sebaks\Crud\Controller\ReadController;
use Sebaks\Crud\View\Model\ReadViewModel;

class ReadControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;
    private $criteriaMock;
    private $repositoryMock;
    private $view;
    private $eventMock;

    public function setUp()
    {
        $this->criteriaMock = $this->getMock('T4webDomainInterface\Infrastructure\CriteriaInterface');
        $this->repositoryMock = $this->getMock('T4webDomainInterface\Infrastructure\RepositoryInterface');

        $this->eventMock = $this->getMock('Zend\Mvc\MvcEvent');

        $this->view = new ReadViewModel();

        $this->controller = new ReadController(
            $this->criteriaMock,
            $this->repositoryMock,
            $this->view
        );
    }

    public function testOnDispatchSuccess()
    {
        $entityMock = $this->getMock('T4webDomainInterface\EntityInterface');

        $this->repositoryMock->method('find')
            ->with($this->criteriaMock)
            ->willReturn($entityMock);

        $this->eventMock->method('setResult')
            ->with($this->view);

        $actualViewModel = $this->controller->onDispatch($this->eventMock);

        $this->assertSame($this->view, $actualViewModel);
        $this->assertSame($entityMock, $actualViewModel->getEntity());
    }

    public function testOnDispatchFail()
    {
        $this->repositoryMock->method('find')
            ->with($this->criteriaMock)
            ->willReturn(null);

        $this->eventMock->expects($this->never())
            ->method('setResult');

        $this->eventMock->method('getRouteMatch')
            ->willReturn($this->getMockBuilder('Zend\Mvc\Router\RouteMatch')
                ->setMethods(['setParam'])
                ->disableOriginalConstructor()
                ->getMock());

        $this->controller->setEvent($this->eventMock);
        $actualViewModel = $this->controller->onDispatch($this->eventMock);

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $actualViewModel);
    }

}