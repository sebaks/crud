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

        $actualViewModel = $this->controller->onDispatch($this->eventMock);

        $this->assertSame($this->view, $actualViewModel);
        $this->assertSame($entityMock, $actualViewModel->getEntity());
        $this->assertSame($this->data, $actualViewModel->getInputData());
    }

    public function testOnDispatchFail()
    {
        $this->updaterMock->method('update')
            ->with($this->id, $this->data)
            ->willReturn(null);

        $this->updaterMock->method('getErrors')
            ->willReturn(['errorField' => 'error message']);

        $actualViewModel = $this->controller->onDispatch($this->eventMock);

        $this->assertSame($this->view, $actualViewModel);
        $this->assertSame($this->data, $actualViewModel->getInputData());
        $this->assertNull($actualViewModel->getEntity());
        $this->assertEquals(['errorField' => 'error message'], $actualViewModel->getErrors());
        $this->assertSame($this->data, $actualViewModel->getInputData());
    }

}