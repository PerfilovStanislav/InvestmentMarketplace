<?php

namespace Models {

    use Core\{Auth, Model};
    use Helpers\{
        Validator, Arrays, Data\Currency
    };

	class Hyip extends Model{

		function __construct() {
			parent::__construct();
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

        public function getRegistrationData() {
            return [
                'payments'  => $this->db->select('payments', 'id, name', null, 'pos'),
                'languages' => $this->db->select('languages', 'id, name, own_name, flag', 'pos is not null', 'pos'),
                'hidden_languages' => $this->db->select('languages', 'id, name, own_name, flag', 'pos is null', 'name'),
                'user_info' => Auth::getUserInfo()
            ];
        }

        public function getShowData() {
		    $projects = $this->db->getResult('
                SELECT id, name, url, array_to_json(ref_percent) ref_percent, array_to_json(id_payments) id_payments
                FROM project
            ');

		    $arrayHelper = new Arrays($projects);
		    $project_ids = $arrayHelper->arrayColumn('id')->getArray();
		    $project_ids_str = implode(',', $project_ids);

		    $plans = $this->db->getResult('
		        SELECT id, array_to_json(array_agg(ARRAY[p1, p2, p3, p4, p5])) plan
                FROM (
                    SELECT id
                        , unnest(plan_percents)      as p1
                        , unnest(plan_period)        as p2
                        , unnest(plan_period_type)   as p3 
                        , unnest(plan_start_deposit) as p4 
                        , unnest(plan_currency_type) as p5 
                    FROM project WHERE id IN ('.$project_ids_str.')
                ) tt
                GROUP BY id
		    ');

		    $flags = $this->db->getResult('
		        SELECT project_id, array_to_json(array_agg(lang_id)) as lang_id
                FROM project_lang WHERE project_id IN ('.$project_ids_str.')
                GROUP BY project_id
		    ');

		    $languages = $this->db->getResult('
		        SELECT l.id, l.name, l.own_name, l.flag
                FROM project_lang pl
                join languages l ON l.id = pl.lang_id
                where project_id IN ('.$project_ids_str.')
                GROUP BY l.id, l.name, l.own_name, l.flag
		    ');

            $payments = $this->db->getResult('
                SELECT pay.id, pay.name
                FROM project pr
                JOIN payments pay ON pay.id = ANY(pr.id_payments)
                WHERE pr.id IN ('.$project_ids_str.')
                GROUP BY pay.id, pay.name
                ORDER BY pay.pos
            ');

            /*$chats = $this->db->getResult('
                SELECT m.id, m.date_create, m.user_id, m.project_id, m.message, m.session_id
                FROM message m
                WHERE m.project_id IN ('.$project_ids_str.') and m.lang_id = 217
                ORDER BY m.project_id, m.id asc
            ');

            $chat_limits = $this->db->getResult('
                SELECT m.project_id, min(m.id) as min_message_id, max(m.id) as max_message_id
                FROM message m
                WHERE m.project_id IN ('.$project_ids_str.') and m.lang_id = 217
                group by m.project_id
            ');*/

            return [
                'project_ids' => $project_ids,
                'projects'    => $arrayHelper->setArray($projects)->toArray(['id_payments', 'ref_percent'])->groupBy(['id'])->getArray(),
                'plans'       => $arrayHelper->setArray($plans)->toArray(['plan'])->groupBy(['id'])->getArray(),
                'flags'       => $arrayHelper->setArray($flags)->toArray(['lang_id'])->groupBy(['project_id'])->getArray(),
                'languages'   => $arrayHelper->setArray($languages)->groupBy(['id'])->getArray(),
                'payments'    => $arrayHelper->setArray($payments)->groupBy(['id'])->getArray(),
                'currency'    => Currency::getCurrency(),
//                'chats'       => $arrayHelper->setArray($chats)->groupBy(['project_id', 'id'])->getArray(),
//                'chat_limits' => $arrayHelper->setArray($chat_limits)->groupBy(['project_id'])->getArray(),
            ];
        }

        public function getChatMessages(array $chats) {
		    $sql = implode(' UNION ALL ', array_map(
		        function($a) {
		            return "
		                (SELECT m.id, m.date_create, m.user_id, m.project_id, m.message, m.session_id
                        FROM message m
                        WHERE m.project_id = {$a['id']} and m.id>{$a['max_id']} and m.lang_id = 217
                        ORDER BY m.id desc
                        limit 50)
		            ";
                }, $chats
            ));

            $chats = $this->db->getResult($sql);

            if (!$chats) return null;

            $arrayHelper = new Arrays();
            return $arrayHelper->setArray($chats)->groupBy(['project_id', 'id'])->getArray();
        }
	}
}
