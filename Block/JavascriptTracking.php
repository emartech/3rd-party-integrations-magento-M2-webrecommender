<?php
/**
 * @category   Emartech
 * @package    Emartech_EmarsysRecommender
 * @copyright  Copyright (c) 2018 Emarsys. (http://www.emarsys.net/)
 */
namespace Emartech\EmarsysRecommender\Block;

use Magento\Framework\App\Request\Http;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Magento\Checkout\Model\CartFactory;
use Magento\Catalog\Model\CategoryFactory;
use Emartech\Emarsys\Block\Snippets;

/**
 * Class JavascriptTracking
 * @package Emartech\EmarsysRecommender\Block
 */
class JavascriptTracking extends \Magento\Framework\View\Element\Template
{
    const XPATH_CMS_INDEX_INDEX = 'web_extend/recommended_product_pages/recommended_home_page';
    const XPATH_CATALOG_CATEGORY_VIEW = 'web_extend/recommended_product_pages/recommended_category_page';
    const XPATH_CATALOG_PRODUCT_VIEW = 'web_extend/recommended_product_pages/recommended_product_page';
    const XPATH_CHECKOUT_CART_INDEX = 'web_extend/recommended_product_pages/recommended_cart_page';
    const XPATH_CHECKOUT_ONEPAGE_SUCCESS = 'web_extend/recommended_product_pages/recommended_order_thankyou_page';
    const XPATH_CATALOGSEARCH_RESULT_INDEX = 'web_extend/recommended_product_pages/recommended_nosearch_result_page';

    const XPATH_WEBEXTEND_MODE = 'web_extend/javascript_tracking/testmode';
    const XPATH_WEBEXTEND_IDENTITY = 'web_extend/javascript_tracking/identityregistered';
    const XPATH_WEBEXTEND_UNIQUE_ID = 'web_extend/javascript_tracking/uniqueidentifier';
    const XPATH_WEBEXTEND_USE_BASE_CURRENCY = 'web_extend/javascript_tracking/use_base_currency';
    const XPATH_WEBEXTEND_INCLUDE_TAX = 'web_extend/javascript_tracking/tax_included';

    const XPATH_TRACK_AJAX_CART = 'track_ajax_cart';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CartFactory
     */
    protected $cartFactory;

    /**
     * @var Snippets
     */
    protected $snippets;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var CategoryFactory
     */
    protected $categoryFactory;

    /**
     * JavascriptTracking constructor.
     *
     * @param Context $context
     * @param Registry $registry
     * @param Http $request
     * @param CartFactory $cartFactory
     * @param Snippets $snippets
     * @param CategoryFactory $categoryFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Http $request,
        CartFactory $cartFactory,
        Snippets $snippets,
        CategoryFactory $categoryFactory,
        array $data = []
    ) {
        $this->registry = $registry;
        $this->storeManager = $context->getStoreManager();
        $this->_request = $request;
        $this->cartFactory = $cartFactory;
        $this->snippets = $snippets;
        $this->categoryFactory = $categoryFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function isEnableTrackCart()
    {
        return $this->storeManager->getStore()->getConfig(self::XPATH_TRACK_AJAX_CART);
    }

    /**
     * Get All Items of the Cart
     *
     * @return mixed
     */
    public function getAllCartItems()
    {
        return $this->cartFactory->create()->getQuote()->getAllItems();
    }

    /**
     * Get Cart Items Data in Json Format
     *
     * @return bool|string
     */
    public function getCartItemsJsonData()
    {
        $returnData = false;
        try {
            $allItems = $this->getAllCartItems();
            $useBaseCurrency = $this->storeManager->getStore()->getConfig(self::XPATH_WEBEXTEND_USE_BASE_CURRENCY);
            $uniqueIdentifier = $this->storeManager->getStore()->getConfig(self::XPATH_WEBEXTEND_UNIQUE_ID);

            if ($allItems != "") {
                $jsData = [];
                foreach ($allItems as $item) {
                    if ($item->getParentItemId()) {
                        continue;
                    }
                    $price = $useBaseCurrency ? $item->getBaseRowTotal() : $item->getRowTotal();

                    if ($uniqueIdentifier == "sku") {
                        $identifier = addslashes($item->getSku());
                    } else {
                        $identifier = $item->getProductId();
                    }
                    $qty = $item->getQty();

                    $jsData[] = sprintf("{item: '%s', price: %s, quantity: %s}", $identifier, $price, $qty);
                }

                $returnData = implode($jsData, ',');
            }
        } catch (\Exception $e) {
            $this->_logger->critical($e->getMessage());
        }

        return $returnData;
    }

