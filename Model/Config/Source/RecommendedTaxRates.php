<?php
/**
 * @category   Emartech
 * @package    Emartech_EmarsysRecommender
 * @copyright  Copyright (c) 2018 Emarsys. (http://www.emarsys.net/)
 */
namespace Emartech\EmarsysRecommender\Model\Config\Source;

use Magento\Tax\Api\TaxRateRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

/**
 * Class RecommendedTaxRate
 * @package Emartech\EmarsysRecommender\Model\Config\Source
 */
class RecommendedTaxRates
{
    /**
     * @var TaxRateRepositoryInterface
     */
    protected $taxRateRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * RecommendedTaxRate constructor.
     *
     * @param TaxRateRepositoryInterface $taxRateRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        TaxRateRepositoryInterface $taxRateRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->taxRateRepository = $taxRateRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\InputException
     */
    public function toOptionArray()
    {
        $optionArray = [];
        $optionArray[] = ['value' => 0, 'label' => 'Please choose Tax Rate'];

        $searchCriteria = $this->searchCriteriaBuilder
            ->setPageSize(100)
            ->setCurrentPage(1)
            ->create();

        $rates = $this->taxRateRepository->getList($searchCriteria);

        foreach ($rates->getItems() as $rate) {
            $optionArray[] = [
                'value' => $rate->getRate(),
                'label' => $rate->getRate() . ' (' . $rate->getCode() . ')'
            ];
        }

        return $optionArray;
    }
}
