<!DOCTYPE html>
<html>
<head>  
	<script>
      const SITE = '<?=SITE;?>';

      var refreshAllowed = false;
      var scripts=['panelScrollerInit'];
      Array.prototype.addOne = function(el) {
          o:for (var i in el) {
              for(var j in this) {
                  if (el[i] == this[j]) continue o;
              }
              this.push(el[i]);
          }
      };
	</script>
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <title>AbsoluteAdmin - A Responsive Boostrap 3 Admin Dashboard</title>
  <meta name="keywords" content="Bootstrap 3 Admin Dashboard Template Theme" />
  <meta name="description" content="AdminDesigns - Bootstrap 3 Admin Dashboard Theme">
  <meta name="author" content="AdminDesigns">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- 
	ДОБАВИТЬ CloudFlare
-->
<!-- <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700'>-->
<link rel="stylesheet" type="text/css" href="<?=SITE;?>assets/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" type="text/css" href="<?=SITE;?>assets/google/fonts.css">
<!--<link rel="stylesheet" type="text/css" href="<?=SITE;?>assets/skin/default_skin/css/theme.cssgz">-->
<link rel="stylesheet" type="text/css" href="<?=SITE;?>assets/default_skin/css/theme.css">
<link rel="stylesheet" type="text/css" href="<?=SITE;?>assets/cropper/cropper.css">
<link rel="stylesheet" type="text/css" href="<?=SITE;?>assets/admin-forms/css/admin-forms.min.css">
<link rel="stylesheet" type="text/css" href="<?=SITE;?>assets/glyphicons-pro/glyphicons-pro.css">
<link rel="stylesheet" type="text/css" href="<?=SITE;?>assets/flags/flags.css">
<link rel="stylesheet" type="text/css" href="<?=SITE;?>assets/payments/payments.css">
  
<!-- для работы с картинками-->
<link rel="stylesheet" type="text/css" href="<?=SITE;?>assets/magnific/magnific-popup.css">
  


  <!-- Favicon -->
  <link rel="shortcut icon" href="<?=SITE;?>assets/favicon.ico">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="<?=SITE;?>assets/js/3.7.0/html5shiv.js"></script>
  <script src="<?=SITE;?>assets/js/respond.min.js"></script>
<![endif]-->

</head>

<body class="dashboard-page">

<!-------------------------------------------------------------+ 
  <body> Helper Classes: 
---------------------------------------------------------------+ 
  '.sb-l-o' - Sets Left Sidebar to "open"
  '.sb-l-m' - Sets Left Sidebar to "minified"
  '.sb-l-c' - Sets Left Sidebar to "closed"

  '.sb-r-o' - Sets Right Sidebar to "open"
  '.sb-r-c' - Sets Right Sidebar to "closed"
---------------------------------------------------------------+
 Example: <body class="example-page sb-l-o sb-r-c">
 Results: Sidebar left Open, Sidebar right Closed
