<?php

namespace Sebaks\CrudTest\Controller\Admin;

use Sebaks\Crud\Controller\CreateController;
use Sebaks\Crud\View\Model\CreateViewModel;

class CreateControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;
    private $data;
    private $creatorMock;
    private $view;
    private $eventMock;

    public function setUp()
    {
        $this->data = [
            'foo' => 'bar'
        ];

        $this->creatorMock = $this->getMockBuilder('T4webDomainInterface\Service\CreatorInterface')
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventMock = $this->getMock('Zend\Mvc\MvcEvent');

        $this->view = new CreateViewModel();

        $this->controller = new CreateController(
            $this->data,
            $this->creatorMock,
            $this->view
        );
    }

    public function testOnDispatchSuccess()
    {
        $entityMock = $this->getMock('T4webDomainInterface\EntityInterface');

        $this->creatorMock->method('create')
            ->with($this->data)
            ->willReturn($entityMock);

        $this->eventMock->method('setResult')
            ->with($this->view);

        $actualViewModel = $this->controller->onDispatch($this->eventMock);

        $this->assertSame($this->view, $actualViewModel);
        $this->assertSame($entityMock, $actualViewModel->getEntity());
    }

    public function testOnDispatchFail()
    {
        $this->creatorMock->method('create')
            ->with($this->data)
            ->willReturn(null);

        $this->creatorMock->method('getErrors')
            ->willReturn(['errorField' => 'error message']);

        $this->eventMock->method('setResult')
            ->with($this->view);

        $actualViewModel = $this->controller->onDispatch($this->eventMock);

        $this->assertSame($this->view, $actualViewModel);
        $this->assertNull($actualViewModel->getEntity());
        $this->assertEquals(['errorField' => 'error message'], $actualViewModel->getErrors());
        $this->assertSame($this->data, $actualViewModel->getInputData());
    }

}