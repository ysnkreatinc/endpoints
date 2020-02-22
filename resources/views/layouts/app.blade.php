<!DOCTYPE html>
<html lang="en" class="no-js">
<!--<![endif]-->

<head>
  <meta charset="UTF-8">
  <title>Bots - Listings To Leads</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.typekit.net/uht2mhd.css">
  <link rel="stylesheet" href="css/main.min.css">
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
      <li class="active">Bots</li>
    </ol>
  </div>




  @yield('content')










  
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

  <!--javascript-->
  <script src="js/plugins.min.js"></script>
  <script src="js/main.min.js"></script>
  <script>

    $('[data-toggle="tooltip-img-auto"]').tooltip({
      container: 'body',
      animated: 'fade',
      placement: 'auto',
      html: true,
      trigger: 'hover',
      template: '<div class="tooltip tooltip-img"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
    });

    $('.copy .btn').click(function() {
      var copyBody = $(this).parents('.copy-body');
      copyBody.find('button').addClass('hide');
      copyBody.find('span').removeClass('hide');
      setTimeout(function() {
        copyBody.find('span').addClass('hide');
        copyBody.find('button').removeClass('hide');
      }, 2000);
    });

    $('[data-name="botType"]').change(function() {
      if ($(this).is(':checked')) {
        $('[data-toggle="listings"]').addClass("show");
        $('[data-toggle="listings"]').removeClass("hide");
      }else{
        $('[data-toggle="listings"]').addClass("hide");
        $('[data-toggle="listings"]').removeClass("show");
      }
    });

    //
    function checkedlps() {
      var checkedNumber = $('[data-name="select"]:checked').length;
      if (checkedNumber == 1 || checkedNumber > 1) {
        $('[data-name="deleteSelected"]').attr('disabled', false);
        if (checkedNumber == 1) {
          $('[data-name="selectedNumber"]').text(checkedNumber + ' Lead selected');
        } else if (checkedNumber > 1) {
          $('[data-name="selectedNumber"]').text(checkedNumber + ' Leads selected');
        }
      } else {
        $('[data-name="selectedNumber"]').text('');
        $('[data-name="deleteSelected"]').attr('disabled', true);
      }
    }
    function lpsCounter() {
      var checkboxNumber = $('[data-name="select"]').length;
      var checkedNumber = $('[data-name="select"]:checked').length;
      if (checkedNumber < checkboxNumber) {
        $('[data-name="select-all"]').prop('checked', false);
        $('[data-name="select-all-specify"]').addClass('hide');
      } else {
        $('[data-name="select-all"]').prop('checked', true);
        $('[data-name="select-all-specify"]').removeClass('hide');
      }
    }
    function selectRow() {
      if ($('[data-name="select"]').is(':checked')) {
        $('[data-name="deleteSelected"]').attr('disabled', false);
      } else {
        $('[data-name="deleteSelected"]').attr('disabled', true);
      }
    }
    $(document).on('click', '[data-name="delete"]', function() {
      $('body').addClass('noty-backdrop');
      var t = $(this);
      t.closest('tr').addClass('danger');
      var n = new Noty({
        text: '<p>You are about to delete this bot and all its related data (subscribers, leads, analytics etc..).</p> <div class="alert alert-info mb0"><i class="alert-icon fa fa-lightbulb-o text-info" aria-hidden="true"></i><p class="small">You can always turn it off to pause it.</p></div>',
        layout: 'center',
        type: 'alert',
        closeWith: 'button',
        timeout: false,
        buttons: [
          Noty.button('Delete', 'btn btn-danger btn-sm', function() {
            t.closest('tr').remove();
            new Noty({
              text: 'Bot was deleted successfully.',
              type: 'success'
            }).show();
            n.close();
          }, {id: 'button1', 'data-status': 'ok'}),
          Noty.button('Cancel', 'btn btn-success btn-sm', function() {
            t.closest('tr').removeClass('danger');
            n.close();
          })
        ]
      }).on('onClose', function() {
        checkedlps();
        selectRow();
        lpsCounter();
        setTimeout(function() {
          $('body').removeClass('noty-backdrop');
        }, 300);
      }).show();
    });
  </script>
  
  <script>
    $(document).ready(function(){


      $('[data-name="botStatus"]').on('click', function(){
        var id = $(this).attr('data-id');

        if ($(this).is(':checked'))
        $.ajax({
          url: 'bot/facebook/subscription/'+id+'/unsubscribe',
          type: 'DELETE',
          success: function(data, status, xhr){
            alert('disabled');
          }
        });
        else
        $.ajax({
            url: 'bot/facebook/subscription/'+id+'/subscribe',
            type: 'POST',
            success: function(data, status, xhr){
              alert('disabled');
            }
          });

      });

        $('.removeBot').click(function(){
          var idbot = $(this).attr('data-id');
          
        $.ajax({
          url: '/bot/facebook/bots/'+idbot,
          type: 'DELETE',
          success: function(data, status, xhr){
            console.log(status)
            alert('deleted');
          }
        });

        });

        $('#formAdding').submit(function($e){
          $e.preventDefault();
          var title = $('#title').val();
          var facebook_pages = $('#facebook_pages').val().split('@');
          var listing = $('#listing:checked').val();
          var valuation = $('#valuation:checked').val();
          var buyer = $('#buyer:checked').val();
          var seller = $('#seller:checked').val();
          var page_id = facebook_pages[0];
          var page_name = facebook_pages[2];
          var page_token  = facebook_pages[1];
          var intro_text = $('#intro_text').val();

          $.ajax({
            type: 'POST',
            url: '/bot/facebook/bots',
            data:{
              title: title,
              //listing_id: 1,
              intro_text: intro_text,
              closing_text: "We'll be here if you need anything else.",
              greeting_text: "Hey { { user_first_name } } 👋, thanks for joining us on Messenger! \nI'm happy to answer your questions about buying or selling a home. \nClick get started to start.",
              page_id: page_id,
              page_name: page_name,
              page_token: page_token,
              l2l_token: "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijk0NzU5YzljZDBlMWJkODg4OTM5MzYzZTQ4NjYyNzIyZmQwYTVmNDllYjIzMjU5MGQyOTIwM2VlMDkxN2JhNjRmZGM1ZDI1MmNhNTAwOGNjIn0.eyJhdWQiOiIzIiwianRpIjoiOTQ3NTljOWNkMGUxYmQ4ODg5MzkzNjNlNDg2NjI3MjJmZDBhNWY0OWViMjMyNTkwZDI5MjAzZWUwOTE3YmE2NGZkYzVkMjUyY2E1MDA4Y2MiLCJpYXQiOjE1Njg3MzAwMjgsIm5iZiI6MTU2ODczMDAyOCwiZXhwIjoxNjAwMzUyNDI4LCJzdWIiOiIxODgxMTkiLCJzY29wZXMiOltdfQ.zjsMsy1Lyk3Dce-M1kfsW2RBP1WguUwFTlogCeGnD3W2dXdQ7zUxqG952vLSoL1cESnwBZiArQvegppzG9FA1g",
              l2l_member_id: 11,
              facebook_user_id: 3693880870623784,
            },
            success: function(data, status, xhr){
              /*
              for(key in data) {
                  if(data.hasOwnProperty(key)) {
                      var value = data[key];
                      console.log(value);
                      //do something with value;
                  }
              }
              */
              console.log(Object.values(data));
              console.log(Object.values(data)[10]);

              if(listing == 'on')
              {
                $.ajax({
                  type: 'POST',
                  url: '/bot/facebook/bots/'+Object.values(data)[10]+'/intents/2',
                  data: {
                    label: 'Get Listing Info',
                    in_menu: 1,
                    listing_id: 1
                  }
                });
              }
              

              if(valuation == 'on')
              {
                $.ajax({
                  type: 'POST',
                  url: '/bot/facebook/bots/'+Object.values(data)[10]+'/intents/3',
                  data: {
                    label: 'Get Home Valuation',
                    in_menu: 1,
                    listing_id: 1
                  }
                });
              }


              if(seller == 'on')
              {
                $.ajax({
                  type: 'POST',
                  url: '/bot/facebook/bots/'+Object.values(data)[10]+'/intents/4',
                  data: {
                    label: 'Home Seller',
                    in_menu: 1,
                    listing_id: 1
                  }
                });
              }

              if(seller == 'on')
              {
                $.ajax({
                  type: 'POST',
                  url: '/bot/facebook/bots/'+Object.values(data)[10]+'/intents/5',
                  data: {
                    label: 'I\'m Buyer',
                    in_menu: 1,
                    listing_id: 1
                  }
                });
              }

              alert('Bot added successfully');
              
            }
          });

        });
    });
</script>

</body>


</html>
