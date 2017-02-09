<?php

namespace Controllers {
	use Core\{Controller,Database,Auth};
	use Helpers\Validator;
	use Libraries\File;
	use \Models\Projects as Model;

	class Projects extends Controller{
		private $model;

		function __construct(Database $db, Auth $auth) {
			parent::__construct($db, $auth);
			$this->model = new Model($db);
		}

		public function registration(array $page) {
			$this->view(['content' 	=> ['Projects/Registration', $this->model->getData()]]);
		}

		public function add() {
			$post = New Validator($_POST);
			$post->checkAll('projectname', 		1, 		null, 	Validator::TEXT)
				->checkAll('website', 			1, 		null, 	Validator::URL)
				->checkAll('description', 		1, 		null, 	Validator::TEXT)
				->checkAll('paymenttype', 		1, 		1, 		Validator::NUM)
				->checkAll('date', 				10, 	10, 	Validator::DATE)

            	->checkAll('percents', 			1, 		10, 	Validator::NUM, 	'plan_percents', 		true, 0)
            	->checkAll('period', 			1, 		10, 	Validator::NUM, 	'plan_period', 			true, 0)
            	->checkAll('periodtype', 		1, 		10, 	Validator::NUM, 	'plan_period_type', 	true, 0)
            	->checkAll('minmoney', 			1, 		10, 	Validator::FLOAT, 	'plan_start_deposit', 	true, 0)
				->checkAll('currency', 			1, 		10, 	Validator::NUM,		'plan_currency_type', 	true, 0)
				
				->checkAll('ref_percent', 		null, 	null, 	Validator::NUM)
				->checkAll('lang', 				1, 		null, 	Validator::NUM,		'languages')
				->checkAll('payment', 			1, 		null, 	Validator::NUM,		'payments');

			if ($errors = $post->getErrors()) echo json_encode(['error' => $errors]);
			else if (!$post->same()) echo 'error: Not same!';
			else if ($project_id = $this->model->addProject($post)) {
				// Save screenshots
				$file = new File($project_id);
				$file->save($_POST['screen_data']);
				$file->save($_POST['thumb_data'], true);

			}
		}
	}

}?>