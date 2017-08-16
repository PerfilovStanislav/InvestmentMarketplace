

      
      <!-- Begin: Content -->

        <!-- begin: .tray-center -->
        <div class="tray tray-center">

            <!-- Begin: Content Header -->
            <div class="content-header">
              <h2> AdminForms makes <b class="text-primary">Validation</b> is easier than ever</h2>
              <p class="lead">Use the Admin Forms you know and love to help build the perfect form.</p>
            </div>

            <!-- Validation Example -->
            <div class="admin-form theme-primary mw1000 center-block" style="padding-bottom: 175px;">

              <div class="panel heading-border panel-primary">
				  <div class="panel-heading">
                    <span class="panel-title">
                      <i class="fa fa-pencil-square"></i><?= $this->locale['add_project']?>
                    </span>
				  </div>
                <form method="post" action="/" id="addproject_form">

                  <div class="panel-body bg-light">

                    <div class="section row" >
                      <div class="section">
                        <label class="field prepend-icon">
                          <input name="projectname" class="gui-input onlyText" placeholder="<?= $this->locale['project_name']?>">
                          <label class="field-icon">
                            <i class="fa fa-pencil"></i>
                          </label>
                        </label>
                      </div>
                      <!-- end section -->

                        <div class="section">
                            <div class="smart-widget sm-right smr-100">
                                <label class="field prepend-icon">
                                    <input name="website" class="gui-input onlyUrl" placeholder="<?= $this->locale['project_url']?>">
                                    <label class="field-icon">
                                        <i class="fa fa-globe"></i>
                                    </label>
                                </label>
                                <label for="verification" class="button btn-primary check"><?= $this->locale['check']?></label>
                            </div>
                            <!-- end .smart-widget section -->
                        </div>
                    <!-- end section -->
                    <div class="section">
                      <label class="field prepend-icon">
						  <input type="text" name="date" class="datepicker gui-input" placeholder="<?= $this->locale['start_date']?>">
						  <label class="field-icon">
							<i class="fa fa-calendar"></i>
						  </label>
						</label>
                    </div>
                    <!-- end section -->

                    <!-- end section -->

                    <div class="section">
                      <label class="field select">
                        <select name="paymenttype">
                          <option value=""><?=  $this->locale['payment_type'][0]?></option>
                          <option value="1"><?= $this->locale['payment_type'][1]?></option>
                          <option value="2"><?= $this->locale['payment_type'][2]?></option>
                          <option value="3"><?= $this->locale['payment_type'][3]?></option>
                        </select>
                        <i class="arrow double"></i>
                      </label>
                    </div>
                    <!-- end section -->
                    <div class="section-divider mt40 mb25">
                      <span> <?= $this->locale['plans']?> </span>
                    </div>
                    <!-- .section-divider -->
					

					
						
                    <div class="section mb10" role="group">							
                      <div class="section row mb10" role="row">					  
						  <div class="col-md-3">
							<div class="section row mbn">
								<div class="col-md-3 w50 mr20">
									<button class="button btn-warning remove glyphicons glyphicons-remove_2" type="button" title="<?= $this->locale['remove']?>"> </button>
								</div>
								
								<div class="col-md-8 pln prn">
									<label class="field append-icon">
										<input placeholder="<?= $this->locale['profit']?>" class="gui-input onlyNumber" name="percents[]">
										<label class="field-icon">
											<i class="fa fa-percent"></i>
										</label>
									</label>
								</div>
							</div>
						  </div>
						  <!-- end section -->
						  
						  <div class="col-md-3 prn">
							  <div class="smart-widget sm-left sml-80">
								<label class="field append-icon">
								  <input class="gui-input onlyNumber" name="period[]">							  
								  <label class="field-icon">
									<i class="glyphicons glyphicons-clock"></i>
								  </label>
								</label>
								<label class="button w15"><?= $this->locale['after']?></label>
							  </div>
						  </div>
						  <!-- end section -->
						  
						  <div class="col-md-2 mln1 pln">
							<label class="field select">
							  <select name="periodtype[]">
								<option value="1">          <?= $this->locale['period'][1]?></option>
								<option value="2">          <?= $this->locale['period'][2]?></option>
								<option value="3" selected> <?= $this->locale['period'][3]?></option>
								<option value="4">          <?= $this->locale['period'][4]?></option>
								<option value="5">          <?= $this->locale['period'][5]?></option>
								<option value="6">          <?= $this->locale['period'][6]?></option>
							  </select>
							  <i class="arrow double"></i>
							</label>
						  </div>
						  <!-- end section -->
						  
						  <div class="col-md-3 prn" >
							  <div class="smart-widget sm-left sml-50">
								<label class="field append-icon">
								  <input class="gui-input onlyNumber" name="minmoney[]">							  
								  <label class="field-icon">
									<i class="fa fa-money"></i>
								  </label>
								</label>
								<label class="button prn pln"><?= $this->locale['from']?></label>
							  </div>
						  </div>
						  <!-- end section -->
						  
						  <div class="col-md-1 mln1 pln fa"  style="top: 0px">
							<label class="field select">
							  <select name="currency[]">
								<option value="1">&#xf155;</option>
								<option value="2">&#xf153;</option>
								<option value="3">&#xf15a;</option>
								<option value="4">&#xf158;</option>
								<option value="5">&#xf154;</option>
								<option value="6">&#xf157;</option>
								<option value="7">&#xf159;</option>
								<option value="8">&#xf156;</option>
							  </select>
							  <i class="arrow double"></i>
							</label>
						  </div>
						  <!-- end section -->
						  
						</div>

                    </div>
                    <!-- end .section row section -->
					  
                    <div class="section">
						<button type="button" class="button btn-primary copy"> <?= $this->locale['add_plan']?> </button>
					</div>
					
					

					
					
					
					
					
					
					
					
					
					
                    <div class="section-divider mt40 mb25">
                      <span> <?= $this->locale['ref_program']?> </span>
                    </div>
                    <!-- .section-divider -->
                    <div class="section mb10 mrn20" role="group">
                        <div class="section row mb10 mrn" role="row">
						  <div class="col-md-1 w50 mr20" >
							<button type="button" class="button btn-warning remove glyphicons glyphicons-remove_2" title="<?= $this->locale['remove']?>"> </button>
						  </div>
								
						  <div class="col-md-11 pln" >
							  <div class="smart-widget sm-left sml-120">
								<label class="field append-icon">
								  <input name="ref_percent[]" class="gui-input onlyNumber" placeholder="%">							  
								  <label class="field-icon">
									<i class="fa fa-street-view"></i>
								  </label>
								</label>
								<label class="button prn pln" ><n>1</n> <?= $this->locale['level']?></label>
							  </div>
						  </div>
						  <!-- end section -->
						</div>
					</div>		
					  
                    <div class="section">
						<button type="button" class="button btn-primary copy"> <?= $this->locale['add_level']?> </button>
					</div>
                    <!-- end section -->
					
					
					
					
					
					
					
					

					<div class="section-divider mt40 mb25">
                      <span> <?= $this->locale['payment_system']?> </span>
                    </div>

					<div class="payments">
						<div class="section row">
							<?php
							  $div = ceil(sizeof($this->payments)/3);
							  foreach($this->payments as $k => $v) {
								if ($k%$div === 0) echo '<div class="col-md-4 pad-r40 border-right">';
								echo '<label class="block mt15 option option-primary">
                                        <input type="checkbox" name="payment[]" value="'.$v['id'].'">
                                        <span class="checkbox"></span> <i class="pay pay-'.$v['name'].' mbn" ></i> '.$v['name'].'</label>';
								if (($k+1)%$div === 0  ||  $k === sizeof($this->payments)-1) echo '</div>';
							  }
							?>
						</div>
                    </div>



					
					
					
					
					
					
					
					
					
					

                    <div class="section-divider mt40 mb25">
                      <span> <?= $this->locale['languages']?> </span>
                    </div>
                    <!-- .section-divider -->

					<div class="langs">
						<div class="section row">
							<?php
							  $div = ceil(sizeof($this->languages)/3);
							  foreach($this->languages as $k => $v) {
								if ($k%$div === 0) echo '<div class="col-md-4 pad-r40 border-right">';
								echo '<label class="block mt15 option option-primary"><input type="checkbox" name="lang[]" value="'.$v['id'].'"><span class="checkbox"></span> <i class="flag flag-'.$v['flag'].'" ></i><txt>'.$v['name']." ( {$v['own_name']} )".'</txt></label>';
								if (($k+1)%$div === 0  ||  $k === sizeof($this->languages)-1) echo '</div>';
							  }
							?>
						</div>

						<div class="section row" hidden>
							<?php
							$div = ceil(sizeof($this->hidden_languages)/3);
							  foreach($this->hidden_languages as $k => $v) {
								if ($k%$div === 0) echo '<div class="col-md-4 pad-r40 border-right">';
								echo '<label class="block mt15 option option-primary"><input type="checkbox" name="lang[]" value="'.$v['id'].'"><span class="checkbox"></span> <i class="flag flag-'.$v['flag'].'" ></i><txt>'.$v['name']." ( {$v['own_name']} )".'</txt></label>';
								if (($k+1)%$div === 0  ||  $k === sizeof($this->hidden_languages)-1) echo '</div>';
							  }
							?>
						</div>
						<div class="section">
							<button type="button" class="button btn-primary showPrev"> <?= $this->locale['show_all_langs']?> </button>
						</div>
					</div>


                    <div class="section description" hidden>
                        <label class="field prepend-icon">
                            <textarea class="gui-textarea" name="description" placeholder="<?= $this->locale['description']?> "></textarea>
                            <label class="field-icon">
                            </label>
                        </label>
                    </div>
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
                    <div class="section-divider mt40 mb25">
                      <span> <?= $this->locale['screenshot']?> </span>
                    </div>
  <div class="section">
    <div class="section row br-a br-greyer mn mb15 p2">
      <div class="col-md-6 img-container pl1 mb1">
          <img id="full_site_image" src="" alt="<?= $this->locale['screenshot']?>">
		  <input type="hidden" name="screen_data">
      </div>	  
      
      <div class="col-md-6 img-container pr1 mb1">
          <img id="thumb_site_image" src="" alt="<?= $this->locale['screenshot']?>">
		  <input type="hidden" name="thumb_data">
      </div>

    </div>
    <div class="section row">		
	  <div class="col-md-12 docs-buttons">
	    <div class="btn-group btn-group-crop">
	  	  
	  	  <button title="Просмотр" data-toggle="tooltip" type="button" class="btn btn-primary disabled" data-method="getCroppedCanvas" data-control=1>
	  		  <span class="fa fa-picture-o fa-lg "></span>
	  	  </button>
	  	
	  	  <label for="inputImage" class="btn btn-primary btn-upload">
	  		<input type="file" accept="image/*" id="inputImage" class="sr-only">
	  		<span data-toggle="tooltip" data-original-title="" title="">
	  		  <span class="fa fa-upload"></span> <?= $this->locale['select_file']?></span>
	  	  </label>
	  	  
	  	  <button title="<?= $this->locale['view']?>" data-toggle="tooltip" type="button" class="btn btn-primary disabled" data-method="getCroppedCanvas" data-control=0>
	  		  <span class="fa fa-picture-o fa-lg "></span>
	  	  </button>
	  	  
	    </div>
	  </div> 

        <!-- Show the cropped image in modal -->
      <div style="display: none;" class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="getCroppedCanvasTitle"><?= $this->locale['view']?></h4>
            </div>
            <div class="modal-body"><img id="full_site_image" src="" alt="Picture"></div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?= $this->locale['close']?></button>
              <a class="btn btn-primary" target="blank" id="download" href="javascript:void(0);"><?= $this->locale['download']?></a>
            </div>
          </div>
        </div>
      </div><!-- /.modal -->
    </div>
  </div>
  
  
  
  
  
  
  
						
						
						
						
						
						

                  <!-- end .form-body section -->
                  <div class="panel-footer text-right">
                    <button type="submit" class="button btn-primary" <?php echo ($this->user_info['id'] ?? null) ? '' : 'disabled'; ?>> <?= $this->locale['send_form']?> </button>
                  </div>
                </div>
				  <input type="hidden" name="ajax" value="1">
                  <!-- end .form-footer section -->
				  
				  

              </div>
                </form>

            </div>
            <!-- end: .admin-form -->

        </div>
        <!-- end: .tray-center -->
      <!-- End: Content -->
	  
	  <script>
		scripts.addOne(['ProjectRegistration']);
	  </script>