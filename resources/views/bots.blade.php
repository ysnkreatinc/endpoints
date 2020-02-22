@extends('layouts.app')


@section('content')
  <main>
    <div class="container">
      <div class="panel panel-primary">
        <div class="panel-body">
          <div class="panel-heading">
            <div class="row row-sm">
              <div class="col-xs-4">
                <h4 class="panel-title">Bots</h4>
              </div>
              <div class="col-xs-8 text-right">
                <a class="btn btn-facebook" href="https://www.facebook.com/v6.0/dialog/oauth?client_id=3077128572332597&redirect_uri=https://855dacf7.ngrok.io/bots&scope=public_profile%2Cemail%2Cmanage_pages%2Cpages_messaging%2Cpages_messaging_subscriptions"><i class="fa fa-facebook" aria-hidden="true"></i> &nbsp; Connect with Facebook</a>
                <a class="btn btn-default" href="#" data-toggle="modal" data-target="#botSettings"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#botAdd">Add Bot</a>
              </div>
            </div>
          </div>
          <div class="alert alert-warning">
            <i class="alert-icon fa fa-exclamation-triangle text-warning" aria-hidden="true"></i>
            <b>Your Facebook account isn't connected.</b> Please <a href="https://www.facebook.com/v2.10/dialog/oauth?client_id=2136593863088637&amp;state=c1aeaedcce9fefdbceef637d5950a2a2&amp;response_type=code&amp;sdk=php-sdk-5.7.0&amp;redirect_uri=https%3A%2F%2Fbeta.listingstoleads.com%2Fbot%2Ffacebook%2Flogin%2Fcallback&amp;scope=public_profile%2Cemail%2Cmanage_pages%2Cpages_show_list%2Cpages_messaging&amp;state=207546">connect it</a> to activate the bots. 
          </div>
            <div class="panel panel-primary">
              <div class="table-responsive">
                <table class="table table-striped table-hover table-vertical-center">
                  <thead>
                    <tr>
                      <th><i class="fa fa-toggle-on" data-hover="tooltip" data-placement="top" title="Activate / Deactivate Tabs"></i></th>
                      <th>
                        <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Title</a>
                      </th>
                      <th>
                          <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Page</a>
                      </th>
                      <th>
                        <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Added</a>
                      </th>
                      <th>
                        <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Edited</a>
                      </th>
                      <th>
                          <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Subscribers</a>
                      </th>
                      <th>
                          <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Conversations</a>
                      </th>
                      <th>
                          <a href="#"><i class="fa fa-sort" aria-hidden="true"></i> Leads</a>
                      </th>
                      <th width="171"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($result as $item)
                    <tr>
                      <td>
                        <input type="checkbox" data-name="botStatus" data-id="{{$item->id}}">
                      </td>
                      <td>
                        <a href="bots-edit.html">{{$item->title}}</a>
                      </td>
                      <td>
                        <a href="#" data-hover="tooltip" data-placement="top" title="Click to copy messenger link.">123 Mainstreet &nbsp;<i class="fa fa-copy" aria-hidden="true"></i></a>
                      </td>
                      <td>
                        {{$item->created_at}}
                      </td>
                      <td>
                        {{$item->updated_at}}
                      </td>
                      <td>
                        <a href="#">
                          {{count($item->subscribers)}}
                        </a>
                      </td>
                      <td>
                          {{$item->conversations}}
                      </td>
                      <td>
                        {{$item->leads}}
                      </td>
                      <td>
                          <a href="#" target="_blank" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-original-title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                          <a href="bots-edit.html" class="btn btn-icon btn-default btn-rounded-minimal" data-hover="tooltip" data-placement="top" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                          <a href="#" class="btn btn-icon btn-default btn-rounded-minimal" data-toggle="modal" data-target="#botEmbed" data-hover="tooltip" data-original-title="Embed"><i class="fa fa-code" aria-hidden="true"></i></a>
                          <a href="#" class="btn btn-icon btn-default btn-rounded-minimal removeBot" data-id="{{$item->id}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
  </main>



  <!--Modal--> 

  <div class="modal fade" id="botAdd" tabindex="-1" role="dialog">
    <form action="/add/bot" method="post" id="formAdding">
    @csrf
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Add Bot</h3>
        </div>
        <div class="modal-body">
          <div class="row row-xs">
            <div class="col-sm-5">
              <fieldset>
                <legend>Bot settings</legend>
                <div class="form-group">
                  <label>Title</label>
                  <input type="text" class="form-control" placeholder="Title" value="" id="title" name="title">
                </div>
                <div class="form-group">
                  <label for="bot_type">Facebook Page</label>
                  <select id="facebook_pages" required="true" name="facebook_pages" id="facebook_pages" class="form-control" data-name="facebook_pages">
                    <option value="" selected disabled>Select Facebook Page</option>
                    @foreach ($pages['pages'] as $page)
                        <option value="{{$page['id'].'@'.$page['access_token'].'@'.$page['name']}}">{{$page['name']}}</option>
                    @endforeach
                  </select>
                  <p class="help-block">Can't see your page in the list? <a href="#">Select from here</a></p>
                </div>
              </fieldset>
              <fieldset>
                <legend>conversations</legend>
                <div class="form-group">
                  <div class="checkbox">
                    <label><input type="checkbox" name="intent[listing]" id="listing" > Listing </label>
                    <div data-toggle="listings" class="form-group hide">
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
                    <label><input type="checkbox" name="intent[valuation]" id="valuation" > Home Valuation</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" name="intent[buyer]" id="buyer" > Buyer</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" name="intent[seller]" id="seller"> Seller</label>
                  </div>
                </div>   
              </fieldset>
            </div>
            <div class="col-sm-7">
              <fieldset>
                <legend>customize messages</legend>
                <div class="alert alert-info">
                  <i class="alert-icon fa fa-lightbulb-o text-info" aria-hidden="true"></i>
                  Use &#123;&#123;user_first_name&#125;&#125;, &#123;&#123;user_last_name&#125;&#125, &#123;&#123;user_full_name&#125;&#125 to add some personal touch to your bot.
                </div>
                <div class="form-group">
                  <label>Welcome Message <i class="fa fa-question-circle small" data-hover="tooltip" data-placement="top" title="We'll display this to people who interact with your bot for the first time and also use it as a welcome message." aria-hidden="true"></i></label>
                  <textarea id="intro_text" name="intro_text" data-expand="true" class="form-control" placeholder="" rows="3">Hey {first_name}! 👋 I'm your bot assistant 🤖 from {page}. &#13;I'd be happy to help you buy or sell a home, give you a free home value estimate or show you more information about {listing_address}.</textarea>
                </div>
                <div class="form-group">
                  <label>Greeting Text for Chat Bot Plugin</label>
                  <input type="text" class="form-control" maxlength="80" value="Hello there! I'm happy to answer your questions about buying or selling a home.">
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
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" value="Add Bot">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
    </form>
  </div>

  <div class="modal fade" id="botSettings" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          <h3 class="modal-title">Settings</h3>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Connect your Facebook</label>
            <button type="button" class="btn btn-block btn-facebook" {{empty($pages) ? '': 'Disabled' }}><i class="fa fa-facebook" aria-hidden="true"></i> &nbsp; Connect with Facebook</button>
            <a href="/disconnect/facebook">Disconnet</a>
          </div>
          <div class="form-group mb0">
            <label>Pages</label>
            <ul class="list-group list-group-sm">
                @foreach ($pages['pages'] as $page)
                <li class="list-group-item">{{$page['name']}}</li>
                @endforeach
            </ul>
          </div>
          <p class="help-block">Can't see your page in the list? You can <a href="#">select from here</a></p>
        </div>
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
              <input type="text" placeholder="Add URL and hit enter" data-role="tagsinput">
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
@endsection
