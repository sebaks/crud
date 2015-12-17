<?php

namespace Sebaks\Crud\Controller;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController;
use T4webDomainInterface\Infrastructure\CriteriaInterface;
use T4webDomainInterface\Infrastructure\RepositoryInterface;
use Sebaks\Crud\View\Model\ReadViewModelInterface;

class ReadController extends AbstractActionController
{
    /**
     * @var CriteriaInterface
     */
    private $criteria;

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var ReadViewModelInterface
     */
    private $viewModel;

    /**
     * @param CriteriaInterface $criteria
     * @param RepositoryInterface $repository
     * @param ReadViewModelInterface $viewModel
     */
    public function __construct(
        CriteriaInterface $criteria,
        RepositoryInterface $repository,
        ReadViewModelInterface $viewModel)
    {
        $this->criteria = $criteria;
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
        $entity = $this->repository->find($this->criteria);

        if (!$entity) {
            return $this->notFoundAction();
        }

        $this->viewModel->setEntity($entity);

        $e->setResult($this->viewModel);

        return $this->viewModel;
    }
}
