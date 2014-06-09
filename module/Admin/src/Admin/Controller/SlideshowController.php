<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Admin for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Admin\Model\SlideshowModel;
use Admin\Model\BlockModel;
use Admin\Model\UploadhandlerModel;
use Admin\Model\SlideshowImageModel;
use Admin\Form\SlideshowActionsForm;
use Admin\Form\SlideshowForm;
use AceLibrary\Controller\AceController;

class SlideshowController extends AceController {
    
	protected $slideshowModel;
	protected $blockModel;
	protected $uploadhandlerModel;
	protected $slideshowImageModel;
	protected $sessionStorage;
	
    //List Slideshows
    public function listSlideshowAction() {
    	$slideshowActionsForm = new SlideshowActionsForm($this->getServiceLocator());
		
		$request = $this->getRequest();
        if($request->isPost()) {
            $post = $request->getPost();
            $slideshowActionsForm->setData($post);
            if($slideshowActionsForm->isValid()) {
            	if($post['action'] == $slideshowActionsForm::ACTION_DELETE && array_key_exists('slideshows', $post) && is_array($post['slideshows']) && count($post['slideshows']) == count($post['slideshows'], COUNT_RECURSIVE)) {
            		$this->getSlideshowModel()->bulkDelete($post['slideshows']);
            	}
            }
        }
        if(!isset($slideshowList)) {
            $slideshowList = $this->getSlideshowModel()->getSlideshowList();
        }
        
		$this->layout()->heading = $this->getTranslator()->translate('Slideshows');
        return array(    
        	'slideshowActionsForm'		=> $slideshowActionsForm,        
            'slideshowList'             => $slideshowList,            
        );		 
    }
    
	public function deleteAction() {
    	$id = (int) $this->params()->fromRoute('id');
    	if($id != 0) {
    	   $this->getSlideshowModel()->delete($id);
    	}
    	return $this->redirect()->toRoute('zfcadmin/modules/slideshow');
    }
    
	
    public function addSlideshowAction() {
    	$slideshowForm = new SlideshowForm($this->getServiceLocator());
        $request = $this->getRequest();
        
        if($request->isPost()) {
            $post = $request->getPost();
            $slideshowForm->setData($post);
            if($slideshowForm->isValid()) {
            	$slideshowId = $this->getSlideshowModel()->addSlideshow($slideshowForm->getData());
				
				/*$blockRow = $this->getBlockModel()->getBlock('slideshow-'.$slideshowId);
				if(!empty($blockRow))
                {
                	$this->getBlockModel()->editBlock($blockRow['block_id'],
                										array(
								                	     	'block_module' => 'slideshow',
									                	    'block_area' => (!empty($post['area']))?$post['area']:"",
									                	    'block_selector' => 'slideshow-'.$slideshowId,
									                   		'block_custom' => 0,
									                    	'block_status' => (!empty($post['area']))?1:0,
									                    	'block_description' => $post['slideshow_name'],
									                	)
													);
                } else{
                	$this->getBlockModel()->addBlock(array(
                	    'block_module' => 'slideshow',
                	    'block_area' => (!empty($post['area']))?$post['area']:"",
                	    'block_selector' => 'slideshow-'.$slideshowId,
                   		'block_custom' => 0,
                    	'block_status' => (!empty($post['area']))?1:0,
                    	'block_description' => $post['slideshow_name'],
                	));
                }*/
								
                return $this->redirect()->toRoute('zfcadmin/modules/slideshow/default', array('action'=>'images', 'id'=>$slideshowId));
            }
        }
        $this->layout()->heading = 'Add Slideshow';
        return array(
            'slideshowForm'  => $slideshowForm,
        );
    }
	
	public function editSlideshowAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if($id == 0) {
            return $this->redirect()->toRoute('zfcadmin/modules/slideshow');
        }
        $slideshow = $this->getSlideshowModel()->getSlideshow($id);
        if(!$slideshow) {
            return $this->redirect()->toRoute('zfcadmin/modules/slideshow');
        }
        $slideshowForm = new SlideshowForm($this->getServiceLocator());
        
