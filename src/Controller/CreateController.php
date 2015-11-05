<?php

namespace Sebaks\Crud\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use T4webDomainInterface\Service\CreatorInterface;
use Sebaks\Crud\View\Model\CreateViewModel;

class CreateController extends AbstractActionController
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var CreatorInterface
     */
    private $creator;

    /**
     * @var CreateViewModel
     */
    private $viewModel;

    /**
     * @var string
     */
    private $redirectTo;

    /**
     * @param array $data
     * @param CreatorInterface $creator
     * @param CreateViewModel $viewModel
     * @param null $redirectTo
     */
    public function __construct(
        array $data,
        CreatorInterface $creator,
        CreateViewModel $viewModel,
        $redirectTo = null)
    {
        $this->data = $data;
        $this->creator = $creator;
        $this->viewModel = $viewModel;
        $this->redirectTo = $redirectTo;
    }

    /**
     * @return CreateViewModel
     */
    public function indexAction()
    {
        $entity = $this->creator->create($this->data);

        if ($entity) {
            if ($this->redirectTo) {
                return $this->redirect()->toRoute($this->redirectTo);
            }
            $this->viewModel->setEntity($entity);
        } else {
            $this->viewModel->setErrors($this->creator->getErrors());
            $this->viewModel->setInputData($this->data);
        }

        return $this->viewModel;
    }
}
