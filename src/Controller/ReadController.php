<?php

namespace Sebaks\Crud\Controller;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController;
use T4webDomainInterface\Infrastructure\RepositoryInterface;
use Sebaks\Crud\View\Model\ReadViewModelInterface;

class ReadController extends AbstractActionController
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var ReadViewModelInterface
     */
    private $viewModel;

    /**
     * @param int $id
     * @param RepositoryInterface $repository
     * @param ReadViewModelInterface $viewModel
     */
    public function __construct(
        $id,
        RepositoryInterface $repository,
        ReadViewModelInterface $viewModel)
    {
        $this->id = $id;
        $this->repository = $repository;
        $this->viewModel = $viewModel;
    }

    /**
     * Execute the request
     *
     * @param  MvcEvent $e
     * @return ReadViewModelInterface
     */
    public function onDispatch(MvcEvent $e)
    {
        $entity = $this->repository->findById($this->id);

        if (!$entity) {
            return $this->notFoundAction();
        }

        $this->viewModel->setEntity($entity);

        $e->setResult($this->viewModel);

        return $this->viewModel;
    }
}
