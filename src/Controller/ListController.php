<?php

namespace Sebaks\Crud\Controller;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\InputFilter\InputFilterInterface;
use T4webDomainInterface\Infrastructure\RepositoryInterface;
use Sebaks\Crud\View\Model\ListViewModelInterface;

class ListController extends AbstractActionController
{
    /**
     * @var array
     */
    private $query;

    /**
     * @var InputFilterInterface
     */
    private $inputFilter;

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
     * @param InputFilterInterface $inputFilter
     * @param RepositoryInterface $repository
     * @param ListViewModelInterface $viewModel
     */
    public function __construct(
        array $query,
        RepositoryInterface $repository,
        ListViewModelInterface $viewModel,
        InputFilterInterface $inputFilter = null
    )
    {
        $this->query = $query;
        $this->repository = $repository;
        $this->viewModel = $viewModel;
        $this->inputFilter = $inputFilter;
    }

    /**
     * Execute the request
     *
     * @param  MvcEvent $e
     * @return ListViewModelInterface
     */
    public function onDispatch(MvcEvent $e)
    {
        if ($this->inputFilter) {
            $this->inputFilter->setData($this->query);
            if ($this->inputFilter->isValid()) {
                $validData = $this->inputFilter->getValues();

                $criteria = $this->repository->createCriteria($validData);
                $collection = $this->repository->findMany($criteria);

                $this->viewModel->setCollection($collection);
                $this->viewModel->setInputData($validData);
            } else {
                $this->viewModel->setErrors($this->inputFilter->getMessages());
                $this->viewModel->setInputData($this->query);
            }
        } else {
            $criteria = $this->repository->createCriteria($this->query);
            $collection = $this->repository->findMany($criteria);

            $this->viewModel->setCollection($collection);
            $this->viewModel->setInputData($this->query);
        }

        $e->setResult($this->viewModel);

        return $this->viewModel;
    }
}
