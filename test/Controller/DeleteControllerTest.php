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

        $this->deleterMock->method('getErrors')
            ->willReturn(['errorField' => 'error message']);

        $this->eventMock->method('setResult')
            ->with($this->view);

        $actualViewModel = $this->controller->onDispatch($this->eventMock);

        $this->assertSame($this->view, $actualViewModel);
        $this->assertNull($actualViewModel->getEntity());
        $this->assertEquals(['errorField' => 'error message'], $actualViewModel->getErrors());
    }

}