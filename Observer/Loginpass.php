<?php

namespace CHK\HomePage\Observer;

class Loginpass implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\App\Action\Context 
     */
    protected $context;
    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $redirect;
    /**
     * @var \Magento\Framework\App\RequestInterface 
     */
    protected $request;
    /**
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\RequestInterface $request,    
        \Magento\Framework\App\Response\RedirectInterface $redirect
    )
    {
        $this->context = $context;
        $this->request = $request;     
        $this->redirect = $redirect;   
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if(!$this->request->getParam("loginpass")){
            $controller = $observer->getControllerAction();
            $this->redirect->redirect($controller->getResponse(), 'customer/account/create');
        }
        return $this;
    }

}