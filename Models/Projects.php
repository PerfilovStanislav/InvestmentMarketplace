<?php

namespace Models {

	use Core\{Model, Database};
	use Helpers\{Validator, Arrays};

	class Projects extends Model{

		function __construct(Database $db) {
			parent::__construct($db);
		}

		public function addProject(Validator $post) {
			$data = $post->getData();
//			var_dump(Validator::join($post['ref_percent'], 1)); die();

			// сохраняем информацию по проекту
			$data = [
				'name' 					=> [[$data['projectname']]],
				'admin' 				=> [[1],								\PDO::PARAM_INT],
				'url' 					=> [[$data['website']]],
				'description' 			=> [[$data['description']]],
				'paymenttype' 			=> [[$data['paymenttype']],				\PDO::PARAM_INT],
				'start_date'			=> [[$data['date']]],
				'plan_percents'			=> [[Arrays::join($data['plan_percents'])]],
				'plan_period'			=> [[Arrays::join($data['plan_period'])]],
				'plan_period_type'		=> [[Arrays::join($data['plan_period_type'])]],
				'plan_start_deposit'	=> [[Arrays::join($data['plan_start_deposit'])]],
				'plan_currency_type'	=> [[Arrays::join($data['plan_currency_type'])]],
				'ref_percent'			=> [[Arrays::join($data['ref_percent'])]],
				'languages'				=> [[Arrays::join($data['languages'])]],
				'payments'				=> [[Arrays::join($data['payments'])]]
			];

			if ($this->db->insert('project', $data)) return $this->db->lastID('project');
			else return null;
		}

		public function getData() {
			return [
				'payments'  => $this->db->select('payments', 'id, name', null, 'pos'),
				'languages' => $this->db->select('languages', 'id, name, own_name, flag', 'pos is not null', 'pos'),
				'hidden_languages' => $this->db->select('languages', 'id, name, own_name, flag', 'pos is null', 'name')
			];
		}
	}

}?>