--------------------------------------------------------------->

  <!-- Start: Theme Preview Pane -->
  <div id="skin-toolbox">
    <div class="panel">
      <div class="panel-heading">
        <span class="panel-icon">
          <i class="fa fa-gear text-primary"></i>
        </span>
        <span class="panel-title"> Theme Options</span>
      </div>
      <div class="panel-body pn">
        <ul class="nav nav-list nav-list-sm pl15 pt10" role="tablist">
          <li class="active">
            <a href="#toolbox-header" role="tab" data-toggle="tab">Navbar</a>
          </li>
          <li>
            <a href="#toolbox-sidebar" role="tab" data-toggle="tab">Sidebar</a>
          </li>
          <li>
            <a href="#toolbox-settings" role="tab" data-toggle="tab">Misc</a>
          </li>
        </ul>
        <div class="tab-content p20 ptn pb15">
          <div role="tabpanel" class="tab-pane active" id="toolbox-header">
            <form id="toolbox-header-skin">
              <h4 class="mv20">Header Skins</h4>
              <div class="skin-toolbox-swatches">
                <div class="checkbox-custom checkbox-disabled fill mb5">
                  <input type="radio" name="headerSkin" id="headerSkin8" checked value="">
                  <label for="headerSkin8">Light</label>
                </div>
                <div class="checkbox-custom fill checkbox-primary mb5">
                  <input type="radio" name="headerSkin" id="headerSkin1" value="bg-primary">
                  <label for="headerSkin1">Primary</label>
                </div>
                <div class="checkbox-custom fill checkbox-info mb5">
                  <input type="radio" name="headerSkin" id="headerSkin3" value="bg-info">
                  <label for="headerSkin3">Info</label>
                </div>
                <div class="checkbox-custom fill checkbox-warning mb5">
                  <input type="radio" name="headerSkin" id="headerSkin4" value="bg-warning">
                  <label for="headerSkin4">Warning</label>
                </div>
                <div class="checkbox-custom fill checkbox-danger mb5">
                  <input type="radio" name="headerSkin" id="headerSkin5" value="bg-danger">
                  <label for="headerSkin5">Danger</label>
                </div>
                <div class="checkbox-custom fill checkbox-alert mb5">
                  <input type="radio" name="headerSkin" id="headerSkin6" value="bg-alert">
                  <label for="headerSkin6">Alert</label>
                </div>
                <div class="checkbox-custom fill checkbox-system mb5">
                  <input type="radio" name="headerSkin" id="headerSkin7" value="bg-system">
                  <label for="headerSkin7">System</label>
                </div>
                <div class="checkbox-custom fill checkbox-success mb5">
                  <input type="radio" name="headerSkin" id="headerSkin2" value="bg-success">
                  <label for="headerSkin2">Success</label>
                </div>
                <div class="checkbox-custom fill mb5">
                  <input type="radio" name="headerSkin" id="headerSkin9" value="bg-dark">
                  <label for="headerSkin9">Dark</label>
                </div>
              </div>
            </form>
          </div>
          <div role="tabpanel" class="tab-pane" id="toolbox-sidebar">
            <form id="toolbox-sidebar-skin">
              <h4 class="mv20">Sidebar Skins</h4>
              <div class="skin-toolbox-swatches">
                <div class="checkbox-custom fill mb5">
                  <input type="radio" name="sidebarSkin" checked id="sidebarSkin3" value="">
                  <label for="sidebarSkin3">Dark</label>
                </div>
                <div class="checkbox-custom fill checkbox-disabled mb5">
                  <input type="radio" name="sidebarSkin" id="sidebarSkin1" value="sidebar-light">
                  <label for="sidebarSkin1">Light</label>
                </div>
                <div class="checkbox-custom fill checkbox-light mb5">
                  <input type="radio" name="sidebarSkin" id="sidebarSkin2" value="sidebar-light light">
                  <label for="sidebarSkin2">Lighter</label>
                </div>
              </div>
            </form>
          </div>
          <div role="tabpanel" class="tab-pane" id="toolbox-settings">
            <form id="toolbox-settings-misc">
              <h4 class="mv20 mtn">Layout Options</h4>
              <div class="form-group">
                <div class="checkbox-custom fill mb5">
                  <input type="checkbox" checked="" id="header-option">
                  <label for="header-option">Fixed Header</label>
                </div>
              </div>
              <div class="form-group">
                <div class="checkbox-custom fill mb5">
                  <input type="checkbox" checked="" id="sidebar-option">
                  <label for="sidebar-option">Fixed Sidebar</label>
                </div>
              </div>
              <div class="form-group">
                <div class="checkbox-custom fill mb5">
                  <input type="checkbox" id="breadcrumb-option">
                  <label for="breadcrumb-option">Fixed Breadcrumbs</label>
                </div>
              </div>
              <div class="form-group">
                <div class="checkbox-custom fill mb5">
                  <input type="checkbox" id="breadcrumb-hidden">
                  <label for="breadcrumb-hidden">Hide Breadcrumbs</label>
                </div>
              </div>
              <h4 class="mv20">Layout Options</h4>
              <div class="form-group">
                <div class="radio-custom mb5">
                  <input type="radio" id="fullwidth-option" checked name="layout-option">
                  <label for="fullwidth-option">Fullwidth Layout</label>
                </div>
              </div>
              <div class="form-group mb20">
                <div class="radio-custom radio-disabled mb5">
                  <input type="radio" id="boxed-option" name="layout-option" disabled>
                  <label for="boxed-option">Boxed Layout
                    <b class="text-muted">(Coming Soon)</b>
                  </label>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="form-group mn br-t p15">
          <a href="#" id="clearLocalStorage" class="btn btn-primary btn-block pb10 pt10">Clear LocalStorage</a>
        </div>
      </div>
    </div>
  </div>
  <!-- End: Theme Preview Pane -->

  <!-- Start: Main -->
  <div id="main">

    <!-----------------------------------------------------------------+ 
       ".navbar" Helper Classes: 
    -------------------------------------------------------------------+ 
       * Positioning Classes: 
        '.navbar-static-top' - Static top positioned navbar
        '.navbar-static-top' - Fixed top positioned navbar

       * Available Skin Classes:
         .bg-dark    .bg-primary   .bg-success   
         .bg-info    .bg-warning   .bg-danger
         .bg-alert   .bg-system 
    -------------------------------------------------------------------+
      Example: <header class="navbar navbar-fixed-top bg-primary">
      Results: Fixed top navbar with blue background 
    ------------------------------------------------------------------->

    <!-- Start: Header -->
    <header class="navbar navbar-fixed-top navbar-shadow">
      <div class="navbar-branding">
        <a class="navbar-brand" href="dashboard.html">
          <b>Absolute</b>Admin
        </a>
        <span id="toggle_sidemenu_l" class="ad ad-lines"></span>
      </div>
      <ul class="nav navbar-nav navbar-left">
        <li class="dropdown menu-merge hidden-xs">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown
            <span class="caret caret-tp"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
        <li class="hidden-xs">
          <a class="request-fullscreen toggle-active" href="#">
            <span class="ad ad-screen-full fs18"></span>
          </a>
        </li>
      </ul>
      <form class="navbar-form navbar-left navbar-search alt" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search..." value="Search...">
        </div>
      </form>
      <div id="userHead" class="animated fadeIn">
        <?=$this->userHead;?>
      </div>
    </header>
    <!-- End: Header -->

    <!-----------------------------------------------------------------+ 
       "#sidebar_left" Helper Classes: 
    -------------------------------------------------------------------+ 
       * Positioning Classes: 
        '.affix' - Sets Sidebar Left to the fixed position 

       * Available Skin Classes:
         .sidebar-dark (default no class needed)
         .sidebar-light  
         .sidebar-light.light   
    -------------------------------------------------------------------+
       Example: <aside id="sidebar_left" class="affix sidebar-light">
       Results: Fixed Left Sidebar with light/white background
    ------------------------------------------------------------------->

    <!-- Start: Sidebar -->
    <aside id="sidebar_left" class="nano nano-light affix">

      <!-- Start: Sidebar Left Content -->
      <div class="sidebar-left-content nano-content">

        <!-- Start: Sidebar Header -->
        <header class="sidebar-header">

          <!-- Sidebar Widget - Menu (slidedown) -->
          <div class="sidebar-widget menu-widget">
            <div class="row text-center mbn">
              <div class="col-xs-4">
                <a href="dashboard.html" class="text-primary" data-toggle="tooltip" data-placement="top" title="Dashboard">
                  <span class="glyphicon glyphicon-home"></span>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="pages_messages.html" class="text-info" data-toggle="tooltip" data-placement="top" title="Messages">
                  <span class="glyphicon glyphicon-inbox"></span>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="pages_profile.html" class="text-alert" data-toggle="tooltip" data-placement="top" title="Tasks">
                  <span class="glyphicon glyphicon-bell"></span>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="pages_timeline.html" class="text-system" data-toggle="tooltip" data-placement="top" title="Activity">
                  <span class="fa fa-desktop"></span>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="pages_profile.html" class="text-danger" data-toggle="tooltip" data-placement="top" title="Settings">
                  <span class="fa fa-gears"></span>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="pages_gallery.html" class="text-warning" data-toggle="tooltip" data-placement="top" title="Cron Jobs">
                  <span class="fa fa-flask"></span>
                </a>
              </div>
            </div>
          </div>

          <!-- Sidebar Widget - Search (hidden) -->
          <div class="sidebar-widget search-widget hidden">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-search"></i>
              </span>
              <input type="text" id="sidebar-search" class="form-control" placeholder="Search...">
            </div>
          </div>

        </header>
        <!-- End: Sidebar Header -->

        <!-- Start: Sidebar Menu -->
        <ul class="nav sidebar-menu">
          <li class="sidebar-label pt20">Menu</li>
          <li>
            <a href="index.php">
              <span class="fa fa-envelope-o"></span>
              <span class="sidebar-title">INDEx</span>
              <span class="sidebar-title-tray">
                <span class="label label-xs bg-primary">New</span>
              </span>
            </a>
          </li>
          <li>
            <a href="<?=SITE;?>Projects/registration">
              <span class="fa fa-plus text-success"></span>
              <span class="sidebar-title">Add Project</span>
              <span class="sidebar-title-tray">
                <span class="label label-xs bg-danger">New</span>
              </span>
            </a>
          </li>
          <li>
            <a href="1.php">
              <span class="fa fa-plus text-success"></span>
              <span class="sidebar-title">1</span>
            </a>
          </li>
          <li>
            <a href="2.php">
              <span class="fa fa-plus text-success"></span>
              <span class="sidebar-title">2</span>
            </a>
          </li>
          <li>
            <a href="3.php">
              <span class="fa fa-plus text-success"></span>
              <span class="sidebar-title">3</span>
            </a>
          </li>
          <li>
            <a href="4.php">
              <span class="fa fa-plus text-success"></span>
              <span class="sidebar-title">4</span>
            </a>
          </li>
          <li>
            <a href="5.php">
              <span class="fa fa-plus text-success"></span>
              <span class="sidebar-title">5</span>
            </a>
          </li>
          <li>
            <a href="pages_messages(alt).html">
              <span class="fa fa-envelope-o"></span>
              <span class="sidebar-title">Messages</span>
              <span class="sidebar-title-tray">
                <span class="label label-xs bg-primary">New</span>
              </span>
            </a>
          </li>
          <li>
            <a href="http://admindesigns.com/demos/absolute/README/index.html">
              <span class="glyphicon glyphicon-book"></span>
              <span class="sidebar-title">Documentation</span>
            </a>
          </li>
          <li class="active">
            <a href="dashboard.html">
              <span class="glyphicon glyphicon-home"></span>
              <span class="sidebar-title">Dashboard</span>
            </a>
          </li>
          <li class="sidebar-label pt15">Exclusive Tools</li>
          <li>
            <a class="accordion-toggle" href="#">
              <span class="glyphicon glyphicon-fire"></span>
              <span class="sidebar-title">Admin Plugins</span>
              <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
              <li>
                <a href="admin_plugins-panels.html">
                  <span class="glyphicon glyphicon-book"></span> Admin Panels </a>
              </li>
              <li>
                <a href="admin_plugins-modals.html">
                  <span class="glyphicon glyphicon-modal-window"></span> Admin Modals </a>
              </li>
              <li>
                <a href="admin_plugins-dock.html">
                  <span class="glyphicon glyphicon-equalizer"></span> Admin Dock </a>
              </li>
            </ul>
          </li>
          <li>
            <a class="accordion-toggle" href="#">
              <span class="glyphicon glyphicon-check"></span>
              <span class="sidebar-title">Admin Forms</span>
              <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
              <li>
                <a href="admin_forms-elements.html">
                  <span class="glyphicon glyphicon-shopping-cart"></span> Admin Elements </a>
              </li>
              <li>
                <a href="admin_forms-widgets.html">
                  <span class="glyphicon glyphicon-calendar"></span> Admin Widgets </a>
              </li>
              <li>
                <a href="admin_forms-layouts.html">
                  <span class="fa fa-desktop"></span> Admin Layouts </a>
              </li>
              <li>
                <a href="admin_forms-wizard.html">
                  <span class="fa fa-clipboard"></span> Admin Wizard </a>
              </li>
              <li>
                <a href="admin_forms-validation.html">
                  <span class="glyphicon glyphicon-check"></span> Admin Validation </a>
              </li>
            </ul>
          </li>

          <li class="sidebar-label pt20">Systems</li>
          <li>
            <a class="accordion-toggle" href="#">
              <span class="fa fa-diamond"></span>
              <span class="sidebar-title">Widget Packages</span>
              <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
              <li>
                <a href="widgets_tile.html">
                  <span class="fa fa-cube"></span> Tile Widgets</a>
              </li>
              <li>
                <a href="widgets_panel.html">
                  <span class="fa fa-desktop"></span> Panel Widgets </a>
              </li>
              <li>
                <a href="widgets_scroller.html">
                  <span class="fa fa-columns"></span> Scroller Widgets </a>
              </li>
              <li>
                <a href="widgets_data.html">
                  <span class="fa fa-dot-circle-o"></span> Admin Widgets </a>
              </li>
            </ul>
          </li>
          <li>
            <a class="accordion-toggle" href="#">
              <span class="glyphicon glyphicon-shopping-cart"></span>
              <span class="sidebar-title">Ecommerce</span>
              <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
              <li class="active">
                <a href="ecommerce_dashboard.html">
                  <span class="glyphicon glyphicon-shopping-cart"></span> Dashboard
                  <span class="label label-xs bg-primary">New</span>
                </a>
              </li>
              <li>
                <a href="ecommerce_products.html">
                  <span class="glyphicon glyphicon-tags"></span> Products </a>
              </li>
              <li>
                <a href="ecommerce_orders.html">
                  <span class="fa fa-money"></span> Orders </a>
              </li>
              <li>
                <a href="ecommerce_customers.html">
                  <span class="fa fa-users"></span> Customers </a>
              </li>
              <li>
                <a href="ecommerce_settings.html">
                  <span class="fa fa-gears"></span> Store Settings </a>
              </li>
            </ul>
          </li>
          <li>
            <a href="email_templates.html">
              <span class="fa fa-envelope-o"></span>
              <span class="sidebar-title">Email Templates</span>
            </a>
          </li>

          <!-- sidebar resources -->
          <li class="sidebar-label pt20">Elements</li>
          <li>
            <a class="accordion-toggle" href="#">
              <span class="glyphicon glyphicon-bell"></span>
              <span class="sidebar-title">UI Elements</span>
              <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
              <li>
                <a href="ui_alerts.php">
                  <span class="fa fa-warning"></span> Alerts </a>
              </li>
              <li>
                <a href="ui_animations.php">
                  <span class="fa fa-spinner"></span> Animations </a>
              </li>
              <li>
                <a href="ui_buttons.html">
                  <span class="fa fa-plus-square-o"></span> Buttons </a>
              </li>
              <li>
                <a href="ui_typography.html">
                  <span class="fa fa-text-width"></span> Typography </a>
              </li>
              <li>
                <a href="ui_portlets.html">
                  <span class="fa fa-archive"></span> Portlets </a>
              </li>
              <li>
                <a href="ui_progress-bars.html">
                  <span class="fa fa-bars"></span> Progress Bars </a>
              </li>
              <li>
                <a href="ui_tabs.html">
                  <span class="fa fa-toggle-off"></span> Tabs </a>
              </li>
              <li>
                <a href="ui_icons.html">
                  <span class="fa fa-hand-o-right"></span> Icons </a>
              </li>
              <li>
                <a href="ui_grid.html">
                  <span class="fa fa-th-large"></span> Grid </a>
              </li>
            </ul>
          </li>
          <li>
            <a class="accordion-toggle" href="#">
              <span class="glyphicon glyphicon-hdd"></span>
              <span class="sidebar-title">Form Elements</span>
              <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
              <li>
                <a href="form_inputs.html">
                  <span class="fa fa-magic"></span> Basic Inputs </a>
              </li>
              <li>
                <a href="form_plugins.html">
                  <span class="fa fa-bell-o"></span> Plugin Inputs
                  <span class="label label-xs bg-primary">New</span>
                </a>
              </li>
              <li>
                <a href="form_editors.html">
                  <span class="fa fa-clipboard"></span> Editors </a>
              </li>
              <li>
                <a href="form_treeview.html">
                  <span class="fa fa-tree"></span> Treeview </a>
              </li>
              <li>
                <a href="form_nestable.html">
                  <span class="fa fa-tasks"></span> Nestable </a>
              </li>
              <li>
                <a href="form_image-tools.html">
                  <span class="fa fa-cloud-upload"></span> Image Tools
                  <span class="label label-xs bg-primary">New</span>
                </a>
              </li>
              <li>
                <a href="form_uploaders.html">
                  <span class="fa fa-cloud-upload"></span> Uploaders </a>
              </li>
              <li>
                <a href="form_notifications.html">
                  <span class="fa fa-bell-o"></span> Notifications </a>
              </li>
              <li>
                <a href="form_content-sliders.html">
                  <span class="fa fa-exchange"></span> Content Sliders </a>
              </li>
            </ul>
          </li>
          <li>
            <a class="accordion-toggle" href="#">
              <span class="glyphicon glyphicon-tower"></span>
              <span class="sidebar-title">Plugins</span>
              <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
              <li>
                <a class="accordion-toggle" href="#">
                  <span class="glyphicon glyphicon-globe"></span> Maps
                  <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                  <li>
                    <a href="maps_advanced.html">Admin Maps</a>
                  </li>
                  <li>
                    <a href="maps_basic.html">Basic Maps</a>
                  </li>
                  <li>
                    <a href="maps_vector.html">Vector Maps</a>
                  </li>
                  <li>
                    <a href="maps_full.html">Full Map</a>
                  </li>
                </ul>
              </li>
              <li>
                <a class="accordion-toggle" href="#">
                  <span class="fa fa-area-chart"></span> Charts
                  <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                  <li>
                    <a href="charts_highcharts.html">Highcharts</a>
                  </li>
                  <li>
                    <a href="charts_d3.html">D3 Charts</a>
                  </li>
                  <li>
                    <a href="charts_flot.html">Flot Charts</a>
                  </li>
                </ul>
              </li>
              <li>
                <a class="accordion-toggle" href="#">
                  <span class="fa fa-table"></span> Tables
                  <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                  <li>
                    <a href="tables_basic.html"> Basic Tables</a>
                  </li>
                  <li>
                    <a href="tables_datatables.html"> DataTables </a>
                  </li>
                  <li>
                    <a href="tables_datatables-editor.html"> Editable Tables </a>
                  </li>
                  <li>
                    <a href="tables_pricing.html"> Pricing Tables </a>
                  </li>
                </ul>
              </li>
              <li>
                <a class="accordion-toggle" href="#">
                  <span class="fa fa-flask"></span> Misc
                  <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                  <li>
                    <a href="misc_tour.html"> Site Tour</a>
                  </li>
                  <li>
                    <a href="misc_timeout.html"> Session Timeout</a>
                  </li>
                  <li>
                    <a href="misc_nprogress.html"> Page Progress Loader </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li>
            <a class="accordion-toggle" href="#">
              <span class="glyphicon glyphicon-duplicate"></span>
              <span class="sidebar-title">Pages</span>
              <span class="caret"></span>
            </a>
            <ul class="nav sub-nav">
              <li>
                <a class="accordion-toggle" href="#">
                  <span class="fa fa-gears"></span> Utility
                  <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                  <li>
                    <a href="landing-page/landing1/index.html" target="_blank"> Landing Page </a>
                  </li>
                  <li>
                    <a href="pages_confirmation.html" target="_blank"> Confirmation
                      <span class="label label-xs bg-primary">New</span>
                    </a>
                  </li>
                  <li>
                    <a href="pages_login.html" target="_blank"> Login </a>
                  </li>
                  <li>
                    <a href="pages_login(alt).html" target="_blank"> Login Alt
                      <span class="label label-xs bg-primary">New</span>
                    </a>
                  </li>
                  <li>
                    <a href="pages_register.html" target="_blank"> Register </a>
                  </li>
                  <li>
                    <a href="pages_register(alt).html" target="_blank"> Register Alt
                      <span class="label label-xs bg-primary">New</span>
                    </a>
                  </li>
                  <li>
                    <a href="pages_screenlock.html" target="_blank"> Screenlock </a>
                  </li>
                  <li>
                    <a href="pages_screenlock(alt).html" target="_blank"> Screenlock Alt
                      <span class="label label-xs bg-primary">New</span>
                    </a>
                  </li>
                  <li>
                    <a href="pages_forgotpw.html" target="_blank"> Forgot Password </a>
                  </li>
                  <li>
                    <a href="pages_forgotpw(alt).html" target="_blank"> Forgot Pass Alt
                      <span class="label label-xs bg-primary">New</span>
                    </a>
                  </li>
                  <li>
                    <a href="pages_coming-soon.html" target="_blank"> Coming Soon
                    </a>
                  </li>
                  <li>
                    <a href="pages_404.html"> 404 Error </a>
                  </li>
                  <li>
                    <a href="pages_500.html"> 500 Error </a>
                  </li>
                  <li>
                    <a href="pages_404(alt).html"> 404 Error Alt </a>
                  </li>
                  <li>
                    <a href="pages_500(alt).html"> 500 Error Alt </a>
                  </li>
                </ul>
              </li>
              <li>
                <a class="accordion-toggle" href="#">
                  <span class="fa fa-desktop"></span> Basic
                  <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                  <li>
                    <a href="pages_search-results.html">Search Results
                      <span class="label label-xs bg-primary">New</span>
                    </a>
                  </li>
                  <li>
                    <a href="pages_profile.html"> Profile </a>
                  </li>
                  <li>
                    <a href="pages_timeline.html"> Timeline Split </a>
                  </li>
                  <li>
                    <a href="pages_timeline-single.html"> Timeline Single </a>
                  </li>
                  <li>
                    <a href="pages_faq.html"> FAQ Page </a>
                  </li>
                  <li>
                    <a href="pages_calendar.html"> Calendar </a>
                  </li>
                  <li>
                    <a href="pages_messages.html"> Messages </a>
                  </li>
                  <li>
                    <a href="pages_messages(alt).html"> Messages Alt </a>
                  </li>
                  <li>
                    <a href="pages_gallery.html"> Gallery </a>
                  </li>
                </ul>
              </li>
              <li>
                <a class="accordion-toggle" href="#">
                  <span class="fa fa-usd"></span> Misc
                  <span class="caret"></span>
                </a>
                <ul class="nav sub-nav">
                  <li>
                    <a href="pages_invoice.html"> Printable Invoice </a>
                  </li>
                  <li>
                    <a href="pages_blank.html"> Blank </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

          <!-- sidebar bullets -->
          <li class="sidebar-label pt20">Projects</li>
          <li class="sidebar-proj">
            <a href="#projectOne">
              <span class="fa fa-dot-circle-o text-primary"></span>
              <span class="sidebar-title">Website Redesign</span>
            </a>
          </li>
          <li class="sidebar-proj">
            <a href="#projectTwo">
              <span class="fa fa-dot-circle-o text-info"></span>
              <span class="sidebar-title">Ecommerce Panel</span>
            </a>
          </li>
          <li class="sidebar-proj">
            <a href="#projectTwo">
              <span class="fa fa-dot-circle-o text-danger"></span>
              <span class="sidebar-title">Adobe Mockup</span>
            </a>
          </li>
          <li class="sidebar-proj">
            <a href="#projectThree">
              <span class="fa fa-dot-circle-o text-warning"></span>
              <span class="sidebar-title">SSD Upgrades</span>
            </a>
          </li>

          <!-- sidebar progress bars -->
          <li class="sidebar-label pt25 pb10">User Stats</li>
          <li class="sidebar-stat">
            <a href="#projectOne" class="fs11">
              <span class="fa fa-inbox text-info"></span>
              <span class="sidebar-title text-muted">Email Storage</span>
              <span class="pull-right mr20 text-muted">35%</span>
              <div class="progress progress-bar-xs mh20 mb10">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 35%">
                  <span class="sr-only">35% Complete</span>
                </div>
              </div>
            </a>
          </li>
          <li class="sidebar-stat">
            <a href="#projectOne" class="fs11">
              <span class="fa fa-dropbox text-warning"></span>
              <span class="sidebar-title text-muted">Bandwidth</span>
              <span class="pull-right mr20 text-muted">58%</span>
              <div class="progress progress-bar-xs mh20">
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 58%">
                  <span class="sr-only">58% Complete</span>
                </div>
              </div>
            </a>
          </li>
        </ul>
        <!-- End: Sidebar Menu -->

	      <!-- Start: Sidebar Collapse Button -->
	      <div class="sidebar-toggle-mini">
	        <a href="#">
	          <span class="fa fa-sign-out"></span>
	        </a>
	      </div>
	      <!-- End: Sidebar Collapse Button -->

      </div>
      <!-- End: Sidebar Left Content -->

    </aside>
    <!-- End: Sidebar Left -->

