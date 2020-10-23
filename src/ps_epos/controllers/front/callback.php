<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/init.php');

use esas\cmsgate\epos\controllers\ControllerEposCallback;
use esas\cmsgate\utils\Logger;

/**
 * @since 1.5.0
 */
class Ps_eposCallbackModuleFrontController extends ModuleFrontController
{
    public function initContent() {
        parent::initContent();
        $this->ajax = true; // enable ajax
    }

    /**
     * displayAjax обязательное имя
     */
    public function displayAjax()
    {
        try {
            $controller = new ControllerEposCallback();
            $controller->process();
        } catch (Throwable $e) {
            Logger::getLogger("notify")->error("Exception:", $e);
        } catch (Exception $e) { // для совместимости с php 5
            Logger::getLogger("notify")->error("Exception:", $e);
        }
    }


}
