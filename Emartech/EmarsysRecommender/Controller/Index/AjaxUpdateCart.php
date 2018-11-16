<?php
/**
 * @category   Emartech
 * @package    Emartech_EmarsysRecommender
 * @copyright  Copyright (c) 2018 Emarsys. (http://www.emarsys.net/)
 */

namespace Emartech\EmarsysRecommender\Controller\Index;

use Magento\{
    Framework\App\Action\Context,
    Framework\Serialize\Serializer\Json,
    Store\Model\StoreManagerInterface
};
use Psr\Log\LoggerInterface;

class AjaxUpdateCart extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Json
     */
    protected $serializer;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * AjaxUpdate constructor.
     *
     * @param Context $context
     * @param Json $serializer
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        Json $serializer,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger
    ) {
        $this->serializer = $serializer;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * Ajax Action
     */
    public function execute()
    {
        try {
            $result = [];
            $result['content'] = '';
            $result['status'] = 0;
            $this->_view->loadLayout();
            $layout = $this->_view->getLayout();

            $parentBlock = $layout->createBlock('Emartech\EmarsysRecommender\Block\JavascriptTracking',
                '',
                ['full_action_name' => $this->getRequest()->getParam('full_action_name')]
            )->setTemplate('Emartech_EmarsysRecommender::emarsys/cart.phtml');

            $result['content'] = $parentBlock->toHtml();
            $result['status'] = 1;

            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody($this->serializer->serialize($result));
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }
    }
}

