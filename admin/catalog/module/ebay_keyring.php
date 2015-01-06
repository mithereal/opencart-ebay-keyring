<?php

class ControllerModuleEbayKeyring extends Controller {
	private $error = array(); 
        
	public function install()
	{  
		 $this->db->query("
		 CREATE TABLE IF NOT EXISTS ". DB_PREFIX ."ebay_keyring (
  `key_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) DEFAULT NULL,
  `title` varchar(120) COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `DEVID` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `AppID` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `CertID` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `RuName` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `ebay_session_id` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `key_type` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`key_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
");

        }
        
	public function uninstall()
	{  
		$this->db->query("
	    DROP TABLE ". DB_PREFIX ."ebay_keyring ");

	}
	
public	function index() {
		$this->load->language('module/ebay_keyring');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		$this->load->model('ebay/keyring');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('ebay', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['entry_site_id'] = $this->language->get('entry_site_id');
		$this->data['entry_app_mode'] = $this->language->get('entry_app_mode');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_domain_name'] = $this->language->get('entry_domain_name');
		$this->data['entry_title'] = $this->language->get('entry_title');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
				
				
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/ebaykeyring', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('module/ebay_keyring', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['ebay_time_url'] = $this->url->link('module/ebay/gettime', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['ebay_api_url'] = $this->url->link('module/ebay/download_api', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['ebay_auth_url'] = $this->url->link('module/ebay/authorize', 'token=' . $this->session->data['token'], 'SSL');		
		$this->data['ebay_fetchtoken_url'] = $this->url->link('module/ebay/fetchtoken', 'token=' . $this->session->data['token'], 'SSL');		
	
		$this->data['token'] = $this->session->data['token'];

					
		if (isset($this->request->post['ebay_site_id'])) {
			$this->data['ebay_site_id'] = $this->request->post['ebay_site_id'];
		} else {
			$this->data['ebay_site_id'] = $this->config->get('ebay_site_id');
		}

		if (isset($this->request->post['ebay_app_mode'])) {
			$this->data['ebay_app_mode'] = $this->request->post['ebay_app_mode'];
		} else {
			$this->data['ebay_app_mode'] = $this->config->get('ebay_app_mode');
		}
			
		

		if (isset($this->request->post['ebay_status'])) {
			$this->data['ebay_status'] = $this->request->post['ebay_status'];
		} else {
			$this->data['ebay_status'] = $this->config->get('ebay_status');
		}
		
		$this->data['addkey'] = $this->url->link('module/ebay_keyring/addkey', 'token=' . $this->session->data['token'], 'SSL');

	
	$keys = $this->model_ebay_keyring->getKeyrings();
	
	$this->data['keys'] =$keys;

		$this->template = 'module/ebay_keyring.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function authorize()
	{
        $this->load->model('setting/setting');
        $this->load->model('ebay/keymanager');
        
        $key_type = "production";
	$trade_url = 'https://api.ebay.com/ws/api.dll';
	$sigin_url = 'https://signin.ebay.com/ws/eBayISAPI.dll?SignIn';
	
	if ( $this->request->get['ebay_app_mode'] == 1 ){
		$key_type = "sandbox";
		$trade_url = 'https://api.sandbox.ebay.com/ws/api.dll';
		$sigin_url = 'https://signin.sandbox.ebay.com/ws/eBayISAPI.dll?SignIn';
	}
		
		$group = 'ebay_keyring';
		$store_id  =  $this->config->get('config_store_id');
		$settings = $this->model_setting_setting->getSetting($group, $store_id);
		
        if (isset($this->request->get['ebay_keyring_id'])) {
			$ebay_keyring_id = $this->request->get['ebay_keyring_id'];
		} else {
			$ebay_keyring_id = $settings['ebay_default_keyring_id'];
		}
		
	$keys = $this->model_ebay_keyring->getkeys($ebay_keyring_id);
        
	$devid = (string) $keys->devid;
	//echo "Dev Id ->" . $devid ;
	$appid = (string) $keys->appid;
	//echo "App Id ->" . $appid ;
	$certid = (string) $keys->certid;
	//echo "Cert Id ->" . $certid ;
	$RuName = (string) $keys->RuName;
	
	$call = 'GetSessionID';
	$body = "\n  <RuName>" . $RuName. "</RuName>\n";
	$field = 'SessionID';

	$theData =  "<?xml version='1.0' encoding='utf-8'?>" . "<{$call} xmlns='urn:ebay:apis:eBLBaseComponents'>{$body}</{$call}>";
	$headers = array (
			"Content-type: application/xml",
			"Accept: application/xml",
			//Regulates versioning of the XML interface for the API
			'X-EBAY-API-COMPATIBILITY-LEVEL: ' . '689',
			
			//set the keys
			'X-EBAY-API-DEV-NAME: ' . $devid,
			'X-EBAY-API-APP-NAME: ' . $appid,
			'X-EBAY-API-CERT-NAME: ' . $certid,
			
			//the name of the call we are requesting
			'X-EBAY-API-CALL-NAME: ' . 'GetSessionID',			
			
			//SiteID must also be set in the Request's XML
			//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
			//SiteID Indicates the eBay site to associate the call with
			'X-EBAY-API-SITEID: ' . '0'
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$trade_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $theData);

		//print_r($ch);
		$response = curl_exec($ch);
	// found open tag?
	 if (($begin = strpos($response, "<{$field}>")) !== FALSE)
	 {
	 // skip open tag
	 $begin += strlen($field) + 2;

	 // found close tag?
		 if (($end = strpos($response, "</{$field}>", $begin)) !== FALSE)
		 {
			$session_id =  substr($response, $begin, $end - $begin);
			//Store session id in settings table
			$data = array(
				'ebay_session_id'  => $session_id
			);
			
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('ebay', $data);
			
			//echo 'Session Id : ' . $session_id . '<br>';
			$url = $sigin_url . "&RuName=" . $RuName . "&SessID=" . $session_id;

			//echo "Redirecting Now to URL: " . $url ;
			$this->redirect($url);
		 }
	}
	 echo "<h1>Failed to retrieve Session Id from Ebay. Please retry later...</h1>";	
     //return "Field <b>{$field}</b> not found in eBay response!<p/>\n\n{$response}");
}
	
	public function fetchtoken()
	{
	$this->load->model('ebay/keyring');
	$key_type = "production";
	$trade = 'https://api.ebay.com/ws/api.dll';

	
	if ( $this->request->get['ebay_app_mode'] == 1 ){
		$key_type = "sandbox";
		$trade = 'https://api.sandbox.ebay.com/ws/api.dll';
	}else{
		$key_type = "production";
	}
		
		$group = 'ebay_keyring';
		$store_id  =  $this->config->get('config_store_id');
		$settings = $this->model_setting_setting->getSetting($group, $store_id);
		
        if (isset($this->request->get['ebay_keyring_id'])) {
			$ebay_keyring_id = $this->request->get['ebay_keyring_id'];
		} else {
			$ebay_keyring_id = $settings['ebay_default_keyring_id'];
		}
		
	$keys = $this->model_ebay_keyring->getkeys($ebay_keyring_id);
        
	$devid = (string) $keys->devid;
	//echo "Dev Id ->" . $devid ;
	$appid = (string) $keys->appid;
	//echo "App Id ->" . $appid ;
	$certid = (string) $keys->certid;
	//echo "Cert Id ->" . $certid ;
	$RuName = (string) $keys->RuName;
	$session_id = (string) $keys->ebay_session_id;
	
	if ( !isset($session_id)){
		echo "Please authorize application before fecthing token.";
		return;
	}
	
	$call = 'FetchToken';
	$body = "\n  <SessionID>" . $session_id . "</SessionID>\n";
	$field = 'eBayAuthToken';

	$theData =  "<?xml version='1.0' encoding='utf-8'?>" . "<{$call} xmlns='urn:ebay:apis:eBLBaseComponents'>{$body}</{$call}>";
	$headers = array (
			"Content-type: application/xml",
			"Accept: application/xml",
			//Regulates versioning of the XML interface for the API
			'X-EBAY-API-COMPATIBILITY-LEVEL: ' . '689',
			
			//set the keys
			'X-EBAY-API-DEV-NAME: ' . $devid,
			'X-EBAY-API-APP-NAME: ' . $appid,
			'X-EBAY-API-CERT-NAME: ' . $certid,
			
			//the name of the call we are requesting
			'X-EBAY-API-CALL-NAME: ' . $call ,			
			
			//SiteID must also be set in the Request's XML
			//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
			//SiteID Indicates the eBay site to associate the call with
			'X-EBAY-API-SITEID: ' . '0',
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$trade);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $theData);
		
		$response = curl_exec($ch);

	 // found open tag?
	 if (($begin = strpos($response, "<{$field}>")) !== FALSE)
	 {
	 // skip open tag
	 $begin += strlen($field) + 2;

	 // found close tag?
		 if (($end = strpos($response, "</{$field}>", $begin)) !== FALSE)
		 {
			$ebayToken=  substr($response, $begin, $end - $begin);
			 
			//Store token in keyring 
			$keys['ebay_token'] = $ebayToken;
			$keys['store_id'] = $store_id;

			$keys = $this->model_ebay_keyring->editkeys($keys);
			
			echo "Token retrieved successfully";
			return;
		 }
	}else{
		$this->log->write("Call Failed : " . $response);	
		echo "Failed to Fetch Token.Please re-authorize extension and try fetching token again.";
		return;
	}
}
	private function validate() {

		if (!$this->user->hasPermission('modify', 'module/ebay_keyring')) {

			$this->error['warning'] = $this->language->get('error_permission');

		}			
		
		if (!$this->error) {

			return true;

		} else {

			return false;

		}
	}

	private function https($route) {
		if (HTTPS_SERVER != '') {
			$link = HTTPS_SERVER . 'index.php?route=' . str_replace('&', '&amp;', $route.'&token=' . $this->session->data['token']);
		} else {
			$link = HTTP_SERVER . 'index.php?route=' . str_replace('&', '&amp;', $route.'&token=' . $this->session->data['token']);
		}

		return $link;
	}

	private function startsWith( $haystack, $needle ) {
		if (strlen( $haystack ) < strlen( $needle )) {
			return FALSE;
		}
		return (substr( $haystack, 0, strlen($needle) ) == $needle);
	}

	public function download_api(){
	
	
	if ( $this->config->get('config_error_display') > 0 || $this->config->get('config_error_log') > 0 ){

		echo "<b>Modify Display and Log Errors Server Settings:</b><br>Please navigate to system settings menu.<br> Click edit action for the store.<br> On Server tab set Display Errors and Log Errors to No";
		return;

	}
	
		$this->load->language('module/ebaykeyring');
		$dest_filename = 'ebatNs.zip';

		$url  = $this->language->get('url_download_api');
		mkdir(DIR_SYSTEM . 'library/'.'ebatNs', 0777,true);
		$path = DIR_SYSTEM . 'library/' . 'ebatNs/' . $dest_filename;
		$unzip_path = DIR_SYSTEM . 'library/'.'ebatNs/';

		if (!$fp = fopen($path, 'w')){
             echo "File not opened<br>";
			 return;
        }
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_FILE, $fp);

		$data = curl_exec($ch);
		curl_close($ch);
		fclose($fp);

		echo 'Download Complete....' . '<br>';

		$zip = zip_open($path);
		if (is_resource($zip)) {
		  while ($zip_entry = zip_read($zip)) {
			$fp = fopen( $unzip_path . zip_entry_name($zip_entry), "w");
			if (zip_entry_open($zip, $zip_entry, "r")) {
			  $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
			  fwrite($fp,"$buf");
			  zip_entry_close($zip_entry);
			  fclose($fp);
			}
		  }
		  zip_close($zip);
		}

		echo 'Api Installed...';
	}

	public function exists_ebatns(){
	$ebatns_file = DIR_SYSTEM . 'library/ebatNs/EbatNs_ServiceProxy.php';

	if ( file_exists( $ebatns_file ) ){
		return true;
	}else{
		return false;
		}
	}
	
	public function gettime(){

	if ( !$this->exists_ebatns() ) {
		echo "<b>ebatNs api is Missing.</b><br>Refer to documentation on installing ebatNs Api";
		return;
	}

	if ( $this->config->get('config_error_display') > 0 || $this->config->get('config_error_log') > 0 ){

		echo "<b>Modify Display and Log Errors Server Settings:</b><br>Please navigate to system settings menu.<br> Click edit action for the store.<br> On Server tab set Display Errors and Log Errors to No";
		return;

	}

		require_once(DIR_SYSTEM . 'library/ebatNs/EbatNs_ServiceProxy.php');
		require_once(DIR_SYSTEM . 'library/ebatNs/EbatNs_Logger.php');
		require_once(DIR_SYSTEM . 'library/ebatNs/GeteBayOfficialTimeRequestType.php');
		require_once(DIR_SYSTEM . 'library/ebatNs/GeteBayOfficialTimeResponseType.php');

		$returnString = "EBAY request failed";
		//todo fetch tokens from db
		$this->load->model('ebay/keymanager');		
		$this->load->model('setting/setting');		
		
		$group = 'ebay_keyring';
		$store_id  =  $this->config->get('config_store_id');
		$settings = $this->model_setting_setting->getSetting($group, $store_id);
		
        if (isset($this->request->get['ebay_keyring_id'])) {
			$ebay_keyring_id = $this->request->get['ebay_keyring_id'];
		} else {
			$ebay_keyring_id = $settings['ebay_default_keyring_id'];
		}
		
		$keys = $this->model_ebay_keyring->getkeys($ebay_keyring_id);
	
		$ebay_app_mode = $this->request->get['ebay_app_mode'];
		$ebay_site_id = $this->request->get['ebay_site_id'];

		$session = new EbatNs_Session();
		$session->setAppMode($ebay_app_mode);
		$session->setSiteId($ebay_site_id);
		$session->setTokenMode(true);
		$session->setRequestToken($keys->token);

		$cs = new EbatNs_ServiceProxy($session);
		$req = new GeteBayOfficialTimeRequestType();
		$res = $cs-> GeteBayOfficialTime($req);
			if ($res->getAck() != $Facet_AckCodeType->Success)
			{
				$returnString = "EBAY Time request failed";
				//$returnString = $token ;
			}else{
				$returnString = "EBAY Time: " . $res->Timestamp;
			}
			echo $returnString;

	}

 //todo make delete a keyring group
	public function delete() {
    	$this->load->language('module/ebaykeyring');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('ebay/keyring');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $key_id) {
				$this->model_ebay_auction->deleteKeyring($key_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success_delete');

			$this->redirect(HTTPS_SERVER . 'index.php?route=module/ebay_keyring/index&token=' . $this->session->data['token']);
		
  	}
}
  	 //todo copy a keyring group
	public function copy() {
    	$this->load->language('module/ebaykeyring');

		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('ebay/ebaykeyring');
//var_dump($this->request->post);
		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $key_id) {
				//var_dump($auction_id);
				$this->model_ebay_auction->copyKeyring($key_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success_delete');
				$url .= '&order=' . $this->request->get['order'];
			}

			$this->redirect(HTTPS_SERVER . 'index.php?route=module/ebay_keyring/index&token=' . $this->session->data['token']);
		
  	}

	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'module/ebaykeyring')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}


    	if (!$this->error) {
			return TRUE;
    	} else {
			if (!isset($this->error['warning'])) {
				$this->error['warning'] = $this->language->get('error_required_data');
			}
      		return FALSE;
    	}
  	}

	public function addkey(){
		$this->load->language('module/ebay_keyring');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		$this->load->model('ebay/keyring');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_ebay_keyring->addKeyring($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');
			$this->redirect($this->url->link('extension/module/ebay_keyring', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['entry_site_id'] = $this->language->get('entry_site_id');
		$this->data['entry_app_mode'] = $this->language->get('entry_app_mode');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_domain_name'] = $this->language->get('entry_domain_name');
		$this->data['entry_title'] = $this->language->get('entry_title');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
				
				
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/ebaykeyring', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('module/ebay_keyring/addkey', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['token'] = $this->session->data['token'];


		if (isset($this->request->post['ebay_status'])) {
			$this->data['ebay_status'] = $this->request->post['ebay_status'];
		} else {
			$this->data['ebay_status'] = $this->config->get('ebay_status');
		}


		$this->template = 'module/ebay_keyring_addkey.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
	
	
	
}

