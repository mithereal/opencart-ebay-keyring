<?php

class ModelEbayKeyring extends Model {
	
	public function addKeyring($data) {
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "ebay_keyring` SET title = '" . $this->db->escape($data['title']) .  "'");
			
		$keyring_id = $this->db->getLastId();
		
		if (isset($data['description'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET description = '" . (int)$this->db->escape($data['description']) . "' WHERE key_id = '" . (int)$keyring_id . "'");
		}
		if (isset($data['DEVID'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET DEVID = '" . (int)$this->db->escape($data['DEVID']) . "' WHERE key_id = '" . (int)$keyring_id . "'");
		}
		if (isset($data['AppID'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET AppID = '" . (int)$this->db->escape($data['AppID']) . "' WHERE key_id = '" . (int)$keyring_id . "'");
		}
		if (isset($data['CertID'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET CertID = '" . (int)$this->db->escape($data['CertID']) . "' WHERE key_id = '" . (int)$keyring_id . "'");
		}
		if (isset($data['RuName'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET RuName = '" . (int)$this->db->escape($data['RuName']) . "' WHERE key_id = '" . (int)$keyring_id . "'");
		}
		if (isset($data['store_id'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET store_id = '" . (int)$this->db->escape($data['store_id']) . "' WHERE key_id = '" . (int)$keyring_id . "'");
		}
		if (isset($data['ebay_session_id'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET ebay_session_id = '" . (int)$this->db->escape($data['ebay_session_id']) . "' WHERE key_id = '" . (int)$keyring_id . "'");
		}
		if (isset($data['key_type'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET key_type = '" . (int)$this->db->escape($data['key_type']) . "' WHERE key_id = '" . (int)$keyring_id . "'");
		}
		if (isset($data['token'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET token = '" . (int)$this->db->escape($data['token']) . "' WHERE key_id = '" . (int)$keyring_id . "'");
		}

	}
	
	public function editkeys($data) {
		
		if (isset($data['title'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET title = '" . $this->db->escape($data['title']) . "' WHERE store_id = '" . (int)$data['store_id'] . "'");
		}
		
		if (isset($data['description'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET description = '" . $this->db->escape($data['description']) . "' WHERE store_id = '" . (int)$data['store_id'] . "'");
		}

		if (isset($data['DEVID'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET DEVID = '" . $this->db->escape($data['DEVID']) . "' WHERE store_id = '" . (int)$data['store_id'] . "'");
		}		
		 
		if (isset($data['AppID'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET AppID = '" . $this->db->escape($data['AppID']) . "' WHERE store_id = '" . (int)$data['store_id'] . "'");
		}	
		
		if (isset($data['CertID'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET CertID = '" . (int)$this->db->escape($data['CertID']) . "' WHERE store_id = '" . (int)$data['store_id'] . "'");
		}	
		if (isset($data['RuName'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET RuName = '" . (int)$this->db->escape($data['RuName']) . "' WHERE store_id = '" . (int)$data['store_id'] . "'");
		}	
		
		if (isset($data['ebay_session_id'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET ebay_session_id = '" . $this->db->escape($data['ebay_session_id']) . "' WHERE store_id = '" . (int)$data['store_id'] . "'");
		}	
		
		if (isset($data['key_type'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET key_type = '" . $this->db->escape($data['key_type']) . "' WHERE store_id = '" . (int)$data['store_id'] . "'");
		}	
		
		if (isset($data['token'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_keyring SET token = '" . (float)$this->db->escape($data['token']) . "' WHERE store_id = '" . (int)$data['store_id'] . "'");
		}	

	}

	public function deleteKeyring($key) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "ebay_keyring WHERE key_id = '" . (int)$key . "'");
		$this->cache->delete('ebay_keyring');
	}
	public function getKeyrings($data = array()){

		$sql ="SELECT * FROM " . DB_PREFIX . "ebay_keyring";
		
		$sort_data = array(
		'key_id',
		'store_id',
		'title'
		);	
		
		
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY key_id";	
		}


		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			
			
			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}	
	
	public function getTotalKeyrings($data = array()) {
		$sql = "SELECT COUNT(DISTINCT k.key_id) AS total FROM " . DB_PREFIX . "ebay_keyring k";
		
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	
	public function getKeyring($id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "ebay_keyring` WHERE key_id = '" . (int)$id . "'");
	
		return $query->row;
	}
	

	public function copyKeyring($key_id) {
		
	
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "ebay_keyring k WHERE k.key_id = '" . (int)$key_id . "' ");
		
		if ($query->num_rows) {
			$data = array();
			
			$data = $query->row;
			$data['key_id'] =null;
			$data['store_id'] =$data['store_id'];
			$data['title'] =$data['title'];
			$data['description'] =$data['description'];
			$data['DEVID'] =$data['DEVID'];
			$data['AppID'] =$data['AppID'];
			$data['CertID'] =$data['CertID'];
			$data['RuName'] =$data['RuName'];
			$data['ebay_session_id'] =$data['ebay_session_id'];
			$data['key_type'] =$data['key_type'];
			$data['token'] =$data['token'];
			
			$this->addKeyring($data);	
			
		}
		$this->cache->delete('ebay_keyring');
	}

	
}
?>
