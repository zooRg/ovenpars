<?php

class ovenparsItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'ovenparsItem';
    public $classKey = 'ovenparsItem';
    public $languageTopics = ['ovenpars'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('ovenpars_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('ovenpars_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'ovenparsItemCreateProcessor';