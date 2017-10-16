<?php

namespace Models {

    use Core\{Auth, Model, Database};
    use Helpers\{
        Helper, Validator, Arrays
    };

	class Projects extends Model{

		function __construct(Database $db) {
			parent::__construct($db);
		}

		public function addProject(Validator $post) {
			$data = $post->getData();

			// сохраняем информацию по проекту
			$in_data = [
				'name' 					=> [[$data['projectname']]],
				'admin' 				=> [[1],								\PDO::PARAM_INT],
				'url' 					=> [[$data['url']]],
				'ref_url' 				=> [[$data['ref_url']]],
				'paymenttype' 			=> [[$data['paymenttype']],				\PDO::PARAM_INT],
				'start_date'			=> [[$data['date']]],
				'plan_percents'			=> [[Arrays::joinForInsert($data['plan_percents'])]],
				'plan_period'			=> [[Arrays::joinForInsert($data['plan_period'])]],
				'plan_period_type'		=> [[Arrays::joinForInsert($data['plan_period_type'])]],
				'plan_start_deposit'	=> [[Arrays::joinForInsert($data['plan_start_deposit'])]],
				'plan_currency_type'	=> [[Arrays::joinForInsert($data['plan_currency_type'])]],
				'ref_percent'			=> [[Arrays::joinForInsert($data['ref_percent'])]],
				'payments'				=> [[Arrays::joinForInsert($data['payments'])]]
			];

			if (!$this->db->insert('project', $in_data)) return null;

			$project_id = $this->db->lastID('project');


            $this->db->insert('project_lang', [
                'project_id' 		=> [array_fill(0, count($data['description']), $project_id), \PDO::PARAM_INT],
                'lang_id' 			=> [array_keys($data['description']),              \PDO::PARAM_INT],
                'description' 		=> [array_values($data['description'])],
            ]);
            return $project_id;
		}

		public function getData() {
			return [
				'payments'  => $this->db->select('payments', 'id, name', null, 'pos'),
				'languages' => $this->db->select('languages', 'id, name, own_name, flag', 'pos is not null', 'pos'),
				'hidden_languages' => $this->db->select('languages', 'id, name, own_name, flag', 'pos is null', 'name'),
                'user_info' => Auth::getUserInfo()
			];
		}
	}
}