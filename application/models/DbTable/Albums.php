<?php

class Application_Model_DbTable_Albums extends Zend_Db_Table_Abstract
{
	protected $_name = 'albums';

	public function getAlbum($id)
	{
		$id = (int)$id;

		if (!$id) {
			throw new Exception("Invalid id: $id");
		} else {
			$row = $this->fetchRow('id = ' . $id);		
			if (!$row) {
				throw new Exception("Could not find row $id");
			}
		}		
		
		return $row->toArray();
	}

	//public function addAlbum($artist, $title)
	public function addAlbum($dataArray)
	{
		$this->insert($dataArray);
	}
	
	//public function updateAlbum($id, $artist, $title)
	public function updateAlbum($id, $dataArray)
	{
		// $data = array(
		// 	'artist' => $artist,
		// 	'title' => $title,
		// );
		$updateId= 'id = '. (int) $id;
		if (!$updateId) {
			throw new Exception("Invalid id: $id");
		} else {
			$updateStatus = $this->update($dataArray, $updateId);
			
			if (!$updateStatus) {
				throw new Exception("Could not update the database.");
			}
		}	
		
	}
	
	public function deleteAlbum($id)
	{
		if (!$id) {
			throw new Exception("Invalid id: $id");
		} else {
			$deleteStatus = $this->delete('id =' . (int)$id);			
			if (!$deleteStatus) {
				throw new Exception("Could not delete data.");
			}
		}

		
	}
}


