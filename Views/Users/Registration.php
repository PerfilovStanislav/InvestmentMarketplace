


<!-- Begin: Content -->

<!-- begin: .tray-center -->
<div class="tray tray-center">


    <!-- Validation Example -->
    <div class="admin-form theme-primary mw1000 center-block" style="padding-bottom: 175px;">

        <div class="panel heading-border panel-primary">
            <div class="panel-heading">
                    <span class="panel-title">
                      <i class="fa fa-pencil-square"></i><?= $this->locale['user_registration']?>
                    </span>
            </div>

            <form method="post" action="/" id="adduser_form">

                <div class="panel-body bg-light">

                    <div class="alert alert-warning alert-dismissable alert-border-left mr0 ml0" id="alert-user-registration-error">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-warning pr10"></i><er>{user_error}</er></div>

                    <div class="section row" >
                        <div class="section">
                            <label class="field prepend-icon">
                                <input name="login" class="gui-input onlyEn" placeholder="<?= $this->locale['login']?>">
                                <label class="field-icon">
                                    <i class="fa fa-user"></i>
                                </label>
                            </label>
                        </div>

                        <div class="section">
                            <label class="field prepend-icon">
                                <input name="name" class="gui-input onlyText" placeholder="<?= $this->locale['name']?>">
                                <label class="field-icon">
                                    <i class="fa fa-group"></i>
                                </label>
                            </label>
                        </div>

                        <div class="section">
                            <label class="field prepend-icon">
                                <input name="email" class="gui-input onlyEmail" placeholder="<?= $this->locale['email']?>">
                                <label class="field-icon">
                                    <i class="fa fa-envelope-o"></i>
                                </label>
                            </label>
                        </div>

                        <div class="section">
                            <label class="field prepend-icon">
                                <input type="password" name="password" class="gui-input" placeholder="<?= $this->locale['password']?>">
                                <label class="field-icon">
                                    <i class="fa fa-lock"></i>
                                </label>
                            </label>
                        </div>

                        <div class="section">
                            <label class="field prepend-icon">
                                <input type="password" id="confirm_pass" class="gui-input" placeholder="<?= $this->locale['password']?>">
                                <label class="field-icon">
                                    <i class="fa fa-lock"></i>
                                </label>
                            </label>
                        </div>




                        <!-- end .form-body section -->
                        <div class="panel-footer text-right">
                            <button type="submit" class="button btn-primary"> Отправить форму </button>
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
        scripts.addOne(['UserRegistration']);
    </script>