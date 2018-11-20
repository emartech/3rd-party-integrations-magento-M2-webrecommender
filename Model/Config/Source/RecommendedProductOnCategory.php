<?php
/**
 * @category   Emartech
 * @package    Emartech_EmarsysRecommender
 * @copyright  Copyright (c) 2018 Emarsys. (http://www.emarsys.net/)
 */
namespace Emartech\EmarsysRecommender\Model\Config\Source;

/**
 * Class RecommendedProductOnCategory
 * @package Emartech\EmarsysRecommender\Model\Config\Source
 */
class RecommendedProductOnCategory
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '||', 'label' => 'Please Select'],
            ['value' => 'CATEGORY||category-template', 'label' => 'Category'],
            ['value' => 'DEPARTMENT||simple-tmpl', 'label' => 'Department'],
            ['value' => 'PERSONAL||personal-template', 'label' => 'Personal'],
            ['value' => 'POPULAR||popular-template', 'label' => 'Popular'],
        ];
    }
}
