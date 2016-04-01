<?php 
namespace Service;
use JohnLui\AliyunOSS\AliyunOSS;
use Common\Config;
/**
 * 阿里云oss服务
 * @author fengshuang
 *
 */
class OssService{
	private $ossClient;//阿里云oss实例
	
	private function __construct($isInternal = false){
		$this->isInternal = $isInternal;
		$config = Config::getOss();
		$address =$isInternal ? $config['ServerInternal'] :$config['Server']; 
		$this->ossClient =  AliyunOSS::boot(
      			$address,
     			$config['AccessKeyId'],
      			$config['AccessKeySecret']
			);
	}
	
	public static function upload($ossKey, $filePath){
		$oss = new OssService(true); // 上传文件使用内网，免流量费
		$oss->ossClient->setBucket('yishuodian-test');
		$oss->ossClient->uploadFile($ossKey, $filePath);
	}
	/**
	 * 直接把变量内容上传到oss
	 * @param $osskey
	 * @param $content
	 */
	public static function uploadContent($osskey,$content){
		$oss = new OssService(true); // 上传文件使用内网，免流量费
		$oss->ossClient->setBucket('yishuodian-test');
		$oss->ossClient->uploadContent($osskey,$content);
	}
	/**
	 * 删除存储在oss中的文件
	 *
	 * @param string $ossKey 存储的key（文件路径和文件名）
	 * @return
	 */
	public static function deleteObject($ossKey){
		$oss = new OssService(true); // 上传文件使用内网，免流量费
		return $oss->ossClient->deleteObject('your-bucket-name', $ossKey);
	}
	/**
	 * 复制存储在阿里云OSS中的Object
	 *
	 * @param string $sourceBuckt 复制的源Bucket
	 * @param string $sourceKey - 复制的的源Object的Key
	 * @param string $destBucket - 复制的目的Bucket
	 * @param string $destKey - 复制的目的Object的Key
	 * @return Models\CopyObjectResult
	 */
	public static function copyObject($sourceBuckt, $sourceKey, $destBucket, $destKey){
		$oss = new OssService(true); // 上传文件使用内网，免流量费
		return $oss->ossClient->copyObject('your-source-bucket-name', $sourceKey, 'your-dest-bucket-name', $destKey);
	}
	/**
	 * 移动存储在阿里云OSS中的Object
	 *
	 * @param string $sourceBuckt 复制的源Bucket
	 * @param string $sourceKey - 复制的的源Object的Key
	 * @param string $destBucket - 复制的目的Bucket
	 * @param string $destKey - 复制的目的Object的Key
	 * @return Models\CopyObjectResult
	 */
	public static function moveObject($sourceBuckt, $sourceKey, $destBucket, $destKey){
		$oss = new OssService(true); // 上传文件使用内网，免流量费
		return $oss->ossClient->moveObject('your-source-bucket-name', $sourceKey, 'your-dest-bucket-name', $destKey);
	}
	
	public static function getUrl($ossKey){
		$oss = new OssService();
		$oss->ossClient->setBucket('yishuodian-test');
		return $oss->ossClient->getUrl($ossKey, new \DateTime("+1 day"));
	}
	
	public static function createBucket($bucketName){
		$oss = new OssService();
		return $oss->ossClient->createBucket($bucketName);
	}
	
	public static function getAllObjectKey($bucketName){
		$oss = new OssService();
		return $oss->ossClient->getAllObjectKey($bucketName);
	}
	
	
	
	
	
}
?>