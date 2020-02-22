<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9">
<![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->

<head>
  <meta charset="UTF-8">
  <title>Edit - Bots - Listings to Leads</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.typekit.net/uht2mhd.css">
  <link rel="stylesheet" href="{{ secure_asset('css/main.min.css') }}">
  <link rel="shortcut icon" href="img/favicon.ico">
  <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar-primary navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="dashboard.html"><img src="img/logo-xs.png" alt="logo" /></a>
        <a class="navbar-brand" href="dashboard.html"><img class="brand-mhw" src="img/logo-office.png" alt="Office logo" /></a>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      </div>
      <div class="collapse navbar-collapse" id="main-navbar">
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="tooltip" data-placement="bottom" title="Profile, Tutorials / FAQ, Sign Out"><i class="fa fa-user" aria-hidden="true"></i><b class="caret"></b></a>
            <ul class="dropdown-menu dropdown-menu-right">
              <li>
                <a href="profile.html" class="media">
                  <div class="media-left">
                    <img class="media-object" src="img/profile-standard.svg" alt="Profile Photo">
                  </div>
                  <div class="media-body">
                    <h6 class="media-heading">John Doe</h6>
                    <p class="media-text">Company, Inc</p>
                  </div>
                </a>
              </li>
              <li class="divider"></li>
              <li><a href="profile.html">Profile</a></li>
              <li><a href="campaigns.html">Campaigns</a></li>
              <li><a href="home-value-header.html">Home Value Header</a></li>
              <li><a href="#" target="_blank">Tutorials/FAQ</a></li>
              <li class="divider"></li>
              <li><a href="login.html">Sign Out</a></li>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav">
          <li><a href="listings.html">Listings</a></li>
          <li><a href="pages.html">Landing Pages</a></li>
          <li class="active"><a href="bots.html">Bots <span class="badge badge-small label-success">BETA</span></a></li>
          <li><a href="ads.html">Ads <span class="badge badge-small label-success">BETA</span></a></li>
          <li><a href="followups.html">Follow-Ups</a></li>
          <li><a href="leads.html">Leads</a></li>
          <li><a href="lead-links.html">Lead Links</a></li>
          <li><a href="text-ivr.html">Text / IVR</a></li>
          <li><a href="tabs.html">Tabs</a></li>
          <li><a href="analytics.html">Analytics</a></li>
          <li><a href="support.html">Support</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="dashboard.html">Home</a></li>
      <li><a href="bots.html">Bots</a></li>
      <li class="active">General Bot</li>
    </ol>
  </div>
  <main>
    <div class="container">
      <div class="panel panel-primary">
        <div class="panel-body">
          <div class="panel-heading">
            <span data-hover="tooltip" data-placement="top" title="Turn the bot on or off" class="bootstrap-switch-btn">
              <input type="checkbox" data-name="botstatus" data-size="mini" data-type="switch" checked>
            </span>
            <h4 class="panel-title d-inline-block ml15">General Bot - <small><a href="#" target="_blank"> <span class="badge badge-link label-primary"><i class="fa fa-facebook"></i> Granite Bay <i class="fa fa-external-link"></i></span></a></small></h4>
          </div>
          <div id="workspace">
            <div class="alert alert-warning">
              <i class="alert-icon fa fa-exclamation-triangle text-warning" aria-hidden="true"></i>
              <b>Your Facebook account isn't connected.</b> Please <a href="https://www.facebook.com/v2.10/dialog/oauth?client_id=2136593863088637&amp;state=c1aeaedcce9fefdbceef637d5950a2a2&amp;response_type=code&amp;sdk=php-sdk-5.7.0&amp;redirect_uri=https%3A%2F%2Fbeta.listingstoleads.com%2Fbot%2Ffacebook%2Flogin%2Fcallback&amp;scope=public_profile%2Cemail%2Cmanage_pages%2Cpages_show_list%2Cpages_messaging&amp;state=207546">connect it</a> to activate the bots.
            </div>
            <div class="alert alert-info">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <i class="alert-icon fa fa-lightbulb-o text-info" aria-hidden="true"></i>Reply with <strong>Let me help you</strong> from your bot page to stop the bot and take over the conversation with a lead, <a href="#" class="plull-right">learn how</a>.
            </div>
            <ul class="nav nav-tabs mb15" role="tablist" id="tabBots">
              <li role="presentation" class="active">
                <a href="#tabSubscribers" aria-controls="tabBots" role="tab" data-toggle="tab">
                  <i class="fa fa-users" aria-hidden="true"></i>
                  <span class="hidden-xs"></span>Subscribers</span>
                </a>
              </li>
              <li role="presentation">
                <a href="#tabBroadcast" aria-controls="tabBots" role="tab" data-toggle="tab">
                  <i class="fa fa-bullhorn" aria-hidden="true"></i>
                  <span class="hidden-xs"></span>Broadcasts</span>
                </a>
              </li>
              <li role="presentation">
                <a href="#tabAnalytics" aria-controls="tabBots" role="tab" data-toggle="tab">
                  <i class="fa fa-bar-chart" aria-hidden="true"></i>
                  <span class="hidden-xs"></span>Analytics</span>
                </a>
              </li>
              <li role="presentation">
                <a href="#tabPlugin" aria-controls="tabBots" role="tab" data-toggle="tab">
                  <i class="fa fa-comment" aria-hidden="true"></i>
                  <span class="hidden-xs"></span>Chat Plugin</span>
                </a>
              </li>
              <li role="presentation">
                <a href="#tabHistory" aria-controls="tabBots" role="tab" data-toggle="tab">
                  <i class="fa fa-history" aria-hidden="true"></i>
                  <span class="hidden-xs"></span>History</span>
                </a>
              </li>
              <li role="presentation">
                <a href="#tabSettings" aria-controls="tabSettings" role="tab" data-toggle="tab" aria-expanded="false">
                  <i class="fa fa-cog" aria-hidden="true"></i>
                  <span class="hidden-xs">Settings</span>
                </a>
              </li>
            </ul>
            <div class="tab-content">
              <!--subs tab start-->
              <div role="tabpanel" class="tab-pane active" id="tabSubscribers">
                <div class="panel panel-primary panel-body">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-sm-7 col-md-8">
                        <h4 class="panel-title">Subscribers</h4>
                      </div>
                      <div class="col-sm-5 col-md-4 text-right-sm">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Type &amp; hit enter to Search">
                          <div class="input-group-btn">
                            <button class="btn btn-default" type="button" data-hover="tooltip" data-placement="top" title="search"><i class="fa fa-search" aria-hidden="true"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <i class="alert-icon fa fa-lightbulb-o text-info" aria-hidden="true"></i>You can always turn off the bot for a particular subscriber, <a href="#" class="plull-right">learn how</a>.
                  </div>
                  <div class="panel panel-primary">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-vertical-center">
                        <thead>
                          <tr>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>
                              <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Name</a>
                            </th>
                            <th>
                              <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Email</a>
                            </th>
                            <th><a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Phone</a></th>
                            <th>
                              <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Type</a>
                            </th>
                            <th>Address</th>
                            <th>
                              <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Subscribed</a>
                            </th>
                            <th>
                              <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Updated</a>
                            </th>
                            <th>
                              <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Status</a>
                            </th>
                            <th width="171"></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($result as $sub)
                          <tr>
                            <td>
                            <input type="checkbox" data-name="botStatus" class="turnoffsub" data-id='{{$sub->id}}' {{$sub->bot_stopped ? 'checked' : ''}}></span>
                            </td>
                            <td class="text-center">
                              <a href="#" target="_blank"><img src="img/agent-profile.jpg" class="img-circle" height="30" width="30" alt=""></a>
                            </td>
                            <td>
                              <a href="#">{{$sub->first_name}} {{$sub->last_name}}</a>
                            </td>
                            <td>
                              {{$sub->email}}
                            </td>
                            <td>
                              {{$sub->phone}}
                            </td>
                            <td>
                              {{$sub->type}}
                            </td>
                            <td>
                              {{$sub->address}}
                            </td>
                            <td>
                              {{$sub->created_at}}
                            </td>
                            <td>{{$sub->updated_at}}</td>
                            <td>
                              Subscriber
                            </td>
                            <td>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-toggle="modal" data-target="#modalSubsView" data-hover="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-toggle="modal" data-target="#modalConversation" data-hover="tooltip" data-original-title="Conversation"><i class="fa fa-comments" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-id="{{$sub->id}}" id="delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <ul class="pagination pagination-sm">
                        <li><a href="#"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                      </ul>
                    </div>
                    <div class="col-sm-6 text-right-md">
                      <form action="#" class="form-inline small">
                        <select name="tableLength" class="form-control input-sm">
                          <option value="25">25</option>
                          <option value="50">50</option>
                          <option value="100">100</option>
                        </select> Records per page &mdash;
                        <small>Showing <strong>1 of 25</strong> entries</small>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!--subs tab end-->
              <!--Broadcasts tab start-->
              <div role="tabpanel" class="tab-pane" id="tabBroadcast">
                <div class="panel panel-primary panel-body">
                  <div class="panel-heading">
                    <div class="row row-sm">
                      <div class="col-sm-4 col-md-5 col-lg-6">
                        <h4 class="panel-title">Broadcasts</h4>
                      </div>
                      <div class="col-sm-4 col-md-4 text-right-sm">
                        <div class="input-group mb-xs-15">
                          <input type="text" class="form-control" placeholder="Type &amp; hit enter to Search">
                          <div class="input-group-btn">
                            <button class="btn btn-default" type="button" data-hover="tooltip" data-placement="top" title="search"><i class="fa fa-search" aria-hidden="true"></i></button>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-4 col-md-3 col-lg-2 text-right-sm">
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#addBroadcast">Add Broadcast</button>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-primary">
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-vertical-center">
                        <thead>
                          <tr>
                            <th width="32" data-hover="tooltip" data-placement="left" title="Select All">
                              <label><input type="checkbox" data-name="selectAll"></label>
                            </th>
                            <th>
                              <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Date</a>
                            </th>
                            <th>
                              <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Title</a>
                            </th>
                            <th>
                              <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Type</a>
                            </th>
                            <th>
                              <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Content</a>
                            </th>
                            <th>recipient</th>
                            <th width="130"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td width="25">
                              <label data-hover="tooltip" data-placement="left" title="select">
                                <input type="checkbox" data-name="select">
                              </label>
                            </td>
                            <td>
                              11 June 2019
                            </td>
                            <td>
                              Thank you
                            </td>
                            <td>
                              Subscription Broadcast
                            </td>
                            <td>
                              Thank you for your interest...
                            </td>
                            <td>
                              300
                            </td>
                            <td>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td width="25">
                              <label data-hover="tooltip" data-placement="left" title="select">
                                <input type="checkbox" data-name="select">
                              </label>
                            </td>
                            <td>
                              11 June 2019
                            </td>
                            <td>
                              Thank you
                            </td>
                            <td>
                              Promotional Broadcast
                            </td>
                            <td>
                              Thank you for your interest...
                            </td>
                            <td>
                              300
                            </td>
                            <td>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td width="25">
                              <label data-hover="tooltip" data-placement="left" title="select">
                                <input type="checkbox" data-name="select">
                              </label>
                            </td>
                            <td>
                              11 June 2019
                            </td>
                            <td>
                              Thank you
                            </td>
                            <td>
                              Follow-up Broadcast
                            </td>
                            <td>
                              Thank you for your interest...
                            </td>
                            <td>
                              300
                            </td>
                            <td>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td width="25">
                              <label data-hover="tooltip" data-placement="left" title="select">
                                <input type="checkbox" data-name="select">
                              </label>
                            </td>
                            <td>
                              11 June 2019
                            </td>
                            <td>
                              Thank you
                            </td>
                            <td>
                              Subscription Broadcast
                            </td>
                            <td>
                              Thank you for your interest...
                            </td>
                            <td>
                              300
                            </td>
                            <td>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td width="25">
                              <label data-hover="tooltip" data-placement="left" title="select">
                                <input type="checkbox" data-name="select">
                              </label>
                            </td>
                            <td>
                              11 June 2019
                            </td>
                            <td>
                              Thank you
                            </td>
                            <td>
                              Promotional Broadcast
                            </td>
                            <td>
                              Thank you for your interest...
                            </td>
                            <td>
                              300
                            </td>
                            <td>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td width="25">
                              <label data-hover="tooltip" data-placement="left" title="select">
                                <input type="checkbox" data-name="select">
                              </label>
                            </td>
                            <td>
                              11 June 2019
                            </td>
                            <td>
                              Thank you
                            </td>
                            <td>
                              Follow-up Broadcast
                            </td>
                            <td>
                              Thank you for your interest...
                            </td>
                            <td>
                              300
                            </td>
                            <td>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td width="25">
                              <label data-hover="tooltip" data-placement="left" title="select">
                                <input type="checkbox" data-name="select">
                              </label>
                            </td>
                            <td>
                              11 June 2019
                            </td>
                            <td>
                              Thank you
                            </td>
                            <td>
                              Subscription Broadcast
                            </td>
                            <td>
                              Thank you for your interest...
                            </td>
                            <td>
                              300
                            </td>
                            <td>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td width="25">
                              <label data-hover="tooltip" data-placement="left" title="select">
                                <input type="checkbox" data-name="select">
                              </label>
                            </td>
                            <td>
                              11 June 2019
                            </td>
                            <td>
                              Thank you
                            </td>
                            <td>
                              Promotional Broadcast
                            </td>
                            <td>
                              Thank you for your interest...
                            </td>
                            <td>
                              300
                            </td>
                            <td>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                          </tr>
                          <tr>
                            <td width="25">
                              <label data-hover="tooltip" data-placement="left" title="select">
                                <input type="checkbox" data-name="select">
                              </label>
                            </td>
                            <td>
                              11 June 2019
                            </td>
                            <td>
                              Thank you
                            </td>
                            <td>
                              Follow-up Broadcast
                            </td>
                            <td>
                              Thank you for your interest...
                            </td>
                            <td>
                              300
                            </td>
                            <td>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                              <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6">
                      <ul class="pagination pagination-sm">
                        <li><a href="#"><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                      </ul>
                    </div>
                    <div class="col-sm-6 text-right-md">
                      <form action="#" class="form-inline small">
                        <select name="tableLength" class="form-control input-sm">
                          <option value="25">25</option>
                          <option value="50">50</option>
                          <option value="100">100</option>
                        </select> Records per page &mdash;
                        <small>Showing <strong>1 of 25</strong> entries</small>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!--Broadcast tab ends-->
              <!--Analytics tab start-->
              <div role="tabpanel" class="tab-pane" id="tabAnalytics">
                <div class="panel panel-primary panel-body">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-sm-4">
                        <h4 class="panel-title">Analytics</h4>
                      </div>
                      <div class="col-sm-2">
                        <h6 class="mb0"><i class="fa fa-users" aria-hidden="true"></i> 80 </h6>
                        <small class="text-default">Subscribers</small>
                      </div>
                      <div class="col-sm-2">
                        <h6 class="mb0"><i class="fa fa-comments" aria-hidden="true"></i> 150 </h6>
                        <small class="text-default">Conversations</small>
                      </div>
                      <div class="col-sm-2">
                        <h6 class="mb0"><i class="fa fa-eye" aria-hidden="true"></i> 50 </h6>
                        <small class="text-default">Leads</small>
                      </div>
                      <div class="col-sm-2">
                        <h6 class="mb0"><i class="fa fa-bullhorn" aria-hidden="true"></i> 10 </h6>
                        <small class="text-default">Broadcasts</small>
                      </div>
                    </div>
                  </div>
                  <div class="section">
                    <div class="form-group">
                      <div id="botAnalytics"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!--Analytics tab ends-->
              <!--History tab start-->
              <div role="tabpanel" class="tab-pane" id="tabHistory">
                <div class="timeline mb15" id="actions">
                  <div class="timeline-item">
                    <div class="timeline-icon"><i class="fa fa-refresh" aria-hidden="true"></i></div>
                    <div class="timeline-content">
                      <div class="timeline-header">
                        <h4 class="timeline-title">Enabled presistent menu.</h4>
                      </div>
                      <div class="timeline-footer">
                        <i class="fa fa-clock-o" aria-hidden="true"></i> SEP 16, 2019 - 04:30 PST
                      </div>
                    </div>
                  </div>
                  <div class="timeline-item">
                    <div class="timeline-icon"><i class="fa fa-refresh" aria-hidden="true"></i></div>
                    <div class="timeline-content">
                      <div class="timeline-header">
                        <h4 class="timeline-title">Added listing conversation - 4705 Gold River Lane, Granite Bay, CA</h4>
                      </div>
                      <div class="timeline-footer">
                        <i class="fa fa-clock-o" aria-hidden="true"></i> SEP 16, 2019 - 04:25 PST
                      </div>
                    </div>
                  </div>
                  <div class="timeline-item">
                    <div class="timeline-icon"><i class="fa fa-refresh" aria-hidden="true"></i></div>
                    <div class="timeline-content">
                      <div class="timeline-header">
                        <h4 class="timeline-title">Updated Greeting message - "Hi user_first_name! 👋 Please click below for more information on listing_address 🏡 ❤️."</h4>
                      </div>
                      <div class="timeline-footer">
                        <i class="fa fa-clock-o" aria-hidden="true"></i> SEP 16, 2019 - 04:10 PST
                      </div>
                    </div>
                  </div>
                  <div class="timeline-item">
                    <div class="timeline-icon"><i class="fa fa-plus" aria-hidden="true"></i></div>
                    <div class="timeline-content">
                      <div class="timeline-header">
                        <h4 class="timeline-title">Created.</h4>
                      </div>
                      <div class="timeline-footer">
                        <i class="fa fa-clock-o" aria-hidden="true"></i> SEP 16, 2019 - 04:00 PST
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--History tab ends-->
              <div role="tabpanel" class="tab-pane" id="tabSettings">
                <div class="row row-xs">
                  <div class="col-sm-4">
                    <fieldset>
                      <legend>Bot Settings</legend>
                      <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" id="title" value="{{$result[0]->bot->title}}">
                      </div>
                      <div class="form-group">
                        <label for="bot_type">Facebook Page</label>
                        <select class="form-control" disabled>
                          <option data-name="graniteBay">{{$result[0]->bot->page->name}}</option>
                        </select>
                      </div>
                    </fieldset>
                    <fieldset>
                      <legend>Conversations</legend>
                      <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="alert-icon fa fa-lightbulb-o text-info" aria-hidden="true"></i>Use Payloads to trigger the conversation directly from Facebook Ads, <a href="https://listingstoleads.desk.com/customer/portal/articles/2980732-bots-ads-messenger-facebook-ads-using-the-listing-bot" target="_blank" class="plull-right">learn how</a>.
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" {{ in_array('listing', $listOfIntent) ? 'checked' : '' }}> Listing &nbsp;<span data-toggle="tooltip-img-auto" title="<p class='mb5' style='max-width:350px'>Use Payload Keyword 'Listing' to Use this conversation.</p><a href='https://listingstoleads.desk.com/customer/portal/articles/2980732-bots-ads-messenger-facebook-ads-using-the-listing-bot' target='_blank'><img width='350' src='img/tooltip-bot-payload.jpg'></a>" class="badge label-default">Bot Payload Keyword: Listing &nbsp;<i class="fa fa-question-circle small"></i></span></label>
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" {{ in_array('valuation', $listOfIntent) ? 'checked' : '' }}> Home Valuation &nbsp;<span data-toggle="tooltip-img-auto" title="<p class='mb5' style='max-width:350px'>Use Payload Keyword 'Valuation' to Use this conversation.</p><a href='https://listingstoleads.desk.com/customer/portal/articles/2980753-bots-ads-messenger-facebook-ads-using-home-valuation-bots' target='_blank'><img width='350' src='img/tooltip-bot-payload.jpg'></a>" class="badge label-default">Bot Payload Keyword: Valuation &nbsp;<i class="fa fa-question-circle small"></i></span></label>
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" {{ in_array('buyer', $listOfIntent) ? 'checked' : '' }}> Buyer &nbsp;<span data-toggle="tooltip-img-auto" title="<p class='mb5' style='max-width:350px'>Use Payload Keyword 'Buyer' to Use this conversation.</p><img width='350' src='img/tooltip-bot-payload.jpg'>" class="badge label-default">Bot Payload Keyword: Buyer &nbsp;<i class="fa fa-question-circle small"></i></span></label>
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" {{ in_array('seller', $listOfIntent) ? 'checked' : '' }}> Seller &nbsp;<span data-toggle="tooltip-img-auto" title="<p class='mb5' style='max-width:350px'>Use Payload Keyword 'Seller' to Use this conversation.</p><img width='350' src='img/tooltip-bot-payload.jpg'>" class="badge label-default">Bot Payload Keyword: Seller &nbsp;<i class="fa fa-question-circle small"></i></span></label>
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-sm-8">
                    <fieldset>
                      <legend>Customize Messages</legend>
                      <div class="alert alert-info">
                        <i class="alert-icon fa fa-lightbulb-o text-info" aria-hidden="true"></i>
                        Use user_first_name, user_last_name, user_full_name to add some personal touch to your bot.
                      </div>
                      <div class="form-group">
                        <label>Welcome Message <i class="fa fa-question-circle small" data-hover="tooltip" data-placement="top" title="We'll display this to people who interact with your bot for the first time and also use it as a welcome message." aria-hidden="true"></i></label>
                        <textarea id="greeting_text" data-expand="true" class="form-control" placeholder="" rows="3">Hi user_first_name! 👋 I'm your bot assistant 🤖 from page. 
I’d be happy to help you buy or sell a home, give you a free home value estimate or show you more information about listing_address.</textarea>
                      </div>
                      <div class="form-group">
                        <label>Last Conversation Message</label>
                        <textarea maxlength="200" data-expand="true" class="form-control" placeholder="" rows="1">I'll be here if you need anything else.</textarea>
                      </div>
                    </fieldset>
                    <fieldset>
                      <legend>Preferences</legend>
                      <div class="checkbox">
                        <label><input type="checkbox" checked> Enable persistent menu</label>
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" checked> Show listing suggestions for buyers based on their location</label>
                      </div>
                      <div class="checkbox">
                        <label><input type="checkbox" checked> Send partial leads of unfinished conversations every 24 hours</label>
                      </div>
                    </fieldset>
                  </div>
                </div>
                <div class="panel-footer">
                  <button class="btn btn-lg btn-primary" id="saveEditBot">Save</button>
                  <button type="button" class="btn btn-default pull-right" data-name="bot-delete">Delete</button>
                </div>
              </div>
              <!--tabHistory ends-->
              <div role="tabpanel" class="tab-pane" id="tabPlugin">
                <div class="row row-xs">
                  <div class="col-sm-4">
                    <fieldset>
                      <legend>Chat Plugin Settings</legend>
                      <div class="form-group">
                        <label>Greeting</label>
                        <input type="text" class="form-control" maxlength="80" value="Hello there! I'm happy to answer your questions about buying or selling a home.">
                      </div>
                      <div class="form-group">
                        <label>Whitelisted URLs <i class="fa fa-question-circle small" data-hover="tooltip" data-placement="top" title="Add comma ',' or click enter to separate the URLs" aria-hidden="true"></i></label>
                        <input type="text" placeholder="Add URL and hit enter." data-role="tagsinput">
                      </div>
                    </fieldset>
                  </div>
                  <div class="col-sm-8">
                    <fieldset>
                      <Legend>Copy and add to your website</legend>
                      <div class="alert alert-info">
                        <i class="alert-icon fa fa-lightbulb-o text-info" aria-hidden="true"></i>Insert it directly after the opening of the &lt;body&gt; tag on each page where you want the plugin to appear.
                      </div>
                      <div class="copy">
                        <div class="copy-body">
                          <button type="button" class="btn btn-primary"> <i class="fa fa-copy"></i>&nbsp; Copy Code to Clipboard</button>
                          <span class="hide">Code has copied to Clipboard successfully!</span>
                        </div>
                        <pre><code>&lt;!-- Load Facebook SDK for JavaScript --&gt;
            &lt;div id="fb-root"&gt;&lt;/div&gt;
            &lt;script&gt;
            if (typeof window.fbAsyncInit === 'undefined') {
            window.fbAsyncInit = function() {
              FB.init({
                  xfbml : true,
                  version : 'v3.3'
              });};
            }
            (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            ​
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk-customer-chat'));&lt;/script&gt;
            &lt;!-- Your customer chat code --&gt;
            &lt;div class="fb-customerchat"
            attribution=setup_tool
            page_id="196079677504686"
            theme_color="#fa3c4c"
            logged_in_greeting="Hi! I’d be happy to answer your questions about 454 Circle Drive?"
            logged_out_greeting="Hi! I’d be happy to answer your questions about 454 Circle Drive?"&gt;
            &lt;/div&gt;</code>
                          </pre>
                      </div>
                    </fieldset>
                  </div>
                </div>
                <div class="panel-footer">
                  <button class="btn btn-lg btn-primary">Save</button>
                  <button class="btn btn-lg btn-primary">Copy</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </main>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <h5 class="mb15 mt5">
            <img src="img/logo-footer.png" alt="Logo">
          </h5>
          <p class="small text-muted">Copyright &copy; 2018<br>All Rights Reserved Listings To Leads</p>
        </div>
        <div class="col-sm-9">
          <div class="row">
            <div class="col-sm-3">
              <section>
                <h5>L2L</h5>
                <ul>
                  <li><a href="profile.html">Profile</a></li>
                  <li><a href="listings.html">Listings</a></li>
                  <li><a href="pages.html">Landing Pages</a></li>
                  <li><a href="bots.html">Bots <span class="badge badge-small label-success">BETA</span></a></li>
                  <li><a href="ads.html">Ads <span class="badge badge-small label-success">BETA</span></a></li>
                  <li><a href="followups.html">Follow-Ups</a></li>
                  <li><a href="leads.html">Leads</a></li>
                  <li><a href="lead-links.html">Lead Links</a></li>
                  <li><a href="text-ivr.html">Text / IVR</a></li>
                  <li><a href="tabs.html">Tabs</a></li>
                  <li><a href="analytics.html">Analytics</a></li>
                </ul>
              </section>
            </div>
            <div class="col-sm-3">
              <section>
                <h5>Company</h5>
                <ul>
                  <li><a href="#" target="_blank">About</a></li>
                  <li><a href="#" target="_blank">Blog</a></li>
                </ul>
              </section>
            </div>
            <div class="col-sm-3">
              <section>
                <h5>Help</h5>
                <ul>
                  <li><a href="support.html">Contact Support</a></li>
                  <li><a href="#" target="_blank">L2L Masterminds</a></li>
                  <li><a href="#" target="_blank">Tutorials/FAQ</a></li>
                </ul>
              </section>
            </div>
            <div class="col-sm-3">
              <section>
                <h5>Legal</h5>
                <ul>
                  <li><a href="#" target="_blank">Privacy Policy</a></li>
                  <li><a href="#" target="_blank">Terms of Use </a></li>
                </ul>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!--Modals-->
  <div class="modal  fade" id="addBroadcast" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-default" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div class="modal-header">
            <h3 class="modal-title">Add Broadcast</h3>
          </div>
          <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" placeholder="Title" value="">
          </div>
          <div class="form-group">
            <label>Type</label>
            <div class="radio">
              <label class="radio-inline"><input type="radio" name="broadcastType" value="option1" checked> Subscriptional Broadcast</label>
            </div>
            <div class="radio">
              <label class="radio-inline"><input type="radio" name="broadcastType" value="option2"> Promotional Broadcast</label>
            </div>
            <div class="radio">
              <label class="radio-inline"><input type="radio" name="broadcastType" value="option3"> Non-Promotional Broadcast <i class="fa fa-question-circle small" data-hover="tooltip" data-placement="top" title="Broadcast description"></i></label>
            </div>
            <div class="radio">
              <label class="radio-inline"><input type="radio" name="broadcastType" value="option4"> Follow-Up Broadcast</label>
            </div>
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea class="form-control" placeholder="" rows="4"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Send</button>
            <button type="button" class="btn btn-default">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- modals -->
  <div class="modal fade modal-alt" id="modalSubsView" tabindex="-1" role="dialog" style="padding-right: 17px;">
    <div class="modal-dialog" role="document" style="margin-top: 0px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h3 class="modal-title">View Details</h3>
        </div>
        <div class="modal-body">
          <div class="section">
            <div class="panel panel-warning">
              <table class="table table-sm table-striped mb0 table-hover table-vertical-center">
                <thead>
                  <tr>
                    <th colspan="2">Follow Up Mail Details</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th colspan="2">Subject Line</th>
                  </tr>
                  <tr>
                    <td colspan="2">Your Home Value Estimate Update: 732 Duncan St. SAN FRANCISCO, CA - June 2018</td>
                  </tr>
                  <tr>
                    <th colspan="2">Home Value Estimate</th>
                  </tr>
                  <tr>
                    <td>Lowest:</td>
                    <td class="text-right">$2,164,135</td>
                  </tr>
                  <tr>
                    <td>Average:</td>
                    <td class="text-right">$2,535,354</td>
                  </tr>
                  <tr>
                    <td>Highest:</td>
                    <td class="text-right">$2,956,464</td>
                  </tr>
                  <tr>
                  </tr>
                  <tr>
                    <th width="195"># Mail Sent</th>
                    <td class="text-right">5</td>
                  </tr>
                  <tr>
                    <th># Times Mail Open</th>
                    <td class="text-right">8</td>
                  </tr>
                  <tr>
                    <th># Clicks on Onsite Valuation</th>
                    <td class="text-right">7</td>
                  </tr>
                  <tr>
                    <th># Clicks on All Homes</th>
                    <td class="text-right">2</td>
                  </tr>
                  <tr>
                    <th># Clicks on Zillow Review</th>
                    <td class="text-right">0</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="section">
            <div class="table-responsive">
              <table class="table table-sm table-striped panel panel-primary table-hover table-vertical-center">
                <thead>
                  <tr>
                    <th colspan="2">Seller</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th width="86">Name</th>
                    <td class="text-right">Not Provided</td>
                  </tr>
                  <tr>
                    <th width="86">Email</th>
                    <td class="text-right">ruchish@listingstoleads.com</td>
                  </tr>
                  <tr>
                    <th width="86">Address</th>
                    <td class="text-right">728 Duncan St,<br> San Francisco, CA,<br> United States</td>
                  </tr>
                  <tr>
                    <th width="86">Location</th>
                    <td class="text-right"><a href="#" target="_blank">Nearby Sales - V2 Green Test 2</a></td>
                  </tr>
                  <tr>
                    <th width="86">IP Adress</th>
                    <td class="text-right"><a target="_blank" href="http://whatismyipaddress.com/ip/202.131.123.194">202.131.123.194</a></td>
                  </tr>
                  <tr>
                    <th width="86">Date/Time</th>
                    <td class="text-right">06-05-2018 14:36 UTC</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <h4 class="section__title">Cole Information</h4>
          <table class="table table-sm table-striped panel panel-primary table-hover table-vertical-center">
            <thead>
              <tr>
                <th colspan="2">Other Details</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th width="160">Name</th>
                <td class="text-right">ROGER D DANSEY</td>
              </tr>
              <tr>
                <th>Email Address</th>
                <td class="text-right">NA</td>
              </tr>
              <tr>
                <th>Gender</th>
                <td class="text-right">M</td>
              </tr>
              <tr>
                <th>Estimated Age</th>
                <td class="text-right">04/1/1956</td>
              </tr>
              <tr>
                <th>House Number</th>
                <td class="text-right">728</td>
              </tr>
              <tr>
                <th>Street Direction</th>
                <td class="text-right">NA</td>
              </tr>
              <tr>
                <th>Street Name</th>
                <td class="text-right">DUNCAN ST</td>
              </tr>
              <tr>
                <th>Apartment Number</th>
                <td class="text-right">NA</td>
              </tr>
              <tr>
                <th>Apartment Building Type</th>
                <td class="text-right">NA</td>
              </tr>
              <tr>
                <th>City</th>
                <td class="text-right">SAN FRANCISCO</td>
              </tr>
              <tr>
                <th>State</th>
                <td class="text-right">CA</td>
              </tr>
              <tr>
                <th>ZipCode</th>
                <td class="text-right">94131</td>
              </tr>
              <tr>
                <th>ZipCode4</th>
                <td class="text-right">1843</td>
              </tr>
              <tr>
                <th>Home owner Confirmed</th>
                <td class="text-right">Yes</td>
              </tr>
              <tr>
                <th>CensusTract</th>
                <td class="text-right">0216</td>
              </tr>
              <tr>
                <th>Number Of Units</th>
                <td class="text-right">1</td>
              </tr>
              <tr>
                <th>Length Of Residence</th>
                <td class="text-right">5</td>
              </tr>
              <tr>
                <th>Cross Street</th>
                <td class="text-right">DIAMOND ST</td>
              </tr>
              <tr>
                <th>Purchase Date</th>
                <td class="text-right">04/16/2013</td>
              </tr>
              <tr>
                <th>Purchase Amount</th>
                <td class="text-right">$2500K</td>
              </tr>
              <tr>
                <th>County Assessor Home Value</th>
                <td class="text-right">$2652K</td>
              </tr>
              <tr>
                <th>Building Square Footage</th>
                <td class="text-right">3300</td>
              </tr>
              <tr>
                <th>Auto Renewal Month</th>
                <td class="text-right">NA</td>
              </tr>
              <tr>
                <th>Has Boat</th>
                <td class="text-right">NA</td>
              </tr>
              <tr>
                <th>Has Motorcycle</th>
                <td class="text-right">NA</td>
              </tr>
              <tr>
                <th>HasRV</th>
                <td class="text-right">NA</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-striped panel panel-primary table-hover table-vertical-center">
            <thead>
              <tr>
                <th colspan="2">Auto</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th width="160">VIN #1</th>
                <td class="text-right">WP1AB2A28CLA50429</td>
              </tr>
              <tr>
                <th>Make #1</th>
                <td class="text-right">PORSCHE</td>
              </tr>
              <tr>
                <th>Model #1</th>
                <td class="text-right">CAYENNE</td>
              </tr>
              <tr>
                <th>Year #1</th>
                <td class="text-right">2012</td>
              </tr>
              <tr>
                <th>VIN #2</th>
                <td class="text-right">WBSEH93587CY24162</td>
              </tr>
              <tr>
                <th>Make #2</th>
                <td class="text-right">BMW</td>
              </tr>
              <tr>
                <th>Model #2</th>
                <td class="text-right">M6</td>
              </tr>
              <tr>
                <th>Year #2</th>
                <td class="text-right">2007</td>
              </tr>
              <tr>
                <th>VIN #3</th>
                <td class="text-right">WAUPL68E55A093928</td>
              </tr>
              <tr>
                <th>Make #3</th>
                <td class="text-right">AUDI</td>
              </tr>
              <tr>
                <th>Model #3</th>
                <td class="text-right">S4</td>
              </tr>
              <tr>
                <th>Year #3</th>
                <td class="text-right">2005</td>
              </tr>
            </tbody>
          </table>
          <table class="table table-sm table-striped panel panel-primary table-hover table-vertical-center">
            <thead>
              <tr>
                <th colspan="2">House Members</th>
              </tr>
            </thead>
            <tbody>
              <tr width="160">
                <th>Name #1</th>
                <td class="text-right">SALLY J</td>
              </tr>
              <tr>
                <th>Gender #1</th>
                <td class="text-right">F</td>
              </tr>
              <tr>
                <th>Estimated Age #1</th>
                <td class="text-right">1959</td>
              </tr>
              <tr>
                <th>Name #2</th>
                <td class="text-right">BRONWYN D</td>
              </tr>
              <tr>
                <th>Gender #2</th>
                <td class="text-right">F</td>
              </tr>
              <tr>
                <th>Estimated Age #2</th>
                <td class="text-right">03/1962</td>
              </tr>
              <tr>
                <th>Name #3</th>
                <td class="text-right">MATTHEW</td>
              </tr>
              <tr>
                <th>Gender #3</th>
                <td class="text-right">M</td>
              </tr>
              <tr>
                <th>Estimated Age #3</th>
                <td class="text-right">08/1984</td>
              </tr>
              <tr>
                <th>Name #4</th>
                <td class="text-right">KIRSTEN D</td>
              </tr>
              <tr>
                <th>Gender #4</th>
                <td class="text-right">F</td>
              </tr>
              <tr>
                <th>Estimated Age #4</th>
                <td class="text-right">NA</td>
              </tr>
              <tr>
                <th>Phone Number</th>
                <td class="text-right">Not Provided</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade modal-alt" id="modalConversation" tabindex="-1" role="dialog" style="padding-right: 17px;">
    <div class="modal-dialog" role="document" style="margin-top: 0px;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h3 class="modal-title">John Doe</h3>
        </div>
        <div class="modal-body box">
          <div class="box-content">
            <p class="text-center text-muted small mb20"><time datetime="2008-02-14 20:00"><strong>JUL 8, 2019</strong></time></p>
            <div class="box-item">
              <div class="row row-xs">
                <div class="col-xs-2">
                  <img class="box-img-rounded" src="img/agent-profile.jpg">
                </div>
                <div class="col-xs-10">
                  <div class="box-body" data-hover="tooltip" data-placement="right" title="10:25">
                    <p class="mb0">Hello! I'm looking to buy a home?</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-item box-item-alt">
              <div class="box-body" data-hover="tooltip" data-placement="left" title="10:26">
                <p class="mb0">Sweet, Let me ask you a few questions to help you find your perfect home.</p>
              </div>
            </div>
            <div class="box-item box-item-alt">
              <div class="box-body" data-hover="tooltip" data-placement="left" title="10:27">
                <p class="mb0">Okay! What's your preferred price?</p>
              </div>
              <p class="small text-muted text-right">Delivered</p>
            </div>
            <p class="text-center text-muted small mb20 mt20">
              <time datetime="2008-02-14 20:00"><strong>JUL 10, 2019</strong></time>
            </p>
            <div class="box-item">
              <div class="row row-xs">
                <div class="col-xs-2">
                  <img class="box-img-rounded" src="img/agent-profile.jpg">
                </div>
                <div class="col-xs-10">
                  <div class="box-body" data-hover="tooltip" data-placement="right" title="18:05">
                    <p class="mb0">Between $358000 and $800500</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-item box-item-alt">
              <div class="box-body" data-hover="tooltip" data-placement="left" title="18:05">
                <p class="mb0">Which email address shall we use to notify you? agent@gmail.com</p>
              </div>
              <p class="small text-muted text-right">Delivered</p>
            </div>
            <div class="box-item">
              <div class="row row-xs">
                <div class="col-xs-2">
                  <img class="box-img-rounded" src="img/agent-profile.jpg">
                </div>
                <div class="col-xs-10">
                  <div class="box-body" data-hover="tooltip" data-placement="right" title="18:05">
                    <p class="mb0">Here is my email John@gmail.com</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-item box-item-alt">
              <div class="box-body" data-hover="tooltip" data-placement="left" title="18:06">
                <p class="mb0">Great! you can check this house here!</p>
              </div>
            </div>
            <div class="box-item box-item-alt">
              <div class="box-body" data-hover="tooltip" data-placement="left" title="18:07">
                <ul class="list-unstyled mb0">
                  <li>🏠&nbsp; 24 Street, Los Angeles, CA</li>
                  <li>💲&nbsp; 1,000,000</li>
                  <li>🛏️&nbsp; 4 bedrooms</li>
                  <li>🛁&nbsp; 2 bathrooms</li>
                </ul>
              </div>
              <div class="box-img">
                <a href="#" target="_blank"><img src="https://i.kinja-img.com/gawker-media/image/upload/s--bIV3xkEm--/c_scale,f_auto,fl_progressive,q_80,w_800/jsprifdd1gmfy7e7nola.jpg"></a>
              </div>
            </div>
            <div class="box-item box-item-alt">
              <div class="box-body" data-hover="tooltip" data-placement="left" title="18:08">
                <p class="mb0">Btw, we have 2 properties in new york you may be interested in.</p>
              </div>
            </div>
            <div class="box-item box-item-alt">
              <div class="box-img">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <div class="item active">
                      <div class="card-default text-left">
                        <img src="img/565d0a2e4daf0_1448938030.jpg" class="card-img-top rounded0" alt="home">
                        <div class="card-body mb0 px15">
                          <h5 class="mt10">348 Taylor Street, New York</h5>
                          <p class="text-muted">Hidden away on the fringe of the city is this charming four bedroom residence plus study on a lush, leafy oasis...</p>
                        </div>
                        <div class="card-footer pt0">
                          <a href="#" target="_blank" class="btn btn-link btn-block btn-lg">View All Details!</a>
                        </div>
                      </div>
                    </div>
                    <div class="item">
                      <div class="card-default text-left">
                        <img src="img/luxury-home.jpg" class="card-img-top rounded0" alt="home">
                        <div class="card-body mb0 px15">
                          <h5 class="mt10">1756 Anmoore Road, New York</h5>
                          <p class="text-muted">This stylish residence is nestled on a large level block in a desirably tranquil cul-de-sac location...</p>
                        </div>
                        <div class="card-footer pt0">
                          <a href="#" target="_blank" class="btn btn-link btn-block btn-lg">View All Details!</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Controls -->
                  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div>
              <p class="small text-muted text-right">Delivered</p>
            </div>
          </div>
        </div>
        <!-- add 'modal-alt-fixed' class when you add modal-footer -->
        <!-- <div class="modal-footer px15">
        <div class="box-footer">
          <div class="row row-xs">
            <div class="col-xs-1">
              <a href="#" target="_blank"><i class="fa fa-link">
                </i>
              </a>
            </div>
            <div class="col-xs-10">
              <input class="form-control form-control-clear" type="text" placeholder="Type something ...">
            </div>
            <div class="col-xs-1 text-right">
              <a href="#" target="_blank"><i class="fa fa-send">
                </i>
              </a>
            </div>
          </div>
        </div>
      </div> -->
      </div>
    </div>
  </div>
  <div class="modal fade" id="botEmbed" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Chat Bot Plugin for Your Website</h3>
        </div>
        <div class="modal-body">
          <fieldset>
            <div class="form-group">
              <label>Greeting</label>
              <input type="text" class="form-control" maxlength="80" value="Hello there! I'm happy to answer your questions about buying or selling a home.">
            </div>
            <div class="form-group">
              <label>Whitelisted URLs <i class="fa fa-question-circle small" data-hover="tooltip" data-placement="top" title="Add comma ',' or click enter to separate the URLs" aria-hidden="true"></i></label>
              <input type="text" placeholder="Add URL and hit enter." data-role="tagsinput">
            </div>
            <div class="form-group">
              <label>Copy and add to your website <i class="fa fa-question-circle small" data-hover="tooltip" data-placement="top" title="Insert it directly after the opening of the &lt;body&gt; tag on each page where you want the plugin to appear." aria-hidden="true"></i></label></label>
              <div class="copy">
                <div class="copy-body">
                  <button type="button" class="btn btn-primary"> <i class="fa fa-copy"></i>&nbsp; Copy Code to Clipboard</button>
                  <span class="hide">Code has copied to Clipboard successfully!</span>
                </div>
                <pre><code>&lt;!-- Load Facebook SDK for JavaScript --&gt;
&lt;div id="fb-root"&gt;&lt;/div&gt;
&lt;script&gt;
if (typeof window.fbAsyncInit === 'undefined') {
window.fbAsyncInit = function() {
  FB.init({
      xfbml : true,
      version : 'v3.3'
  });};
}
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
​
js = d.createElement(s);
js.id = id;
js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk-customer-chat'));&lt;/script&gt;
&lt;!-- Your customer chat code --&gt;
&lt;div class="fb-customerchat"
attribution=setup_tool
page_id="196079677504686"
theme_color="#fa3c4c"
logged_in_greeting="Hi! I’d be happy to answer your questions about 454 Circle Drive?"
logged_out_greeting="Hi! I’d be happy to answer your questions about 454 Circle Drive?"&gt;
&lt;/div&gt;</code>
              </pre>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Copy</button>
          <button type="button" class="btn btn-default">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="botEdit" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Edit</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control" placeholder="Title" value="">
          </div>
          <div class="form-group">
            <label for="bot_type">Facebook Page</label>
            <select class="form-control" disabled>
              <option data-name="graniteBay">Granite Bay</option>
              <option data-name="losAngeles">The Best Listing</option>
              <option data-name="newYork">Free Home Values</option>
            </select>
          </div>
          <div class="form-group">
            <label>Conversations <i class="fa fa-question-circle small" data-hover="tooltip" data-placement="top" title="Choose the conversations you want to add to the bot"></i></label>
            <div class="checkbox">
              <label><input type="checkbox" data-name="botType" checked> Listing &nbsp;<span data-toggle="tooltip-img-auto" title="<p class='mb5' style='max-width:300px'>Use this to trigger this conversation directly from Facebook Ads</p><img width='300' src='img/tooltip-bot-payload.jpg'>" class="badge label-default">Payload: Listing &nbsp;<i class="fa fa-question-circle small"></i></span></label>
              <div data-toggle="listings" class="form-group">
                <select class="form-control" aria-invalid="false">
                  <option>123 Main Street, Granite Bay, CA</option>
                  <option>8978 Golf Leaf Lane, Folsom, CA</option>
                  <option>728 Duncan St, New York, NY</option>
                  <option>123 Main Street, Granite Bay, CA</option>
                  <option>8978 Golf Leaf Lane, Folsom, CA</option>
                  <option>728 Duncan St, New York, NY</option>
                </select>
              </div>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" checked> Home Valuation &nbsp;<span data-toggle="tooltip-img-auto" title="<p class='mb5' style='max-width:300px'>Use this to trigger this conversation directly from Facebook Ads</p><img width='300' src='img/tooltip-bot-payload.jpg'>" class="badge label-default">Payload: Valuation &nbsp;<i class="fa fa-question-circle small"></i></span></label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" checked> Buyer &nbsp;<span data-toggle="tooltip-img-auto" title="<p class='mb5' style='max-width:300px'>Use this to trigger this conversation directly from Facebook Ads</p><img width='300' src='img/tooltip-bot-payload.jpg'>" class="badge label-default">Payload: Buyer &nbsp;<i class="fa fa-question-circle small"></i></span></label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" checked> Seller &nbsp;<span data-toggle="tooltip-img-auto" title="<p class='mb5' style='max-width:300px'>Use this to trigger this conversation directly from Facebook Ads</p><img width='300' src='img/tooltip-bot-payload.jpg'>" class="badge label-default">Payload: Seller &nbsp;<i class="fa fa-question-circle small"></i></span></label>
            </div>
          </div>
          <div class="form-group">
            <label>Greeting Text <i class="fa fa-question-circle small" data-toggle="tooltip-img-auto" title="<p class='mb5' style='max-width:300px'>The greeting text is displayed for people interacting with your bot for the first time. <br>To see it when testing the bot please delete the conversation with the page.</p><img width='300' src='img/thumbnail-welcome-message.jpg'>" aria-hidden="true"></i></label>
            <textarea id="GreetingText" data-expand="true" class="form-control" placeholder="" rows="2">{{$result[0]->bot->greeting_text}}.</textarea>
            <p class="help-block">user_first_name, user_last_name, user_full_name</p>
          </div>
          <div class="form-group">
            <label>Welcome Message <i class="fa fa-question-circle small" data-hover="tooltip" data-placement="top" title="This is the first message we send to people who subscribed to the bot." aria-hidden="true"></i></label>
            <textarea id="GreetingText" data-expand="true" class="form-control" placeholder="" rows="3">Hey {first_name}! 👋 I'm your bot assistant 🤖 from {page}. &#13;I'd be happy to help you buy or sell a home, give you a free home value estimate or show you more information about {listing_address}.</textarea>
            <p class="help-block">user_first_name, user_last_name, user_full_name</p>
          </div>
          <div class="form-group">
            <label>Last Conversation Message</label>
            <textarea maxlength="200" data-expand="true" class="form-control" placeholder="" id="closing_text" rows="1">{{$result[0]->bot->closing_text}}</textarea>
          </div>
          <div class="form-group">
            <label>Preferences</label>
            <div class="checkbox">
              <label><input type="checkbox" checked> Enable presistent menu</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" checked> Show listing suggestions for buyers based on their location</label>
            </div>
            <div class="checkbox">
              <label><input type="checkbox" checked> Send partial leads of unfinished conversations every 24 hours</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-default pull-right" data-name="bot-delete" data-dismiss="modal">Delete</button>
        </div>
      </div>
    </div>
  </div>
  <!--javascript-->
  <script src="{{secure_asset('js/plugins.min.js')}}"></script>
  <script src="{{secure_asset('js/main.min.js')}}"></script>
  <script>
    $('[data-toggle="tooltip-img-auto"]').tooltip({
      container: 'body',
      animated: 'fade',
      placement: 'auto',
      html: true,
      trigger: 'hover',
      template: '<div class="tooltip tooltip-img"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
    });
    $('.copy .btn').click(function () {
      var copyBody = $(this).parents('.copy-body');
      copyBody.find('button').addClass('hide');
      copyBody.find('span').removeClass('hide');
      setTimeout(function () {
        copyBody.find('span').addClass('hide');
        copyBody.find('button').removeClass('hide');
      }, 2000);
    });
    //select all checkboxes
    $(document).on('click', '[data-name="selectAll"]', function () {
      if ($(this).is(':checked')) {
        $('[data-name="select"]').prop('checked', true);
      } else {
        $('[data-name="select"]').prop('checked', false);
        $(this).prop('checked', false);
      }
      selectRow();
      lpsCounter();
      checkedlps();
    });
    //analytics
    var charttps = c3.generate({
      bindto: '#botAnalytics',
      data: {
        x: '',
        columns: [
          ['Subscribers', 80],
          ['Conversations', 150],
          ['Leads', 50],
          ['Broadcasts', 10],
        ],
        type: 'bar'
      },
      axis: {
        x: {
          type: 'category'
        }
      }
    });
    charttps.resize({
      width: $("#botAnalytics").innerWidth(),
      height: 250
    });
    //
    $('[data-name="delete-sub"]').on('click', function (e) {
      e.preventDefault();
      var t = $(this);
      //t.closest('tr').removeClass('warning').addClass('danger');
      $('body').addClass('noty-backdrop');
      var n = new Noty({
        text: 'Delete Subscriber?',
        layout: 'center',
        type: 'alert',
        closeWith: 'button',
        timeout: false,
        buttons: [
          Noty.button('Delete', 'btn btn-danger btn-sm', function () {
            t.closest('tr').remove();
            new Noty({
              text: 'Subscriber was deleted successfully.',
              type: 'success'
            }).show();
            n.close();
          }, {
            id: 'button1',
            'data-status': 'ok'
          }),
          Noty.button('Cancel', 'btn btn-success btn-sm', function () {
            t.closest('tr').removeClass('danger').addClass('warning');
            n.close();
          })
        ]
      }).on('onClose', function () {
        setTimeout(function () {
          $('body').removeClass('noty-backdrop');
        }, 300);
      }).show();
    });
    // Delete bot confirmation
    $('[data-name="bot-delete"]').on('click', function (e) {
      e.preventDefault();
      var t = $(this);
      t.closest('tr').removeClass('warning').addClass('danger');
      $('body').addClass('noty-backdrop');
      var n = new Noty({
        text: 'Permanently delete this BOT?',
        layout: 'center',
        type: 'alert',
        closeWith: 'button',
        timeout: false,
        buttons: [
          Noty.button('Delete', 'btn btn-danger btn-sm', function () {
            t.closest('tr').remove();
            new Noty({
              text: 'BOT was deleted successfully.',
              type: 'success'
            }).show();
            n.close();
          }, {
            id: 'button1',
            'data-status': 'ok'
          }),
          Noty.button('Cancel', 'btn btn-success btn-sm', function () {
            t.closest('tr').removeClass('danger').addClass('warning');
            n.close();
          })
        ]
      }).on('onClose', function () {
        setTimeout(function () {
          $('body').removeClass('noty-backdrop');
        }, 300);
      }).show();
    });
  </script>
  <script>
    $('[data-name="botType"]').change(function () {
      if ($(this).is(':checked')) {
        $('[data-toggle="listings"]').addClass("show");
        $('[data-toggle="listings"]').removeClass("hide");
      } else {
        $('[data-toggle="listings"]').addClass("hide");
        $('[data-toggle="listings"]').removeClass("show");
      }
    });
  </script>

  <!--
    -
    - CRUD TEST
    -
  -->
  <script>
    $(document).ready(function(){
      $('#delete').click(function(){
        var id = $(this).attr('data-id')

        $.ajax({
          url: '/bot/facebook/subscribers/'+id,
          type: 'DELETE',
          success: function(data, status, xhr){
            console.log(status)
            alert('deleted');
          }
        });

      });

      $('[data-name="botStatus"]').on('click', function(){
        var id = $(this).attr('data-id');

        if ($(this).is(':checked'))
          $.ajax({
            url: '/bot/facebook/subscribers/'+id+'/disable',
            type: 'PUT',
            success: function(data, status, xhr){
              alert('disabled');
            }
          });
        else
        $.ajax({
          url: '/bot/facebook/subscribers/'+id+'/enable',
          type: 'PUT',
          success: function(data, status, xhr){
            alert('enable');
          }
        });

      });

    });


    $('#saveEditBot').click(function(){

      var title = $('#title').val();
      var closing_text = $('#closing_text').val();
      var greeting_text = $('#greeting_text').val();

      $.ajax({
        type: 'PUT',
        url: '/bot/facebook/bots/55',
        data:{
          title : title,
          listing_id: 1,
          intro_text: "Hey { user_first_name }! 👋, I'm the virtual assistant of { page }.\nI'd be happy to answer your questions about buying or selling a home.|What describes you best?",
          closing_text: closing_text,
          greeting_text: greeting_text,
          page_token: "EAAruodN7ajUBAKUN9GqlcP8Y2Dl7dHfq308StZCTOAVZBnZBFc1fs5VofUNgtwfC1AObX0YqQwOxrzc4KvUEaE9gAXUrdhYxZB1kotzASmsotyheQgeeram5E1nAfez5ZBcl2ULppjEblpKfpPZCmubVBqHWIus58mgcPUjKtcd2fZCmoBVmZBQV",
          l2l_token: "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijk0NzU5YzljZDBlMWJkODg4OTM5MzYzZTQ4NjYyNzIyZmQwYTVmNDllYjIzMjU5MGQyOTIwM2VlMDkxN2JhNjRmZGM1ZDI1MmNhNTAwOGNjIn0.eyJhdWQiOiIzIiwianRpIjoiOTQ3NTljOWNkMGUxYmQ4ODg5MzkzNjNlNDg2NjI3MjJmZDBhNWY0OWViMjMyNTkwZDI5MjAzZWUwOTE3YmE2NGZkYzVkMjUyY2E1MDA4Y2MiLCJpYXQiOjE1Njg3MzAwMjgsIm5iZiI6MTU2ODczMDAyOCwiZXhwIjoxNjAwMzUyNDI4LCJzdWIiOiIxODgxMTkiLCJzY29wZXMiOltdfQ.zjsMsy1Lyk3Dce-M1kfsW2RBP1WguUwFTlogCeGnD3W2dXdQ7zUxqG952vLSoL1cESnwBZiArQvegppzG9FA1g",
          facebook_user_id: "3693880870623784"
        },
        success: function(data, status, xhr){
          console.log(Object.values(data));
          alert('Well modified')
        }
      });
    });

  </script>

    <!--
    - END /
    - CRUD TEST
    -
    -->

</body>

</html>