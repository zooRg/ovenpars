<?php
define('OVENPARS_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'] . MODX_ASSETS_URL . 'img/ovenpars/');
require_once MODX_CORE_PATH.'model/phpthumb/phpthumb.class.php';

class ovenparsItemImportProcessor extends modObjectCreateProcessor
{
    public $objectType = 'ovenparsItem';
    public $classKey = 'ovenparsItem';
    public $languageTopics = ['ovenpars'];
    //public $permission = 'create';
	private $parent;
	private $template;
	private $price;
	private $description;
	private $image;
	
	/**
	 * We doing special check of permission
	 * because of our objects is not an instances of modAccessibleObject
	 *
	 * @return bool|string
	 */
	public function beforeSave()
	{
		if (!$this->checkPermissions()) {
			return $this->modx->lexicon('access_denied');
		}
		
		return true;
	}

    /**
     * @return bool
     */
    public function process()
    {
	    $this->parent = $this->getProperty('parent');
	    $this->template = $this->getProperty('template');
	    $this->price = $this->getProperty('price');
	    $this->description = $this->getProperty('description');
	    $this->image = $this->getProperty('image');
	    $lasID = $this->getProperty('lasID') ? (int) $this->getProperty('lasID') : 0;
	
	    $countItems = count($this->modx->getCollection($this->classKey));
	    $res = $this->modx->newQuery($this->classKey, array('id:>' => $lasID, 'active' => 1));
	    $res->limit(10);
	    $res->prepare();
	    $res->stmt->execute();
	    $object = $res->stmt->fetchAll(PDO::FETCH_ASSOC);
	    $items_current = $this->getProperty('items_current') ? $this->getProperty('items_current') : 1;
	    
	    foreach ($object as $item) {
	    	if (!$item) continue;
	    	
	    	$id = $item[$this->classKey . '_' .'id'];
	    	$parent = $item[$this->classKey . '_' .'parent'];
	    	$name = $item[$this->classKey . '_' .'name'];
	    	$image = unserialize($item[$this->classKey . '_' .'image']);
		    $price = $item[$this->classKey . '_' .'price'];
		    $description = unserialize($item[$this->classKey . '_' .'description']);
		    
		    if ($resourceModx = $this->modx->getObject('modResource', ['pagetitle' => $parent, 'id' => $this->parent])) {
			    if (!$resource = $this->modx->getObject('modResource', ['pagetitle' => $name, 'parent' => $this->parent])) {
				    $resource = $this->modx->newObject('modResource');
			    }
			    
			    $min = $this->getImage($resourceModx, $resource, $image);
			    
			    $resource->set('published', 1);
			    $resource->set('pagetitle', $name);
			    $resource->set('alias', $this->str2url($name));
			    $resource->set('introtext', $description['previewText']);
			    $resource->set('content', $description['description']);
			    $resource->set('parent', $resourceModx->get('id'));
			    $resource->set('template', $this->template);
			    $resource->set('tv_' . $this->price, $price);
			    $resource->set('tv_' . $this->description, $description['props']);
			    if ($min) {
				    $resource->set('tv_' . $this->image, $min);
				    $resource->setTVValue($this->image, $min);
			    }
			    $resource->setTVValue($this->price, $price);
			    $resource->setTVValue($this->description, $description['props']);
			    $resource->save();
		    }
		    $lasID = (int) $id;
		    $items_current += 1;
	    }
	    
	    return $this->outputArray([
		    'parent'        => $this->parent,
		    'template'      => $this->template,
		    'price'         => $this->price,
		    'description'   => $this->description,
		    'lasID'         => $lasID,
		    'items_current' => $items_current > $countItems ? $countItems : $items_current,
		    'countItems'    => $countItems,
	    ]);
    }
    
