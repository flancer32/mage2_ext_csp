<?php
/**
 * @package     Flancer32_Csp
 * @author      Andre Santiago
 * @email       admin@akkaweb.com
 */
namespace Flancer32\Csp\Block\Adminhtml\System\Config\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Psr\Log\LoggerInterface;

class DeveloperIps extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Template path
     *
     * @var string
     */
    protected $_template = 'Flancer32_Csp::system/config/developer_ips.phtml';
    protected $_remoteAddress;
    protected $_logger;

    /**
     * @param Context $context
     * @param RemoteAddress $remoteAddress
     * @param array $data
     */
    public function __construct(
        Context $context,
        RemoteAddress $remoteAddress
    ) {
        parent::__construct($context);
        $this->_remoteAddress = $remoteAddress;
    }

    /**
     * Remove scope label
     *
     * @param  AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     *
     * @param  AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * return String IP address
     */
    public function getIpAddress()
    {
        return $this->_remoteAddress->getRemoteAddress();
    }
}

