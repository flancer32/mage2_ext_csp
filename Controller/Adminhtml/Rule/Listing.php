<?php
/**
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp\Controller\Adminhtml\Rule;

use Flancer32\Csp\Config as Cfg;

class Listing
    extends \Magento\Backend\App\Action
{
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu(Cfg::MENU_CSP);
        $resultPage->getConfig()->getTitle()->prepend(__('CSP Rules'));
        return $resultPage;
    }

}
