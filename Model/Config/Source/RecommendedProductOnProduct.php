<?php
/**
 * @category   Emartech
 * @package    Emartech_EmarsysRecommender
 * @copyright  Copyright (c) 2018 Emarsys. (http://www.emarsys.net/)
 */
namespace Emartech\EmarsysRecommender\Model\Config\Source;

/**
 * Class RecommendedProductOnProduct
 * @package Emartech\EmarsysRecommender\Model\Config\Source
 */
class RecommendedProductOnProduct
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '||', 'label' => 'Please Select'],
            ['value' => 'RELATED||related-template', 'label' => 'Related'],
            ['value' => 'ALSO_BOUGHT||alsobought-template', 'label' => 'Also Bought'],
            ['value' => 'PERSONAL||personal-template', 'label' => 'Personal']
        ];
    }
}
