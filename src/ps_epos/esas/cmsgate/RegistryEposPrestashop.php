<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikit
 * Date: 15.07.2019
 * Time: 11:22
 */

namespace esas\cmsgate;

use Context;
use esas\cmsgate\descriptors\ModuleDescriptor;
use esas\cmsgate\descriptors\VendorDescriptor;
use esas\cmsgate\descriptors\VersionDescriptor;
use esas\cmsgate\epos\ConfigFieldsEpos;
use esas\cmsgate\epos\PaysystemConnectorEpos;
use esas\cmsgate\epos\RegistryEpos;
use esas\cmsgate\epos\utils\RequestParamsEpos;
use esas\cmsgate\hutkigrosh\ConfigFieldsHutkigrosh;
use esas\cmsgate\hutkigrosh\PaysystemConnectorHutkigrosh;
use esas\cmsgate\hutkigrosh\RegistryHutkigrosh;
use esas\cmsgate\hutkigrosh\utils\RequestParamsHutkigrosh;
use esas\cmsgate\view\admin\AdminViewFields;
use esas\cmsgate\view\admin\ConfigFormPrestashop;
use esas\cmsgate\view\client\CompletionPanelEposPrestashop;
use Link;

class RegistryEposPrestashop extends RegistryEpos
{
    public function __construct()
    {
        $this->cmsConnector = new CmsConnectorPrestashop();
        $this->paysystemConnector = new PaysystemConnectorEpos();
    }

    /**
     * Переопделение для упрощения типизации
     * @return RegistryEposPrestashop
     */
    public static function getRegistry()
    {
        return parent::getRegistry();
    }

    /**
     * Переопделение для упрощения типизации
     * @return ConfigFormPrestashop
     */
    public function getConfigForm()
    {
        return parent::getConfigForm();
    }

    public function createConfigForm()
    {
        $managedFields = $this->getManagedFieldsFactory()->getManagedFieldsExcept(AdminViewFields::CONFIG_FORM_COMMON,
            [
                ConfigFieldsEpos::shopName()
            ]);
        $configForm = new ConfigFormPrestashop(
            AdminViewFields::CONFIG_FORM_COMMON,
            $managedFields);
        return $configForm;
    }

    public function getCompletionPanel($orderWrapper)
    {
        return new CompletionPanelEposPrestashop($orderWrapper);
    }

    function getUrlWebpay($orderWrapper)
    {
        return (new Link())->getModuleLink(Registry::getRegistry()->getModuleDescriptor()->getModuleMachineName(), 'payment', array(RequestParamsEpos::ORDER_NUMBER => $orderWrapper->getOrderNumber())) ;
    }

    public function createModuleDescriptor()
    {
        return new ModuleDescriptor(
            "ps_epos",
            new VersionDescriptor("1.13.0", "2020-11-11"),
            "Прием платежей через ЕРИП (сервис EPOS)",
            "https://bitbucket.esas.by/projects/CG/repos/cmsgate-prestashop-epos/browse",
            VendorDescriptor::esas(),
            "Выставление пользовательских счетов в ЕРИП"
        );
    }
}