		//$blockRow = $this->getBlockModel()->getBlock('slideshow-'.$id);
				
        $request = $this->getRequest();
        if($request->isPost()) {
            $post = $request->getPost();
            $slideshowForm->setData($post);
            if($slideshowForm->isValid()) {
                $data = $slideshowForm->getData();
                $this->getSlideshowModel()->editSlideshow($id, $data);
				/*				
				if(!empty($blockRow))
                {
                	$this->getBlockModel()->editBlock($blockRow['block_id'],
                										array(
								                	     	'block_module' => 'slideshow',
									                	    'block_area' => (!empty($post['area']))?$post['area']:"",
									                	    'block_selector' => 'slideshow-'.$id,
									                   		'block_custom' => 0,
									                    	'block_status' => (!empty($post['area']))?1:0,
									                    	'block_description' => $post['slideshow_name'],
									                	)
													);
                } else {
                	$this->getBlockModel()->addBlock(array(
                	    'block_module' => 'slideshow',
                	    'block_area' => (!empty($post['area']))?$post['area']:"",
                	    'block_selector' => 'slideshow-'.$id,
                   		'block_custom' => 0,
                    	'block_status' => (!empty($post['area']))?1:0,
                    	'block_description' => $post['slideshow_name'],
                	));
                }
				*/
                return $this->redirect()->toRoute('zfcadmin/modules/slideshow/default', array('action'=>'images', 'id'=>$id));
            }
        }
        else {
        	//$slideshow['area'] = $blockRow['block_area'];
            $slideshowForm->setData($slideshow);
        }
        
