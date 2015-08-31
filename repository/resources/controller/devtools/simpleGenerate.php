<?php
class simpleGenerateController extends WE_Controller_Crud {
	
	public function indexAction() {
		Db::getModel('Tih_diseases');
		Db::getTable('Tih_diseases');
		
		Db::getModel('Tih_centers');
		Db::getTable('Tih_centers');
		
		Db::getModel('Tih_medicines');
		Db::getTable('Tih_medicines');
		
		Db::getModel('Tih_polyclinics');
		Db::getTable('Tih_polyclinics');
		
		Db::getModel('Tih_users');
		Db::getTable('Tih_users');
		
		Db::getModel('Tih_link_center_user');
		Db::getTable('Tih_link_center_user');
		
		Db::getModel('Tih_link_clientsystem_user');
		Db::getTable('Tih_link_clientsystem_user');
		
		Db::getModel('Tih_comorbidities');
		Db::getTable('Tih_comorbidities');
	}
	
}