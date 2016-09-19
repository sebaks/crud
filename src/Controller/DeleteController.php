<?php

namespace Sebaks\Crud\Controller;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController;
use T4webDomainInterface\Service\DeleterInterface;
use Sebaks\Crud\View\Model\DeleteViewModelInterface;

class DeleteController extends AbstractActionController
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DeleterInterface
     */
    private $deleter;

    /**
     * @var DeleteViewModelInterface
     */
    private $viewModel;

    /**
     * @var string
     */
    private $redirectTo;

    /**
     * @param $id
     * @param DeleterInterface $deleter
     * @param DeleteViewModelInterface $viewModel
     * @param null $redirectTo
     */
    public function __construct(
        $id,
        DeleterInterface $deleter,
        DeleteViewModelInterface $viewModel,
        $redirectTo = null
    )
    {
        $this->id = $id;
        $this->deleter = $deleter;
        $this->viewModel = $viewModel;
        $this->redirectTo = $redirectTo;
    }

    /**
     * Execute the request
     *
     * @param  MvcEvent $e
     * @return DeleteViewModelInterface|\Zend\Http\Response
     */
    public function onDispatch(MvcEvent $e)
    {
        $entity = $this->deleter->delete($this->id);

        if (!$entity) {
            return $this->notFoundAction();
        }
        
        $this->viewModel->setEntity($entity);
        $e->setResult($this->viewModel);

        if ($this->deleter->hasErrors()) {
            $this->viewModel->setErrors($this->deleter->getErrors());
            $this->viewModel->setInputData([$this->id]);
            return $this->viewModel;
        }
        
        if ($this->redirectTo) {
            return $this->redirect()->toRoute($this->redirectTo);
        }

        $this->viewModel->setEntity($entity);
        $e->setResult($this->viewModel);

        if ($this->deleter->hasErrors()) {
            $this->viewModel->setErrors($this->deleter->getErrors());
            $this->viewModel->setInputData([$this->id]);
        }

        return $this->viewModel;
    }
}
