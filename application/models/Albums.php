<?php

class Model_Albums extends Zend_Db_Table_Abstract
{

    protected $_name = 'albums';

	public function getAlbum($id)
	{
		$id = (int)$id;
		$row = $this->fetchRow('id = ' . $id);
		
		if (!$row) {
			throw new Exception("Could not find row $id");
		}
		
		return $row->toArray();
	}

	public function addAlbum($dataArray)
	{
		//print_r($dataArray); exit;
		//$dataArray
		// $data = array(
		// 		'artist' => $artist,
		// 		'title' => $title,
		// );
		
		$this->insert($dataArray);
	}
	
	public function updateAlbum($id, $artist, $title)
	{
		$data = array(
			'artist' => $artist,
			'title' => $title,
		);
		$updateId= 'id = '. (int) $id;
		$this->update($data, $updateId);
		
	}
	
	public function deleteAlbum($id)
	{
		$this->delete('id =' . (int)$id);
	}
}


