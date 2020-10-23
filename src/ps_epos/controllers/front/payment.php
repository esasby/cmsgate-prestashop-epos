<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');

use esas\cmsgate\epos\controllers\ControllerEposAddInvoice;
use esas\cmsgate\epos\controllers\ControllerEposCompletionPage;
use esas\cmsgate\epos\utils\RequestParamsEpos;
use esas\cmsgate\prestashop\CmsgateModuleFrontController;
use esas\cmsgate\Registry;

/**
 * @since 1.5.0
 */
class Ps_eposPaymentModuleFrontController extends CmsgateModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->validateModule();

        $orderWrapper = $this->getOrderWrapper(Tools::getValue(RequestParamsEpos::ORDER_NUMBER), Tools::getValue(RequestParamsEpos::ORDER_ID));

        // проверяем, привязан ли к заказу billid, если да,
        // то счет не выставляем, а просто прорисовываем старницу
        if (empty($orderWrapper->getExtId())) {
            $controller = new ControllerEposAddInvoice();
            $controller->process($orderWrapper);
        }
        $controller = new ControllerEposCompletionPage();
        $completionPanel = $controller->process($orderWrapper->getOrderId());
        $data['completionPanel'] = $completionPanel;
        $this->context->smarty->assign($data);
        $this->setTemplate('module:' . Registry::getRegistry()->getModuleDescriptor()->getModuleMachineName() . '/views/templates/front/payment_erip.tpl');
    }


    public function getPageName()
    {
        return "checkout"; //для подключения родного CSS, т.к. многие селекторы начинаются с body#checkout
    }


}