<!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

      <!-- Start: Topbar-Dropdown -->
      <div id="topbar-dropmenu" class="alt">
        <div class="topbar-menu row">
          <div class="col-xs-4 col-sm-2">
            <a href="#" class="metro-tile bg-primary light">
              <span class="glyphicon glyphicon-inbox text-muted"></span>
              <span class="metro-title">Messages</span>
            </a>
          </div>
          <div class="col-xs-4 col-sm-2">
            <a href="#" class="metro-tile bg-info light">
              <span class="glyphicon glyphicon-user text-muted"></span>
              <span class="metro-title">Users</span>
            </a>
          </div>
          <div class="col-xs-4 col-sm-2">
            <a href="#" class="metro-tile bg-success light">
              <span class="glyphicon glyphicon-headphones text-muted"></span>
              <span class="metro-title">Support</span>
            </a>
          </div>
          <div class="col-xs-4 col-sm-2">
            <a href="#" class="metro-tile bg-system light">
              <span class="glyphicon glyphicon-facetime-video text-muted"></span>
              <span class="metro-title">Videos</span>
            </a>
          </div>
          <div class="col-xs-4 col-sm-2">
            <a href="#" class="metro-tile bg-warning light">
              <span class="fa fa-gears text-muted"></span>
              <span class="metro-title">Settings</span>
            </a>
          </div>
          <div class="col-xs-4 col-sm-2">
            <a href="#" class="metro-tile bg-alert light">
              <span class="glyphicon glyphicon-picture text-muted"></span>
              <span class="metro-title">Pictures</span>
            </a>
          </div>
        </div>
      </div>
      <!-- End: Topbar-Dropdown -->

      <!-- Start: Topbar -->
      <header id="topbar" class="alt">
        <div class="topbar-left">
          <ol class="breadcrumb">
            <li class="crumb-active">
              <a href="dashboard.html">Dashboard</a>
            </li>
            <li class="crumb-icon">
              <a href="dashboard.html">
                <span class="glyphicon glyphicon-home"></span>
              </a>
            </li>
            <li class="crumb-link">
              <a href="index.html">Home</a>
            </li>
            <li class="crumb-trail">Dashboard</li>
          </ol>
        </div>
        <div class="topbar-right">
          <div class="ib topbar-dropdown">
            <label for="topbar-multiple" class="control-label pr10 fs11 text-muted">Reporting Period</label>
            <select id="topbar-multiple" class="hidden">
              <optgroup label="Filter By:">
                <option value="1-1">Last 30 Days</option>
                <option value="1-2" selected="selected">Last 60 Days</option>
                <option value="1-3">Last Year</option>
              </optgroup>
            </select>
          </div>
          <div class="ml15 ib va-m" id="toggle_sidemenu_r">
            <a href="javascript:void(0)" class="pl5">
              <i class="fa fa-sign-in fs22 text-primary"></i>
              <span class="badge badge-hero badge-danger">3</span>
            </a>
          </div>
        </div>
      </header>
      <!-- End: Topbar -->

      <!-- Begin: Content -->
      <div id="content" class="animated fadeIn">
		<?php echo $this->content; ?>
      </div>
      <!-- End: Content -->

    </section>
    <!-- End: Content-Wrapper -->

    <!-- Start: Right Sidebar -->
    <aside id="sidebar_right" class="nano affix">

      <!-- Start: Sidebar Right Content -->
      <div class="sidebar-right-content nano-content">

        <div class="tab-block sidebar-block br-n">
          <ul class="nav nav-tabs tabs-border nav-justified hidden">
            <li class="active">
              <a href="#sidebar-right-tab1" data-toggle="tab">Tab 1</a>
            </li>
            <li>
              <a href="#sidebar-right-tab2" data-toggle="tab">Tab 2</a>
            </li>
            <li>
              <a href="#sidebar-right-tab3" data-toggle="tab">Tab 3</a>
            </li>
          </ul>
          <div class="tab-content br-n">
            <div id="sidebar-right-tab1" class="tab-pane active">

              <h5 class="title-divider text-muted mb20"> Server Statistics
                <span class="pull-right"> 2013
                  <i class="fa fa-caret-down ml5"></i>
                </span>
              </h5>
              <div class="progress mh5">
                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 44%">
                  <span class="fs11">DB Request</span>
                </div>
              </div>
              <div class="progress mh5">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 84%">
                  <span class="fs11 text-left">Server Load</span>
                </div>
              </div>
              <div class="progress mh5">
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 61%">
                  <span class="fs11 text-left">Server Connections</span>
                </div>
              </div>

              <h5 class="title-divider text-muted mt30 mb10">Traffic Margins</h5>
              <div class="row">
                <div class="col-xs-5">
                  <h3 class="text-primary mn pl5">132</h3>
                </div>
                <div class="col-xs-7 text-right">
                  <h3 class="text-success-dark mn">
                    <i class="fa fa-caret-up"></i> 13.2% </h3>
                </div>
              </div>

              <h5 class="title-divider text-muted mt25 mb10">Database Request</h5>
              <div class="row">
                <div class="col-xs-5">
                  <h3 class="text-primary mn pl5">212</h3>
                </div>
                <div class="col-xs-7 text-right">
                  <h3 class="text-success-dark mn">
                    <i class="fa fa-caret-up"></i> 25.6% </h3>
                </div>
              </div>

              <h5 class="title-divider text-muted mt25 mb10">Server Response</h5>
              <div class="row">
                <div class="col-xs-5">
                  <h3 class="text-primary mn pl5">82.5</h3>
                </div>
                <div class="col-xs-7 text-right">
                  <h3 class="text-danger mn">
                    <i class="fa fa-caret-down"></i> 17.9% </h3>
                </div>
              </div>

              <h5 class="title-divider text-muted mt40 mb20"> Server Statistics
                <span class="pull-right text-primary fw600">USA</span>
              </h5>


            </div>
            <div id="sidebar-right-tab2" class="tab-pane"></div>
            <div id="sidebar-right-tab3" class="tab-pane"></div>
          </div>
          <!-- end: .tab-content -->
        </div>
      </div>
    </aside>
    <!-- End: Right Sidebar -->

  </div>
  <!-- End: Main -->

  
  
  
  
  <!-- BEGIN: PAGE SCRIPTS -->
  <!-- ### ### ### ### ### ### 		ПО УМОЛЧАНИЮ -->
  
  <!-- jQuery -->
  <script src="<?=SITE;?>assets/jquery/jquery-1.12.0.min.js"></script>
  <script src="<?=SITE;?>assets/jquery/jquery-ui.min.js"></script>
  <!--<script src="vendor/plugins/tagsinput/tagsinput.min.js"></script>-->

  <!-- Theme Javascript -->
  <script src="<?=SITE;?>assets/js/utility.js"></script>
  <script src="<?=SITE;?>assets/js/demo.js"></script>
  <script src="<?=SITE;?>assets/js/main.js"></script>
  
  
  
  <!-- ДОБАВЛЕННЫЕ МНОЮ -->
  
  <!-- jQuery -->
  <script src="<?=SITE;?>assets/magnific/jquery.magnific-popup.js"></script>
  
  <!-- HighCharts Plugin -->
  <script src="<?=SITE;?>assets/js/highcharts.js"></script>
  
  <!-- FullCalendar Plugin + moment Dependency -->
  <script src="<?=SITE;?>assets/fullcalendar/lib/moment.min.js"></script>
  <!--<script src="vendor/plugins/fullcalendar/fullcalendar.min.js"></script>-->
  
  <!-- Widget Javascript -->
  <script src="<?=SITE;?>assets/js/widgets.js"></script>
  <script src="<?=SITE;?>assets/cropper/cropper.js"></script>
    
  
  <script src="<?=SITE;?>assets/js/my-addons.js"></script>

  
  