    private function getImage($resourceModx, $resource, $image)
    {
	    $minOut = '';
	    $origin = OVENPARS_IMAGE_PATH . 'origin/' . $resourceModx->get('id') . '/img_' . $resource->get('id') . '.jpg';
	    $min = OVENPARS_IMAGE_PATH . 'thumb/' . $resourceModx->get('id') . '/img_' . $resource->get('id') . '.jpg';
	
	    if (!is_dir(OVENPARS_IMAGE_PATH . 'origin/' . $resourceModx->get('id') . '/')) {
		    if (!mkdir($concurrentDirectory = OVENPARS_IMAGE_PATH . 'origin/' . $resourceModx->get('id') . '/') && !is_dir($concurrentDirectory)) {
			    throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
		    }
	    }
	    if (!is_dir(OVENPARS_IMAGE_PATH . 'thumb/' . $resourceModx->get('id') . '/')) {
		    if (!mkdir($concurrentDirectory = OVENPARS_IMAGE_PATH . 'thumb/' . $resourceModx->get('id') . '/') && !is_dir($concurrentDirectory)) {
			    throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
		    }
	    }
	
	    if (!file_exists($origin) && !file_exists($min) && !copy($image[0], $origin)) {
		    $this->modx->log(modX::LOG_LEVEL_ERROR, 'не удалось скопировать ' . $image[0]);
	    } elseif ($resource->get('id')) {
		    $size = getimagesize($origin);
		    $sizeW = $size[0];
		    $sizeH = $size[1];
		
		    $phpThumb = new phpThumb();
		    $phpThumb->setSourceFilename($origin);
		    $params = array(
			    'sx'  => ($sizeW * 0.05),
			    'sy'  => ($sizeH * 0.05),
			    'sw'  => ($sizeW * 0.85),
			    'sh'  => ($sizeH * 0.85),
			    'bg' => 'ffffff',
			    'q'  => 95,
			    'zc' => 'TL',
			    'f'  => 'jpg'
		    );
		    foreach ($params as $key => $value) {
			    $phpThumb->setParameter($key, $value);
		    }
		
		    $minOut = str_replace($_SERVER['DOCUMENT_ROOT'], '', $min);
		    if ($phpThumb->GenerateThumbnail()) {
			    if (!$phpThumb->renderToFile($min)) {
				    $this->modx->log(modX::LOG_LEVEL_ERROR, 'Could not save rendered image to' . $min);
			    }
		    } else {
			    $this->modx->log(modX::LOG_LEVEL_ERROR, print_r($phpThumb->debugmessages, 1));
		    }
		    unset($phpThumb, $origin, $params);
	    }
	    
	    return $minOut;
    }

    private function rus2translit($string) {
		$converter = array(
			'а' => 'a',   'б' => 'b',   'в' => 'v',
			'г' => 'g',   'д' => 'd',   'е' => 'e',
			'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
			'и' => 'i',   'й' => 'y',   'к' => 'k',
			'л' => 'l',   'м' => 'm',   'н' => 'n',
			'о' => 'o',   'п' => 'p',   'р' => 'r',
			'с' => 's',   'т' => 't',   'у' => 'u',
			'ф' => 'f',   'х' => 'h',   'ц' => 'c',
			'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
			'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
			'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
			
			'А' => 'A',   'Б' => 'B',   'В' => 'V',
			'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
			'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
			'И' => 'I',   'Й' => 'Y',   'К' => 'K',
			'Л' => 'L',   'М' => 'M',   'Н' => 'N',
			'О' => 'O',   'П' => 'P',   'Р' => 'R',
			'С' => 'S',   'Т' => 'T',   'У' => 'U',
			'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
			'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
			'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
			'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);
		return strtr($string, $converter);
	}
	
	private function str2url($str) {
		// переводим в транслит
		$str = $this->rus2translit($str);
		// в нижний регистр
		$str = strtolower($str);
		// заменям все ненужное нам на "-"
		$str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
		// удаляем начальные и конечные '-'
		$str = trim($str, "-");
		return $str;
	}
}

return 'ovenparsItemImportProcessor';