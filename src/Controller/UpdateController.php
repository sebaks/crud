<?php

namespace Sebaks\Crud\Controller;

use Zend\Mvc\MvcEvent;

use Zend\Mvc\Controller\AbstractActionController;
use T4webDomainInterface\Service\UpdaterInterface;
use Sebaks\Crud\View\Model\UpdateViewModelInterface;

class UpdateController extends AbstractActionController
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $data;

    /**
     * @var UpdaterInterface
     */
    private $updater;

    /**
     * @var UpdateViewModelInterface
     */
    private $viewModel;

    /**
     * @var string
     */
    private $redirectTo;

    /**
     * @param $id
     * @param array $data
     * @param UpdaterInterface $updater
     * @param UpdateViewModelInterface $viewModel
     * @param null $redirectTo
     */
    public function __construct(
        $id,
        array $data,
        UpdaterInterface $updater,
        UpdateViewModelInterface $viewModel,
        $redirectTo = null
    )
    {
        $this->id = $id;
        $this->data = $data;
        $this->updater = $updater;
        $this->viewModel = $viewModel;
        $this->redirectTo = $redirectTo;
    }

    /**
     * Execute the request
     *
     * @param  MvcEvent $e
     * @return UpdateViewModelInterface|\Zend\Http\Response
     */
    public function onDispatch(MvcEvent $e)
    {
        $entity = $this->updater->update($this->id, $this->data);

        if ($entity) {
            if ($this->redirectTo) {
                return $this->redirect()->toRoute($this->redirectTo);
            }

            $this->viewModel->setEntity($entity);
        } else {
            $this->viewModel->setErrors($this->updater->getErrors());
            $this->viewModel->setInputData($this->data);
        }

        $e->setResult($this->viewModel);

        return $this->viewModel;
    }
}