<script>

/*var tagsInit = function() { 	
	// Init tagsinput plugin
    $("input#tagsinput").tagsinput({
      tagClass: function(item) {
        return 'label label-default';
      },
	  allowDuplicates: true,
	  confirmKeys: [13, 44, 32]
    });
}*/

 /* ------------------------------------------------------------ SCROLLERS ------------------------------------------------------------ */
 var panelScrollerInit = function() {
	var panelScroller = $(this).find('.panel-scroller');
	if (panelScroller.length) {
		 panelScroller.each(function(i, e) {
			var This = $(e);
			var Delay = This.data('scroller-delay');
			var Margin = 5;
			if (This.hasClass('scroller-thick')) {
			   Margin = 0;
			}
			var DropMenuParent = This.parents('.dropdown-menu');
			if (DropMenuParent.length) {
			   DropMenuParent.prev('.dropdown-toggle').on('click', function() {
				  setTimeout(function() {
					 This.scroller();
					 $('.navbar').scrollLock('on', 'div');
				  }, 50);
			   });
			   return;
			}
			if (Delay) {
			   var Timer = setTimeout(function() {
				  This.scroller({
					 trackMargin: Margin,
				  });
				  $('#content').scrollLock('on', 'div');
			   }, Delay);
			} else {
			   This.scroller({
				  trackMargin: Margin,
			   });
			   $('#content').scrollLock('on', 'div');
			}
		 });
	}
}

