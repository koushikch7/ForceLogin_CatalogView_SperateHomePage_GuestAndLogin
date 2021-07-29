<?php

namespace CHK\HomePage\Observer;

class Loginredirect implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\App\Action\Context 
     */
    protected $context;
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;
    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $redirect;

    /**
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\App\Response\RedirectInterface $redirect
    )
    {
        $this->context         = $context;
        $this->customerSession = $session;
        $this->messageManager = $context->getMessageManager();
        $this->redirect = $redirect;   
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->customerSession->isLoggedIn()) {
            $this->messageManager->addWarning(__('You must login into system for accessing this page.'));
            $controller = $observer->getControllerAction();
            $this->redirect->redirect($controller->getResponse(), 'customer/account/create');
        }
        return $this;
    }

}