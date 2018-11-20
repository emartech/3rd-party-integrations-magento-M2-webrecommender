<?php
/**
 * @category   Emartech
 * @package    Emartech_EmarsysRecommender
 * @copyright  Copyright (c) 2018 Emarsys. (http://www.emarsys.net/)
 */
namespace Emartech\EmarsysRecommender\Model\Config\Source;

/**
 * Class RecommendedProductOnHomePage
 * @package Emartech\EmarsysRecommender\Model\Config\Source
 */
class RecommendedProductOnHomePage
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '||', 'label' => 'Please select'],
            ['value' => 'HOME_||simple-tmpl', 'label' => 'Home'],
            ['value' => 'PERSONAL||personal-template', 'label' => 'Personal'],
        ];
    }
}
