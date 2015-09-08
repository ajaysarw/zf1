<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
	{
		// Add autoloader empty namespace
		$autoLoader = Zend_Loader_Autoloader::getInstance();
		
		$autoLoader->registerNamespace('CMS_');
		
		$resourceLoader = new Zend_Loader_Autoloader_Resource(array(
			'basePath' => APPLICATION_PATH,
				'namespace' => '',
				'resourceTypes' => array(
					'form' => array( 'path' => 'forms/', 'namespace' => 'Form_', ), 
					'model' => array( 'path' => 'models/', 'namespace' => 'Model_'),
				),
			));

		/*******************************   Multi ways to connect to DB  *******************************/
			#1. Constructor-Adapter
			#2. Factory pattern/method 
			#3. using Zend Config

			/**
			** using adapter/constructor using PDO 
			*  dependency : Zend_Db_Adapter_Pdo_Abstract
			*/

			$dbNorthwind = new Zend_Db_Adapter_Pdo_Mysql(array(
			    'host'     => '127.0.0.1',
			    'username' => 'root',
			    'password' => '12345678',
			    'dbname'   => 'northwind'
			));

			/*
			* 		Factory pattern (as an alternative) 
			*		Automatically load class Zend_Db_Adapter_Pdo_Mysql and create n instance of it.
			*		Adapter parameters must be in an array or a Zend_Config object
			*/
	 		
	 		$dbZfCms = Zend_Db::factory('Pdo_Mysql', array(
				'host' => '127.0.0.1',
			 	'username' => 'root',
	 			'password' => '12345678',
				'dbname'=> 'zf_cms'
			));		
			

			$dbConfig = new Zend_Config(	
				array(
					'database' => array(
						'adapter' => 'Pdo_Mysql',
						'params' => array(
							'dbname' => 'test',
							'username' => 'root',
							'password' => '12345678',
						)
					),
					/** Here you can add multple entries, which can be used later **/
				)
			);

			$dbTest = Zend_Db::factory($dbConfig->database);
			//If an optional second argument of the factory() method exists, 


		  Zend_Registry::set('dbNorthwind', $dbNorthwind);
		  Zend_Registry::set('dbZfCms', $dbZfCms);
		  Zend_Registry::set('dbTest', $dbTest);
		  
		// Return it so that it can be stored by the bootstrap
		return $autoLoader;
	}
}