        return array(
            'slideshowForm'  => $slideshowForm,
            'id'        => $id,
        );
    }
	
	public function imagesAction() {
		$id = (int) $this->params()->fromRoute('id', 0);
		$slideshow = $this->getSlideshowModel()->getSlideshow($id);
        
		if(empty($slideshow)) {
			return $this->redirect()->toRoute('zfcadmin/modules/slideshow');
		}
		
		$this->getSessionStorage()->offsetSet('slideshow_id', $id);
		
		return array('slideshow' => $slideshow);        
	}
	
	public function addImageInfoAction()
    {
    	if ($this->getRequest()->isPost()) {
    		$values = $this->getRequest()->getPost();
    		
    		$data = array();
    		$data['title'] =  $values['title'];
    		$data['discription'] =  $values['desc'];
    		$data['link'] =  $values['link'];
    		$data['linktext'] =  $values['linktext'];
    		
    		$this->getSlideshowImageModel()->updateImage($values['image_id'], $data);
			
    		echo "success";
    	}
    	die;
    }
	
	public function guidelinesAction() {
    	if ($_GET["slideshow_type"]) {
    		if("default" == $_GET["slideshow_type"]) {
    			exit;
    		}
    		if ("nivoslider" == $_GET["slideshow_type"]) {
				$slideshow_name = "Nivo Slider";
				$preview = "/modules/slideshow/images/nivoslider.jpg";
				$description = "short description for \"Nivo\" slider";
				$min_dimension = "";
				$max_dimension = "";
				$slide_type = "";
    		};

    		if ("jqfancytransitions" == $_GET["slideshow_type"]) {
				$slideshow_name = "jQuery Fancy Transitions";
				$preview = "/modules/slideshow/images/jqfancytransitions.jpg";
				$description = "short description for \"jQuery Fancy Transitions\" slider";
				$min_dimension = "";
				$max_dimension = "";
				$slide_type = "";
    		};

    		if ("jcarousellite" == $_GET["slideshow_type"]) {
				$slideshow_name = "jCarousel Line";
				$preview = "/modules/slideshow/images/jcarousellite.jpg";
				$description = "short description for \"jCarousel Line\" slider";
				$min_dimension = "";
				$max_dimension = "";
				$slide_type = "";
    		};

    		if ("FeaturedContentSlider" == $_GET["slideshow_type"]) {
				$slideshow_name = "Featured Content Slider";
				$preview = "/modules/slideshow/images/FeaturedContentSlider.jpg";
				$description = "short description for \"Featured Content\" slider";
				$min_dimension = "";
				$max_dimension = "";
				$slide_type = "";
    		};

    		if ("wideslider" == $_GET["slideshow_type"]) {
				$slideshow_name = "Wide Slider";
				$preview = "/modules/slideshow/images/wideslider.jpg";
				$description = "short description for \"Wide\" slider";
				$min_dimension = "";
				$max_dimension = "";
				$slide_type = "";
    		};

    		
    		if ("cycle" == $_GET["slideshow_type"]) {
    			$slideshow_name = "Cycle Slider";
    			$preview = "/modules/slideshow/images/cycle.jpg";
    			$description = "short description for \"cycle\" slider";
    			$min_dimension = "";
    			$max_dimension = "";
    			$slide_type = "";
    		};
    		
    		
    		if ("aviaslider" == $_GET["slideshow_type"]) {
    			$slideshow_name = "Avia Slider";
    			$preview = "/modules/slideshow/images/aviaslider.jpg";
    			$description = "short description for \"avia\" slider";
    			$min_dimension = "";
    			$max_dimension = "";
    			$slide_type = "";
    		};
    		    		
    		
    		if ("galleriffic" == $_GET["slideshow_type"]) {
				$slideshow_name = "Galleriffic Slider";
				$preview = "/modules/slideshow/images/galleriffic.jpg";
				$description = "Thumbnails will be given in the lefthand side and few controllers to control the slides. Can have the best view when configuration have 500 x 500 dimension to the slideshow and 75 x 75 dimension to the thumbnails";
				$min_dimension = "300 x 300";
				$max_dimension = "400 x 400";
				$thubnail_dimension = "75 x 75";
				$slide_type = "Image Only";
    		};

    		if ("EstroSlider" == $_GET["slideshow_type"]) {
				$slideshow_name = "Estro Slider";
				$preview = "/modules/slideshow/images/EstroSlider.jpg";
				$description = "description of the behaviour of this slider goes here";
				$min_dimension = "450 x 300";
				$max_dimension = "1200 x 800";	
				$thubnail_dimension = "240 x 160";
				$slide_type = "Image, Vedios";
    		};
    	}


    	$output = '<table>';
    	$output .= '<tr><th colspan="2">Slideshow Type Preview</th></tr>';
    	$output .= '<tr><td colspan="2"><img src="'.$preview.'" width="270px" height="150px" /></td></tr>';
    	$output .= '<tr><td colspan="2" >'.$slideshow_name.'</td></tr>';
    	$output .= '<tr><td colspan="2" align="justify">'.$description.'</td></tr>';
    	$output .= '<tr><td colspan="2">&nbsp;</td></tr>';
    	$output .= '<tr><td>Minimum Dimension :</td><td> '.$min_dimension.' </td></tr>';
    	$output .= '<tr><td>Maxiumu Dimension :</td><td> '.$max_dimension.' </td></tr>';
    	
    	if(isset($thubnail_dimension) && !empty($thubnail_dimension))
    		$output .= '<tr><td>Thumbnail Dimension :</td><td> '.$thubnail_dimension.' </td></tr>';
    	
    	$output .= '<tr><td>Slide Types -</td><td> '.$slide_type.' </td></tr>';
    	$output .= '</table>';

    	echo $output;
    	exit;
    }

	public function jsonSelectOptionsAction() {
    	$response["random"] = "Random";
    	if ($_GET["slideshow_script"]) {
    		if ("nivoslider" == $_GET["slideshow_script"]) {
    			$response["fold"] 			= "[Nivo slider] Fold";
    			$response["fade"] 			= "[Nivo slider] Fade";
    			$response["sliceDown"] 		= "[Nivo slider] Slice Down";
    			$response["sliceUp"] 		= "[Nivo slider] Slice Up";
    			$response["sliceDownLeft"] 	= "[Nivo slider] Slice Down Left";
    			$response["sliceUpLeft"] 	= "[Nivo slider] Slice Up Left";
    			$response["sliceUpDown"] 	= "[Nivo slider] Slice Up Down";
    			$response["sliceUpDownLeft"] = "[Nivo slider] Slice Up Down Left";
    		};

    		if ("jqfancytransitions" == $_GET["slideshow_script"]) {
    			$response["wave"]  			= "[JqFancy] Wave";
    			$response["zipper"]  		= "[JqFancy] Zipper";
    			$response["curtain"] 		= "[JqFancy] Curtain";
    		};

    		if ("jcarousellite" == $_GET["slideshow_script"]) {
    			$response["jCarouselLite"]  = "[jCarouselLite] Default";
    		};

    		if ("FeaturedContentSlider" == $_GET["slideshow_script"]) {
    			$response["featuredcontentslider"]  = "[FeaturedContentSlider] Default";
    		};
			
    		
    		if ("cycle" == $_GET["slideshow_script"]) {
    			$response["growX"]			= "[cycle] growX";
    			$response['scrollUp']	 	= '[cycle] scrollUp';
    			$response['scrollDown'] 	= '[cycle] scrollDown';
    			$response['scrollLeft'] 	= '[cycle] scrollLeft';
    			$response['scrollRight']	= '[cycle] scrollRight';
    			$response['scrollHorz'] 	= '[cycle] scrollHorz';
    			$response['scrollVert'] 	= '[cycle] scrollVert';
    			$response['shuffle']	 	= '[cycle] shuffle';
    			$response['slideX']	 		= '[cycle] slideX';
    			$response['slideY']	 		= '[cycle] slideY';
    			$response['toss']		 	= '[cycle] toss';
    			$response['turnUp']	 		= '[cycle] turnUp';
    			$response['turnDown']	 	= '[cycle] turnDown';
    			$response['turnLeft']	 	= '[cycle] turnLeft';
    			$response['turnRight']	 	= '[cycle] turnRight';
    			$response['uncover']	 	= '[cycle] uncover';
    		};
			
    		
    		if ("aviaslider" == $_GET["slideshow_script"]) {
    			$response['slide']			= '[Avia Slider] slide';
    			$response['fade']		= '[Avia Slider] fade';
    			$response['drop']			= '[Avia Slider] drop';    			 
    		};
    		
    		if ("wideslider" == $_GET["slideshow_script"]) {
    			$response["wideslider"]  	= "[Wide Slider] Default";
    		};

    		if ("galleriffic" == $_GET["slideshow_script"]) {
    			$response["galleriffic"]  	= "[Galleriffic] Default";
    		};

    		if ("EstroSlider" == $_GET["slideshow_script"]) {
    			$response["estroslider"]  	= "[EstroSlider] Default";
    		};
    	}
    	print json_encode($response);
    	exit;
    }

	public function addSlideshowImagesAction() {
		$slideshowId = (int)$this->getRequest()->getPost('slideshow_id');
    	
		if (!$slideshowId && $this->getSessionStorage()->offsetExists('slideshow_id')) {
        	$slideshowId = (int)$this->getSessionStorage()->offsetGet('slideshow_id');
        }
		
        if(!$slideshowId)
        {
            throw new \Exception("Empty slideshow ID");
        }
        
        $options = array(
            'script_url' => '/admin/modules/slideshow/add-slideshow-images',
            'upload_dir' => UPLOADS_PATH . '/slideshow/slideshow-' . $slideshowId . '/originals/',
            'upload_url' => '/uploads/slideshow/slideshow-' . $slideshowId . '/originals/',
            'param_name' => 'files',
            'delete_type' => 'DELETE',
            'max_file_size' => null,
            'min_file_size' => 1,
            'accept_file_types' => '/.+$/i',
            'max_number_of_files' => null,
            'discard_aborted_uploads' => true,
            'orient_image' => false,
            'image_versions' => array(
                'thumbnail' => array(
                    'upload_dir' => UPLOADS_PATH . '/slideshow/slideshow-' . $slideshowId . '/thumb/',
                    'upload_url' => '/uploads/slideshow/slideshow-' . $slideshowId . '/thumb/',
                    'max_width' => 150,
                    'max_height' => 84
                )
            )
        );
        if (!is_dir($options['upload_dir'])) {
            mkdir($options['upload_dir'], $mode = 0777, $recursive = true);
        }
        if (!is_dir($options['image_versions']['thumbnail']['upload_dir'])) {
            mkdir($options['image_versions']['thumbnail']['upload_dir'], $mode = 0777, $recursive = true);
        }
        
		$this->getUploadhandlerModel()->init($this->getSlideshowImageModel(), $slideshowId, $options);
		
		header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Content-Disposition: inline; filename="files.json"');
        header('X-Content-Type-Options: nosniff');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');
        
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $result = array();
                $images = $this->getSlideshowImageModel()->getImagesBySlideshowId($slideshowId);
				
                foreach ($images as $image) {
                	$filePath = UPLOADS_PATH . '/slideshow/slideshow-' . $slideshowId . '/thumb/' . $image['thumb_path'];
                    $originalPath = UPLOADS_PATH . '/slideshow/slideshow-' . $slideshowId . '/originals/' . $image['image_path'];
					
                    if (!file_exists($filePath) || !file_exists($originalPath)) {
                        continue;
                    }
    				$row = new \stdClass();
                    $row->id = $image['image_id'];
                    $row->name = $image['image_path'];
                    $row->path = $image['image_path'];
                    $row->size = filesize($filePath);
                    $row->url = '/uploads/slideshow/slideshow-' . $slideshowId . '/originals/' . $image['image_path'];
                    $row->thumbnail_url = '/uploads/slideshow/slideshow-' . $slideshowId . '/thumb/' . $image['thumb_path'];
                    $this->getUploadhandlerModel()->set_file_delete_url($row);

                    $imageSize = getimagesize($originalPath);
                    $row->width = $imageSize[0];
                    $row->height = $imageSize[1];
                    
                    $row->title = $image['title'];
                    $row->desc =  $image['discription'];
                    $row->link =  $image['link'];
                    $row->linktext =  $image['linktext'];
                   
					$result[] = $row;
                }
                echo json_encode(array('files' => $result));
                break;
                
            case 'POST':
				if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
                    $this->getUploadhandlerModel()->delete();
                } else {
                    $this->getUploadhandlerModel()->post();
                }
                break;
            case 'DELETE':
				$this->getUploadhandlerModel()->delete();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }
        exit;
    }
	
	protected function getSlideshowModel() {
    	if(!$this->slideshowModel) {
    		$this->slideshowModel = $this->getServiceLocator()->get('Admin\Model\SlideshowModel');
    	}
    	return $this->slideshowModel;
    }

	protected function getBlockModel() {
		if(!$this->blockModel) {
    		$this->blockModel = $this->getServiceLocator()->get('Admin\Model\BlockModel');
    	}
    	return $this->blockModel;
    }
	
	protected function getUploadhandlerModel() {
		if(!$this->uploadhandlerModel) {
    		$this->uploadhandlerModel = $this->getServiceLocator()->get('Admin\Model\UploadhandlerModel');
    	}
    	return $this->uploadhandlerModel;
    }
    
	protected function getSlideshowImageModel() {
		if(!$this->slideshowImageModel) {
    		$this->slideshowImageModel = $this->getServiceLocator()->get('Admin\Model\SlideshowImageModel');
    	}
    	return $this->slideshowImageModel;
    }
	
	protected function getSessionStorage() {
        if(!$this->sessionStorage) {
            $this->sessionStorage = $this->getServiceLocator()->get('Admin\SessionStorage');
        }
        return $this->sessionStorage;
    }
}
