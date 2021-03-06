<?php

class ovenparsItemDisableProcessor extends modObjectProcessor
{
    public $objectType = 'ovenparsItem';
    public $classKey = 'ovenparsItem';
    public $languageTopics = ['ovenpars'];
    //public $permission = 'save';


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

        $ids = $this->modx->fromJSON($this->getProperty('ids'));
        if (empty($ids)) {
            return $this->failure($this->modx->lexicon('ovenpars_item_err_ns'));
        }

        foreach ($ids as $id) {
            /** @var ovenparsItem $object */
            if (!$object = $this->modx->getObject($this->classKey, $id)) {
                return $this->failure($this->modx->lexicon('ovenpars_item_err_nf'));
            }

            $object->set('active', 0);
            $object->save();
        }

        return $this->success();
    }

}

return 'ovenparsItemDisableProcessor';
