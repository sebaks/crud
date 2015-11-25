<?php

namespace Sebaks\CrudTest\Controller\Admin;

use Sebaks\Crud\Controller\DeleteController;
use Sebaks\Crud\View\Model\DeleteViewModel;

class DeleteControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;
    private $id;
    private $deleterMock;
    private $view;
    private $eventMock;

    public function setUp()
    {
        $this->id = 22;

        $this->deleterMock = $this->getMockBuilder('T4webDomainInterface\Service\DeleterInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventMock = $this->getMock('Zend\Mvc\MvcEvent');

        $this->view = new DeleteViewModel();

        $this->controller = new DeleteController(
            $this->id,
            $this->deleterMock,
            $this->view
        );
    }

    public function testOnDispatchSuccess()
    {
        $entityMock = $this->getMock('T4webDomainInterface\EntityInterface');

        $this->deleterMock->method('delete')
            ->with($this->id)
            ->willReturn($entityMock);

        $this->eventMock->method('setResult')
            ->with($this->view);

        $actualViewModel = $this->controller->onDispatch($this->eventMock);

        $this->assertSame($this->view, $actualViewModel);
        $this->assertSame($entityMock, $actualViewModel->getEntity());
    }

    public function testOnDispatchFail()
    {
        $this->deleterMock->method('delete')
            ->with($this->id)
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