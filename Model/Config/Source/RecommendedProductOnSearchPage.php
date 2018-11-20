<?php
/**
 * @category   Emartech
 * @package    Emartech_EmarsysRecommender
 * @copyright  Copyright (c) 2018 Emarsys. (http://www.emarsys.net/)
 */
namespace Emartech\EmarsysRecommender\Model\Config\Source;

/**
 * Class RecommendedProductOnSearchPage
 * @package Emartech\EmarsysRecommender\Model\Config\Source
 */
class RecommendedProductOnSearchPage
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '||', 'label' => 'Please Select'],
            ['value' => 'SEARCH||search-template', 'label' => 'Search'],
            ['value' => 'PERSONAL||personal-template', 'label' => 'Personal']
        ];
    }
}
