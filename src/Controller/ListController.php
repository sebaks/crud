<?php

namespace Sebaks\Crud\Controller;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController;
use T4webFilter\FilterInterface;
use T4webDomainInterface\Infrastructure\RepositoryInterface;
use Sebaks\Crud\View\Model\ListViewModelInterface;

class ListController extends AbstractActionController
{
    /**
     * @var array
     */
    private $query;

    /**
     * @var FilterInterface
     */
    private $filter;

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var ListViewModelInterface
     */
    private $viewModel;

    /**
     * ListController constructor.
     * @param array $query
     * @param FilterInterface $filter
     * @param RepositoryInterface $repository
     * @param ListViewModelInterface $viewModel
     */
    public function __construct(
        array $query,
        FilterInterface $filter,
        RepositoryInterface $repository,
        ListViewModelInterface $viewModel
    )
    {
        $this->query = $query;
        $this->filter = $filter;
        $this->repository = $repository;
        $this->viewModel = $viewModel;
    }

    /**
     * Execute the request
     *
     * @param  MvcEvent $e
     * @return ListViewModelInterface
     */
    public function onDispatch(MvcEvent $e)
    {
        $filter = $this->filter->prepare($this->query);

        $criteria = $this->repository->createCriteria($filter);
        $collection = $this->repository->findMany($criteria);

        $this->viewModel->setCollection($collection);
        $this->viewModel->setFilter($filter);

        $e->setResult($this->viewModel);

        return $this->viewModel;
    }
}
