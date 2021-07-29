<?php

namespace CHK\HomePage\Plugin\Cms\Controller\Index;

use Closure;
use Magento\Customer\Model\Session;
use Magento\Cms\Helper\Page;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Store\Model\ScopeInterface;
use Magento\Cms\Controller\Index\Index as CmsIndex;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Index
 * @package CHK\HomePage\Plugin\Cms\Controller\Index
 */
class Index
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Page
     */
    protected $pageHelper;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Index constructor.
     *
     * @param Page $pageHelper
     * @param Session $customerSession
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Page $pageHelper,
        Session $customerSession,
        ScopeConfigInterface $scopeConfig,
        \Magento\Cms\Model\Page $page,
        StoreManagerInterface $storeManager
    ) {
        $this->pageHelper = $pageHelper;
        $this->session = $customerSession;
        $this->scopeConfig = $scopeConfig;
        $this->_page = $page;
        $this->storeManager = $storeManager;
    }

    /**
     * Renders CMS Home page
     *
     * @param string|null $coreRoute
     * @return bool|Forward|\Magento\Framework\View\Result\Page
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundExecute(
        CmsIndex $subject,
        Closure $proceed,
        $coreRoute = null
    ) {
        $loggedInHomePageUrkKey = $this->scopeConfig->getValue(
            'web/default/cms_login_home_page',
            ScopeInterface::SCOPE_STORE
        );
        $currentStoreId = $this->storeManager->getStore()->getId();
        $loggedInHomePageIdentifier = $this->_page->checkIdentifier($loggedInHomePageUrkKey, $currentStoreId);
        if ($this->session->isLoggedIn() && $loggedInHomePageIdentifier > 0) {
            return $this->pageHelper->prepareResultPage($subject, $loggedInHomePageIdentifier);
        }
        return $proceed($coreRoute);
    }
}
