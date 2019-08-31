<?php

namespace Controllers {

    use Core\{Controller, View};
    use Helpers\{
        Output,
    };
    use Views\StaticFiles\SiteManifest;

    class Staticfiles extends Controller {

		public function sitemanifest() {
            Output::header(Output::JSON);
            Output::output((new View(SiteManifest::class))->get());
		}
	}
}