/* ------------------------------------------------------------ SCROLL CHANGE ------------------------------------------------------------ */
var changeScrollContentHeight = function() {
	if(!$('body').hasClass('panel-fullscreen-active')) {
		$('#content .scroller').each(function() {
			var mh = $('.rating-star:eq(0)').offset().top - $('.col-xs-4 .thumbnail').offset().top;
			$(this).css('max-height', (mh)+'px').scroller("reset");
		});
	}
	else {
		$('#content .panel-fullscreen .scroller').css('max-height', ($(window).height()-80)+'px').scroller("reset");
	}
};

/* ------------------------------------------------------------ DATEPICKER ------------------------------------------------------------ */
var datePickerInit = function() {
	$(".datepicker").datepicker({
      prevText: '<i class="fa fa-chevron-left"></i>',
      nextText: '<i class="fa fa-chevron-right"></i>',
      beforeShow: function(input, inst) {
        var newclass = 'admin-form';
        var themeClass = $(this).parents('.admin-form').attr('class');
        var smartpikr = inst.dpDiv.parent();
        if (!smartpikr.hasClass(themeClass)) {
          inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
        }
      }
    });
}


/* ------------------------------------------------------------ FULLSCREEN BUTTONS ------------------------------------------------------------ */
var adminPanelInit = function() {
	$(this).find('.admin-panels').adminpanel();	
}
</script>
 
 
<script type="text/javascript">
jQuery(document).ready(function() {
    "use strict";  
    Core.init();
    Demo.init();
	
	
$(function () {

  'use strict';

  var console = window.console || { log: function () {} };
  var $full_site_image = $('#full_site_image');
  var $thumb_site_image = $('#thumb_site_image');
  var $download = $('#download');
  
  $full_site_image.cropper();
  $thumb_site_image.cropper({aspectRatio: 4/3});




  // Methods
  $('.docs-buttons').on('click', '[data-method]', function () {
    var $this = $(this);
    var data = $this.data();
    var $target;
    var result;
	var $preview = data.control == 1 ? $full_site_image : $thumb_site_image;

    if ($this.prop('disabled') || $this.hasClass('disabled')) {
      return;
    }
	

    if ($preview.data('cropper') && data.method) {
	  if (data.control == 1) {
		var d = $preview.cropper('getCroppedCanvas');
	    data.option = {width:Math.min(1280,d.width*960/d.height,d.width)};
	  } else {data.option = {width:320};}
	  
      data = $.extend({}, data);

      result = $preview.cropper(data.method, data.option);
	  $download.attr('href', result.toDataURL('image/jpeg', 0.9));
	  $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
    }
  });


  // Import image
  var $inputImage = $('#inputImage');
  var URL = window.URL || window.webkitURL;
  var blobURL;

  if (URL) {
    $inputImage.change(function () {
	  $inputImage.parent().addClass('btn-primary').removeClass('btn-danger');
      var files = this.files;
      var file;

      if (!$full_site_image.data('cropper')) {
        return;
      }

      if (files && files.length) {
        file = files[0];

        if (/^image\/\w+$/.test(file.type)) {
          blobURL = URL.createObjectURL(file);
          $full_site_image.one('built.cropper', function () {
				$thumb_site_image.one('built.cropper', function () {
					URL.revokeObjectURL(blobURL);
					$('button[data-control]').removeClass('disabled');
			  }).cropper('reset').cropper('replace', blobURL);
          }).cropper('reset').cropper('replace', blobURL);
          $inputImage.val('');
        } else {
          window.alert('Please choose an image file.');
        }
      }
    });
  } else {
    $inputImage.prop('disabled', true).parent().addClass('disabled');
  }

});

















        
	
	
	// ###   ###   ###			при клике на ссылку грузим аяксом
	$(function() {
		$('a[href*="/"]').click(function() {
			var url = $(this).attr('href');
			$.ajax({
				url:  url,
				type: "POST",
				data: {ajax:' 1'},
				success: function(data){
					refreshAllowed = true;
					$('#content').html(data);
					startAllNeedFunctions.apply($('#content'));
					$("body,html").animate({
						scrollTop:0
					}, 400);
				}
			});

			if(url != window.location){
				window.history.pushState(null, null, url);
			}

			return false;
		});

		$(window).bind('popstate', function(e) {
			if (refreshAllowed) {
				$.ajax({
					url: location.pathname,
					type: "POST",
					data: {ajax:' 1'},
					success: function(data) {
						$('#content').html(data);
						startAllNeedFunctions.apply($('#content'));
						$("body,html").animate({
							scrollTop:0
						}, 800);
					},
					dataType: "html"
				});
			}
		});
	});
	
	

		
	// ###   ###   ###
	
	// ###   ###   ###	

	
	// ###   ###   ###		выполняем все необходимые скрипты для текущей страницы из массива 
	startAllNeedFunctions.apply(document);
});

function startAllNeedFunctions() {
	while(script = scripts.shift()) {
		window[script].apply(this);
	}
};
</script>

</body>



</html>