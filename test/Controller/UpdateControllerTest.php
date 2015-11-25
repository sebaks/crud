<?php

namespace Sebaks\CrudTest\Controller\Admin;

use Sebaks\Crud\Controller\UpdateController;
use Sebaks\Crud\View\Model\UpdateViewModel;

class UpdateControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;
    private $id;
    private $data;
    private $updaterMock;
    private $view;
    private $eventMock;

    public function setUp()
    {
        $this->id = 22;
        $this->data = [
            'foo' => 'bar'
        ];

        $this->updaterMock = $this->getMockBuilder('T4webDomainInterface\Service\UpdaterInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventMock = $this->getMock('Zend\Mvc\MvcEvent');

        $this->view = new UpdateViewModel();

        $this->controller = new UpdateController(
            $this->id,
            $this->data,
            $this->updaterMock,
            $this->view
        );
    }

    public function testOnDispatchSuccess()
    {
        $entityMock = $this->getMock('T4webDomainInterface\EntityInterface');

        $this->updaterMock->method('update')
            ->with($this->id, $this->data)
            ->willReturn($entityMock);

        $this->eventMock->method('setResult')
            ->with($this->view);

        $actualViewModel = $this->controller->onDispatch($this->eventMock);

        $this->assertSame($this->view, $actualViewModel);
        $this->assertSame($entityMock, $actualViewModel->getEntity());
    }

    public function testOnDispatchNotFound()
    {
        $this->updaterMock->method('update')
            ->with($this->id, $this->data)
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

    public function testOnDispatchValidationFail()
    {
        $entityMock = $this->getMock('T4webDomainInterface\EntityInterface');

        $this->updaterMock->method('update')
            ->with($this->id, $this->data)
            ->willReturn($entityMock);

        $this->eventMock->expects($this->once())
            ->method('setResult')
            ->with($this->view);

        $this->updaterMock->method('hasErrors')
            ->willReturn(true);

        $this->updaterMock->method('getErrors')
            ->willReturn(['errorField' => 'error message']);

        $this->controller->setEvent($this->eventMock);
        $actualViewModel = $this->controller->onDispatch($this->eventMock);

        $this->assertSame($this->view, $actualViewModel);
        $this->assertSame($this->data, $actualViewModel->getInputData());
        $this->assertSame($entityMock, $actualViewModel->getEntity());
        $this->assertEquals(['errorField' => 'error message'], $actualViewModel->getErrors());
    }

}