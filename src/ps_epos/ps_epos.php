<?php
require_once(dirname(__FILE__) . '/init.php');

use esas\cmsgate\prestashop\CmsgatePaymentModule;
use esas\cmsgate\Registry;
use esas\cmsgate\RegistryEposPrestashop;
use esas\cmsgate\view\ViewBuilderPrestashop;
use PrestaShop\PrestaShop\Core\Payment\PaymentOption;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Ps_Epos extends CmsgatePaymentModule
{
    public function __construct()
    {
        parent::__construct();
//        $this->name = 'ps_epos';
//        $this->tab = 'payments_gateways';
//        $this->version = 'v1.1.8';
//        $this->ps_versions_compliancy = array('min' => '1.7.1.0', 'max' => _PS_VERSION_);
//        $this->author = 'esas';
//        $this->bootstrap = true;
//        $this->need_instance = 0; // а может все-таки 1?
//        $this->is_eu_compatible = 1;
//        parent::__construct();
//
//        $this->displayName = 'EPOS';
//        $this->description = 'Super EPOS';
//        $this->confirmUninstall = $this->trans('Are you sure about removing these details?', array(), 'Modules.Wirepayment.Admin'); //todo
//
//        foreach (Registry::getRegistry()->getConfigFormsArray() as $configForm) {
//            foreach ($configForm->getManagedFields()->getFieldsToRender() as $configField) {
//                if ($configField->isRequired() && empty($configField->getValue()))
//                    $this->warning = $this->l('Field [' . $configField->getName() . '] is required.');
//            }
//        }
        $this->controllers = array('payment', 'paymentWebpay', 'callback');
    }

    public function install()
    {
        if (!parent::install() || !$this->registerHook('paymentOptions')) {
            return false;
        }
        return true;
    }

    public function hookPaymentOptions($params)
    {
        if (!$this->active) {
            return [];
        }
        $eripOption = $this->createDefaultPaymentOption('payment');
        $webpayOption = new PaymentOption();
        $webpayOption->setModuleName($this->name)
            ->setCallToActionText(RegistryEposPrestashop::getRegistry()->getConfigWrapper()->getPaymentMethodNameWebpay())
            ->setAction($this->context->link->getModuleLink($this->name, 'payment_webpay', array(), true))
            ->setAdditionalInformation(RegistryEposPrestashop::getRegistry()->getConfigWrapper()->getPaymentMethodDetailsWebpay() . ViewBuilderPrestashop::elementSandboxMessage());
        $payment_options = [
            $eripOption, $webpayOption
        ];

        return $payment_options;
    }
}