    /**
     * Get Page Handle
     *
     * @return string
     */
    public function getPageHandle()
    {
        $handle = $this->_request->getParam('full_action_name');
        if (!$handle) {
            $handle = $this->_request->getFullActionName();
        }
        return $handle;
    }

    /**
     * Get Page Handle From Db
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPageHandleStatus()
    {
        $handle = $this->getPageHandle();

        $pageResult = [];

        $pageHandles = [
            'cms_index_index' => self::XPATH_CMS_INDEX_INDEX,
            'catalog_category_view' => self::XPATH_CATALOG_CATEGORY_VIEW,
            'catalog_product_view' => self::XPATH_CATALOG_PRODUCT_VIEW,
            'checkout_cart_index' => self::XPATH_CHECKOUT_CART_INDEX,
            'checkout_onepage_success' => self::XPATH_CHECKOUT_ONEPAGE_SUCCESS,
            'catalogsearch_result_index' => self::XPATH_CATALOGSEARCH_RESULT_INDEX
        ];

        if (array_key_exists($handle, $pageHandles)) {
            if ($this->getJsEnableStatusForAllPages()) {
                $path = $pageHandles[$handle];
                $pageValue = $this->storeManager->getStore()->getConfig($path);
                $pageData = explode('||', $pageValue);
                $pageResult['logic'] = $pageData[0];
                $pageResult['templateId'] = $pageData[1];
                $pageResult['status'] = 'Valid';
            } else {
                $pageResult['status'] = 'Invalid';
            }
        } else {
            $pageResult['status'] = 'Invalid';
        }

        return $pageResult;
    }

    /**
     * Get Ajax Update Url
     *
     * @return string
     */
    public function getAjaxUpdateUrl()
    {
        return $this->getUrl('emarsys/index/ajaxUpdate', ['_secure' => true]);
    }

    /**
     * Get Merchant Id from DB
     *
     * @return string
     */
    public function getMerchantId()
    {
        return $this->snippets->getMerchantId();
    }

    /**
     * Get Status of Web Extended Javascript integration
     *
     * @return bool
     */
    public function getJsEnableStatusForAllPages()
    {
        return true;
    }

    /**
     * Get Store Code
     *
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreCode()
    {
        if ($this->storeManager->getStore()->isDefault()) {
            return '';
        }
        return $this->storeManager->getStore()->getCode();
    }

    /**
     * Get Current Category
     *
     * @return string
     */
    public function getCurrentCategory()
    {
        $result = false;
        try {
            $category = $this->registry->registry('current_category');

            if ($category && $category->getId()) {
                $categoryName = '';
                $categoryPath = $category->getPath();
                $categoryPathIds = explode('/', $categoryPath);
                $childCats = [];
                if (count($categoryPathIds) > 2) {
                    $pathIndex = 0;
                    foreach ($categoryPathIds as $categoryPathId) {
                        if ($pathIndex <= 1) {
                            $pathIndex++;

                            continue;
                        }
                        $childCat = $this->categoryFactory->create()
                            ->setStoreId($this->storeManager->getStore()->getId())
                            ->load($categoryPathId);
                        $childCats[] = $childCat->getName();
                    }
                    $categoryName = implode(" > ", $childCats);
                }

                $result = addcslashes($categoryName, "'");
            }
        } catch (\Exception $e) {
            $this->_logger->critical($e->getMessage());
        }

        return $result;
    }

    /**
     * Get Current Product Sku
     *
     * @return string
     */
    public function getCurrentProductSku()
    {
        $result = false;
        $product = $this->registry->registry('current_product');

        if ($product && $product->getId()) {
            $result = addslashes('g/' . $product->getSku());
        }

        return $result;
    }

    /**
     * Get Search Param
     *
     * @return bool|mixed
     */
    public function getSearchResult()
    {
        return $this->_request->getParam('q');
    }

}
