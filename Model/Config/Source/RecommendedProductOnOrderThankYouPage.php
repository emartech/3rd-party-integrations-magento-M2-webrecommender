<?php
/**
 * @category   Emartech
 * @package    Emartech_EmarsysRecommender
 * @copyright  Copyright (c) 2018 Emarsys. (http://www.emarsys.net/)
 */
namespace Emartech\EmarsysRecommender\Model\Config\Source;

/**
 * Class RecommendedProductOnOrderThankYouPage
 * @package Emartech\EmarsysRecommender\Model\Config\Source
 */
class RecommendedProductOnOrderThankYouPage
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '||', 'label' => 'Please Select'],
            ['value' => 'PERSONAL||personal-template', 'label' => 'Personal']
        ];
    }
}
