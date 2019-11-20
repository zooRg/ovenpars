<?php

/**
 * The home manager controller for ovenpars.
 *
 */
class ovenparsHomeManagerController extends modExtraManagerController
{
    /** @var ovenpars $ovenpars */
    public $ovenpars;


    /**
     *
     */
    public function initialize()
    {
        $this->ovenpars = $this->modx->getService('ovenpars', 'ovenpars', MODX_CORE_PATH . 'components/ovenpars/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['ovenpars:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('ovenpars');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addCss($this->ovenpars->config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($this->ovenpars->config['jsUrl'] . 'mgr/ovenpars.js');
        $this->addJavascript($this->ovenpars->config['jsUrl'] . 'mgr/misc/utils.js');
        $this->addJavascript($this->ovenpars->config['jsUrl'] . 'mgr/misc/combo.js');
        $this->addJavascript($this->ovenpars->config['jsUrl'] . 'mgr/widgets/items.grid.js');
        $this->addJavascript($this->ovenpars->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->ovenpars->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->ovenpars->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        ovenpars.config = ' . json_encode($this->ovenpars->config) . ';
        ovenpars.config.connector_url = "' . $this->ovenpars->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "ovenpars-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="ovenpars-panel-home-div"></div>';

        return '';
    }
}