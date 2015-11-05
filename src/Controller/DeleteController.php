<?php

namespace Sebaks\Crud\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use T4webDomainInterface\Service\DeleterInterface;
use Sebaks\Crud\View\Model\DeleteViewModel;

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
     * @var DeleteViewModel
     */
    private $viewModel;

    /**
     * @var string
     */
    private $redirectTo;

    /**
     * @param $id
     * @param DeleterInterface $deleter
     * @param DeleteViewModel $viewModel
     * @param null $redirectTo
     */
    public function __construct(
        $id,
        DeleterInterface $deleter,
        DeleteViewModel $viewModel,
        $redirectTo = null
    )
    {
        $this->id = $id;
        $this->deleter = $deleter;
        $this->viewModel = $viewModel;
        $this->redirectTo = $redirectTo;
    }

    /**
     * @return DeleteViewModel|\Zend\Http\Response
     */
    public function indexAction()
    {
        $entity = $this->deleter->delete($this->id);

        if ($entity) {
            if ($this->redirectTo) {
                return $this->redirect()->toRoute($this->redirectTo);
            }

            $this->viewModel->setEntity($entity);
        } else {
            $this->viewModel->setErrors($this->deleter->getErrors());
        }

        return $this->viewModel;
    }
}
