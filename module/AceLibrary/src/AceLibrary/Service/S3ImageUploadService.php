<?php
namespace AceLibrary\Service;

use Aws\S3\Model\MultipartUpload\UploadBuilder;
use Aws\S3\S3Client;

class S3ImageUploadService extends AceService
{
    const S3BUCKET = "images.bookaccommodationonline.com.au";
    
    public $s3;

    public function __construct()
    {
        
        $this->s3 = S3Client::factory(array(
                'key'    => 'AKIAJFC4774TM6TEFO7A',
                'secret' => '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'
            ));    
    
    }
    
    public function imageUpload($file, $dir) {
    	// Prepare the upload parameters.
        $uploader = UploadBuilder::newInstance()
            ->setClient($this->s3)
            ->setSource($file['tmp_name'])
            ->setBucket(self::S3BUCKET)
            ->setKey($dir . $file['name'])
            ->setOption('ACL', 'public-read')
			->setOption('ContentType', $file['type'])
			->setConcurrency(10)
			//->setOption('CacheControl', 'max-age=3600')
			->build();

        // Perform the upload. Abort the upload if something goes wrong.
        try {
            $uploader->upload();
			/*$this->s3->waitUntilObjectExists(array(
			    'Bucket' => self::S3BUCKET,
			    'Key'    => $dir . $file['name']
			));*/
            return true;
        } catch (MultipartUploadException $e) {
            $uploader->abort();
            return false;
        }
    }
    
    public function checkFileExist($file, $dir){
        return $this->s3->doesObjectExist(self::S3BUCKET, $dir.$file);
    }
    
    public function getFileUrl($file, $dir){
        return $this->s3->getObjectUrl(self::S3BUCKET, $dir.$file);
    }
}