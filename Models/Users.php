<?php

namespace Models {

	use Core\Database;
	use Core\Model;
	use Libraries\File;

	class Users extends Model{

		function __construct(Database $db) {
			parent::__construct($db);
		}

		/*public function saveProject(array $post) {
			$data = [
				'name' 			=> $post['projectname'],
				'admin' 		=> 1,
				'url' 			=> $post['website'],
				'description' 	=> $post['description'],
				'paymenttype' 	=> $post['paymenttype'],
				'start_date'	=> date('Y.m.d', strtotime($post['date']))
			];

			//сохраняем проект и получаем ID
			$this->db
				->insert('project', $data)
				->add('SET @project_id = LAST_INSERT_ID()');

			// сохраняем планы
			$data = [
				array_fill(0, count($post['percents']), '@project_id'),
				$post['percents'],
				$post['period'],
				$post['periodtype'],
				$post['minmoney'],
				$post['currency']
			];
			$fields = [
				"project_id",
				"percents",
				"period",
				"period_type_id",
				"start_deposit",
				"currency_type_id"
			];
			$this->db->multiInsert('project_plans', $fields, $data);

			// сохраняем реферальные уровни
			$cnt=count($post['ref_percent']);
			$data = array(
				array_fill(0, $cnt, '@project_id'),
				$post['ref_percent'],
				range(1,$cnt)
			);
			$fields = [
				"project_id",
				"percents",
				"level"
			];
			$this->db->multiInsert('project_referral', $fields, $data);

			// сохраняем языки сайта
			$data = [
				array_fill(0, count($post['lang']), '@project_id'),
				$post['lang']
			];
			$fields = [
				"project_id",
				"lang_id"
			];
			$this->db->multiInsert("project_lang", $fields, $data);

			// сохраняем платёжные системы
			$data = [
				array_fill(0, count($post['payment']), '@project_id'),
				$post['payment']
			];
			$fields = [
				"project_id",
				"payment_id"
			];
			$this->db->multiInsert("project_payment", $fields, $data);

			if ($this->db->execute()) {
				$project_id = $this->db->lastID('project');

				// Save screenshots
				$file = new File($project_id);
				$file->save($post['screen_data']);
				$file->save($post['thumb_data'], true);

			}

		}*/
	}

}?>