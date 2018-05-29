<?php

namespace Controllers {
	use Core\{Controller};
    use Helpers\{
        Validator, Helper, Data\Currency
    };
	use Libraries\File;
	use \Models\Hyip as Model;

	class Hyip extends Controller{
		private $model;

		function __construct() {
			parent::__construct();
			$this->model = new Model();
		}

		public function registration(array $page) {
		    $data = $this->model->getRegistrationData();
//            \R::r($data);
            $data['currency'] = Currency::getCurrency();
			$this->view(['content' 	=> ['Hyip/Registration', $data]]);
		}

		public function show(array $page) {
            $data = $this->model->getShowData();

            if ($data) {
                $file = new File(-1);
                foreach ($data['projects'] as $project_id => &$val) {
                    $val['file_name']   = $file->get_file_path($project_id);
                }
            }
//            \R::r($data);
            /*$payments = [];
            foreach ($data['payments'] as $pay) {
                $payments[$pay['id']] = $pay['name'];
            }
            $data['payments'] = $payments;*/
//            \R::r($data);
			$this->view(['content' 	=> ['Hyip/show', $data]]);
		}

		public function add(array $args) {
            $data = $this->post
                ->checkAll('projectname', 		1, 		null, 	Validator::TEXT)
				->checkAll('paymenttype', 		1, 		3, 	Validator::NUM)
				->checkAll('date', 				10, 	    10, 	Validator::DATE)

            	->checkAll('percents', 			1, 		null,  Validator::FLOAT,    'plan_percents', 		true, 0)
            	->checkAll('period', 			1, 		null,  Validator::NUM,      'plan_period', 			true, 0)
            	->checkAll('periodtype', 		1, 		6, 	Validator::NUM,      'plan_period_type', 	    true, 0)
            	->checkAll('minmoney', 			1, 		null, 	Validator::FLOAT, 	'plan_start_deposit', 	true, 0)
				->checkAll('currency', 			1, 		8, 	Validator::NUM,		'plan_currency_type', 	true, 0)

				->checkAll('ref_percent', 		null, 	    null, 	Validator::FLOAT,     null,                   true)
				->checkAll('payment', 			1, 		null, 	Validator::NUM,		'payments')
                ->checkAll('description', 		1, 		null, 	null,                 null,                  null,  1)
                ->checkAll('lang', 				1, 		null, 	Validator::NUM,		'languages',            null,  1)

                ->addErrors($this->check_website()['error'] ?? [])->getData();

			if ($errors = $this->post->getErrors()) {
			    Helper::show_json(['error' => $errors]);
			    return -1;
            }

            foreach ($data['languages'] as $key => $val) {
			    if (!isset($data['description'][$val])) {
                    Helper::show_json(['error' => ['is_absent' => [$val]]]);
                    return -2;
                }
            }

            $this->post->addFields(['url' => $this->check_website()['success']['url']]);
            if ($project_id = $this->model->addProject($this->post)) {
                // Save screenshots
                $file = new File($project_id);
                $file->save($_POST['screen_data']);
                $file->save($_POST['thumb_data'], true);

                Helper::show_json(['success' => $project_id]);
            }
		}

		private function check_website():array {
            $ref_url = $this->post->checkAll('website', 1, 128, Validator::URL, 'ref_url')->getData()['ref_url'];
            $url = 'http://'.str_replace(['www.', 'https://', 'http://'], '', strtolower($ref_url));
            $url = array_reverse(explode('.', parse_url($url, PHP_URL_HOST)));

            if (count($url) < 2) {
                $ret = ['error' => ['fields' => ['website' => ['Wrong site']]]];
            }
            else {
                $url_str = $url[1] . '.' . $url[0];
                if (($res = $this->model->db->getRow('project', 'id', "url = '{$url_str}'"))) {
                    $ret = ['error' => ['fields' => ['website' => ['exists', $res['id']]]]];
                }
                else $ret = ['success' => ['url' => $url_str, 'ref_url' => $ref_url]];
            }
            return $ret;
        }

        public function check(array $args) {
            Helper::show_json($this->check_website());
        }
	}

}