<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

  /**
  * Curlme
  *
  * Library untuk mendapatkan/memposting.
  *
  * @package    CodeIgniter
  * @subpackage libraries
  * @category   library
  * @version    0.2
  * @author     Mustopa Amin <mustopaamin@ymail.com>
  * @date		04-12-2015
  */

class Curlme {

   	/**
   	* Default options for every request
   	* @static
   	*/
	public static $curlOptions = array();	

	/**
	 * Send GET request
	 * @param string  $url
	 * @param mixed[] $data_hash
	 * output json or object(default) or real data
	 */	
	public static function getData($url,$params,$type = 'object')
	{
		
		$ch = curl_init();  
		
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false); 

		$postData = '';
		if($params)
		{
			//create name value pairs seperated by &
			foreach($params as $k => $v) 
			{ 
			  $postData .= $k . '='.str_replace(" ","%20",$v).'&'; 
			}
			$postData = rtrim($postData, '&');
		}
		curl_setopt($ch,CURLOPT_URL,$url.'?'.$postData);
		
		$output=curl_exec($ch);
		
		curl_close($ch);
		if($type == 'object')
		{
			return json_decode($output);
		}
		else
		{
			return $output;
		}
	}

	/**
	 * Send POST request
	 * @param string  $url
	 * @param mixed[] $data_hash
	 * output json or object(default) or real data
	 */	
	public static function postData($url,$params = array(),$type = 'object')
	{
		$ch = curl_init();  
		
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_HEADER, false); 

		if($params)
		{
			curl_setopt($ch, CURLOPT_POST,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);    
		}
		
		$output=curl_exec($ch);
		
		curl_close($ch);
		if($type == 'object')
		{
			return json_decode($output);
		}
		else
		{
			return $output;
		}
	}

	/**
	 * Send GET request
	 * @param string  $url
	 * @param mixed[] $data_hash
	 */
	public static function get($url, $data_hash, $type = 'object')
	{
	  return self::remoteCall($url, $data_hash, false, $type);
	}

	/**
	 * Send POST request
	 * @param string  $url
	 * @param mixed[] $data_hash
	 */
	public static function post($url, $data_hash, $type = 'object')
	{
	    return self::remoteCall($url, $data_hash, true, $type);
	}

  	/**
	 * Actually send request to API server
	 * @param string  $url
	 * @param mixed[] $data_hash
	 * @param bool    $post
	 * @param type    $type
	 */
	public static function remoteCall($url, $data_hash, $post = true, $type = 'object')
    {
	    $ch = curl_init();

	    $curl_options = array(
	      CURLOPT_URL => $url,
	      CURLOPT_HTTPHEADER => array(
	        'Content-Type: application/json',
	        'Accept: application/json',
	      ),
	      CURLOPT_RETURNTRANSFER => 1,
	    );

	    // merging with Veritrans_Config::$curlOptions
	    if (count(Curlme::$curlOptions)) {
	      // We need to combine headers manually, because it's array and it will no be merged
	      if (Curlme::$curlOptions[CURLOPT_HTTPHEADER]) {
	        $mergedHeders = array_merge($curl_options[CURLOPT_HTTPHEADER], Curlme::$curlOptions[CURLOPT_HTTPHEADER]);
	        $headerOptions = array( CURLOPT_HTTPHEADER => $mergedHeders );
	      } else {
	        $mergedHeders = array();
	      }

	      $curl_options = array_replace_recursive($curl_options, Curlme::$curlOptions, $headerOptions);
	    }

	    if ($post) {
	      $curl_options[CURLOPT_POST] = 1;

	      if ($data_hash) {
	        $body = json_encode($data_hash);
	        $curl_options[CURLOPT_POSTFIELDS] = $body;
	      } else {
	        $curl_options[CURLOPT_POSTFIELDS] = '';
	      }
	    }

	    curl_setopt_array($ch, $curl_options);
	    
	    $result = curl_exec($ch);
	    // curl_close($ch);

	    if ($result === FALSE) {
	      throw new Exception('CURL Error: ' . curl_error($ch), curl_errno($ch));
	    }
	    else {
			if($type == 'object')
			{
		      $result_array = json_decode($result);
			}
			else
			{
				$result_array = $result;
			}
		  return $result_array;
	    }
	}

	function counter()
	{
		$ci =& get_instance();
		$ci->load->helper('file');
		$file= (dirname(__FILE__) . "/data_pengunjung.txt");
		$kunjungan=read_file($file);
		if($kunjungan != 500 )
		{
			$kunjungan  = $kunjungan + 1;
		}
		else
		{
			$kunjungan  = 1;
		}
		
		write_file($file, $kunjungan);
		
		if($kunjungan > 0 && $kunjungan < 10) {	$kunjungan = "00".$kunjungan;	}
		elseif($kunjungan > 9 && $kunjungan < 100) {	$kunjungan = "0".$kunjungan;	}
		else { $kunjungan = $kunjungan ; }
				
		return	$kunjungan;
	}

}
