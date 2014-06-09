<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use AceLibrary\Controller\AceController;
use AceLibrary\Resize;

class UtilsController extends AceController {

    public function cropImageAction()
    {
    	$request = $this->getRequest();
		if($request->isPost()) {
            $post = $request->getPost();
	        $src = explode('?', trim($post['src']));
	        $src = $src[0];
	        if (!$src || !file_exists($src = PUBLIC_PATH . $src)) {
	            throw new \Exception('Incorrect image path');
	        }
	        
	        $thumbnail = explode('?', trim($post['thumbnail']));
	        $thumbnail = $thumbnail[0];
	        if (!$thumbnail || !file_exists($thumbnail = PUBLIC_PATH . $thumbnail)) {
	            throw new \Exception('Incorrect thumbnail path');
	        }
	        
	        $x = (int)$post['x'];
	        $y = (int)$post['y'];
	        $width = (int)$post['width'];
	        $height = (int)$post['height'];
	        if (null === $x || null === $y || null === $width || null === $height) {
	            throw new \Exception('Incorrect crop parameters');
	        }
	        
	        $model = new \AceLibrary\Resize();
			$model->load($src);
			
			if ($thumbnail != $src) {
	            $model->cropThumbnail($thumbnail, $x, $y, $width, $height);				
	        }
	        $model->crop($x, $y, $width, $height);
	        $model->save($src, \AceLibrary\Resize::IMAGETYPE_ORIGINAL, 100, 0777);
	        
			echo json_encode(array('success' => true));
			exit;	        
	    } else {
	    	exit;
	    }
    }
}
