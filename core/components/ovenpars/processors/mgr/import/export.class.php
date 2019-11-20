<?php

if (!class_exists('DiDom')) {
	require dirname(dirname(dirname(dirname(__FILE__)))) . '/vendor/autoload.php';
}

use DiDom\Document;

class ovenparsItemExportProcessor extends modObjectCreateProcessor
{
	public $objectType = 'ovenparsItem';
	public $classKey = 'ovenparsItem';
	public $languageTopics = ['ovenpars'];
	private $url;
	private $container;
	private $item;
	private $itemOnPageCount;
	
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
	
	public function process()
	{
		$this->url = $this->getProperty('url');
		$this->container = $this->getProperty('container');
		$this->item = $this->getProperty('item');
		$currPage = (int)$this->getProperty('currPage');
		
		if (0 < $currPage) {
			$currPage += 1;
			$this->url = $this->url . ';' . $currPage;
		}
		
		$data = $this->request($this->url);
		$html = $this->getElementHtml($data, $this->container, $this->item);
		if ($html) {
			$htmlText = [
				'page'          => $html['CURRENT'],
				'last_page'     => $html['LAST'],
				'items_current' => (12 * $html['CURRENT']),
				'items_max'     => (12 * $html['LAST'])
			];
		} else {
			$htmlText = [
				'page'          => $currPage,
				'last_page'     => $currPage,
				'items_current' => ((12 - $this->itemOnPageCount) * $currPage),
				'items_max'     => ((12 - $this->itemOnPageCount) * $currPage)
			];
		}
		
		return $this->outputArray([
			'url'       => $this->url,
			'container' => $this->container,
			'item'      => $this->item,
			'html'      => $htmlText
		]);
	}
	
	private function request($url, $post = [])
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); // отправляем на
		curl_setopt($ch, CURLOPT_HEADER, 0); // пустые заголовки
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);// таймаут
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_POST, $post ?? false); // использовать данные в post
		$data = curl_exec($ch);
		curl_close($ch);
		
		return $data;
	}
	
	private function getElementHtml($data, $container, $items)
	{
		$url = parse_url($this->url);
		$url = $url['scheme'] . '://' . $url['host'];
		
		$html = new Document($data);
		$parentName = $html->find('[itemtype="https://schema.org/BreadcrumbList"] [itemprop="itemListElement"]:last-child span')[0];
		if ($parentName) {
			$parentName = strtolower($parentName->text());
			$parent = mb_strtoupper(mb_substr($parentName, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($parentName, 1, null, 'UTF-8');
		}
		
		$pageList = $html->find('.plist');
		$pageList = (int)$pageList[0]->find('.pgSwchA')[0]->text();
		
		$pageLast = $html->find('.plist');
		$pageLast = $pageLast[0]->find('.pgSwch:last-child')[0];
		$pageLast = $pageLast ? (int)$pageLast->text() : false;
		
		$page = $html->find($container);
		$arItems = $page[0]->find($items);
		if (!$pageLast) {
			$pageLast = $html->find('.plist');
			$pageLast = $pageLast[0]->find('.pgSwchA:last-child')[0];
			$pageLast = $pageLast ? (int)$pageLast->text() : false;
			$this->itemOnPageCount = count($arItems);
		}
		
		$return['LAST'] = $pageLast;
		$return['CURRENT'] = $pageList;
		
		$itemsCount = 0;
		foreach ($arItems as $aritem) {
			$name = $aritem->find('.shop-item-title')[0];
			$price = $aritem->find('.shop-item-price span')[0];
			
			$link = $url . $name->attr('href');
			$htmlDetail = new Document($link, true);
			$descPreview = $htmlDetail->find('.shop-brief')[0];
			$description = $htmlDetail->find('.shop-info')[0];
			$morePhotoCurr = $htmlDetail->find('section.content .main-img img')[0];
			$morePhoto = $htmlDetail->find('section.content .img-list div a');
			
			$image[0] = $morePhotoCurr ? $url . $morePhotoCurr->attr('data-zoom-image') : '';
			foreach ($morePhoto as $key => $photo) {
				if (0 < $key) {
					$image[$key] = $photo ? $url . $photo->attr('data-zoom-image') : '';
				}
			}
			
			$descTabs = $htmlDetail->find('#shop-tabs')[0];
			$propsLink = $descTabs->find('li:nth-child(2) a')[0];
			$link = $url . $propsLink->attr('href');
			$htmlDetail = new Document($link, true);
			$descriptionProps = $htmlDetail->find('.shop-info .shop_spec')[0];
			
			$arDesc = [
				'previewText' => $descPreview ? trim($descPreview->text()) : '',
				'description' => $description ? trim($description->html()) : '',
				'props'       => $descriptionProps ? $descriptionProps->html() : '',
			];
			
			$this->addElement([
				'parent'      => $parent ? $parent : '',
				'name'        => $name ? $name->text() : '',
				'image'       => serialize($image),
				'price'       => $price ? $price->text() : '',
				'description' => serialize($arDesc),
				'active'      => 1,
			]);
			$itemsCount++;
		}
		
		return $return;
	}
	
	private function addElement($params)
	{
		if (!$object = $this->modx->getObject($this->classKey, ['name' => $params['name']])) {
			$object = $this->modx->newObject($this->classKey);
		}
		$object->set('parent', $params['parent']);
		$object->set('name', $params['name']);
		$object->set('image', $params['image']);
		$object->set('price', $params['price']);
		$object->set('description', $params['description']);
		$object->set('active', $params['active']);
		$object->save();
	}
}

return 'ovenparsItemExportProcessor';