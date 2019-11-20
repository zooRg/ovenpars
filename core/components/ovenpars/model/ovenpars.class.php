<?php

class ovenpars
{
    /** @var modX $modx */
    public $modx;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;
        $corePath = MODX_CORE_PATH . 'components/ovenpars/';
        $assetsUrl = MODX_ASSETS_URL . 'components/ovenpars/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',

            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
	        
	        //Настройки из админки для парсинга
	        'setting_url' => $this->modx->getOption('url', null),
	        'setting_container' => $this->modx->getOption('container', null),
	        'setting_item' => $this->modx->getOption('item', null),
	
	        //Настройки из админки для импорта
	        'setting_section_id' => $this->modx->getOption('section_id', null),
	        'setting_template_id' => $this->modx->getOption('template_id', null),
	        'setting_price_tv' => $this->modx->getOption('price_tv', null),
	        'setting_desc_tv' => $this->modx->getOption('desc_tv', null),
        ], $config);

        $this->modx->addPackage('ovenpars', $this->config['modelPath']);
        $this->modx->lexicon->load('ovenpars:default');
    }
	
	
	
}