<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>List pages</title>
</head>
<body>
    

<div class="container mt-5">
    <form action="/bot/facebook/bots" method="post">
    <div class="col-12">
        <div class="col-6">
            <label>Title</label>
            <input class="form-control" type="text" name="title" />
        </div>
        <div class="col-6">
            <label>Greeting text</label>
            <input class="form-control" type="text" name="greeting_text" value="Hey { { user_first_name } } 👋, thanks for joining us on Messenger! \nI'm happy to answer your questions about buying or selling a home. \nClick get started to start." />
        </div>
    </div>

    <div class="col-12">
        <div class="col-6">
            <label>Title</label>
            <input class="form-control" type="text" name="title" />
        </div>
        <div class="col-6">
            <label>Intro_text</label>
            <input class="form-control" type="text" name="intro_text" value="Hello there! I'm happy to answer your questions about buying or selling a home." />
        </div>
    </div>

    <div class="col-12">
        <div class="col-6">
            <label>Pages</label>
            <select class="form-control">
                @foreach ($listPages['pages'] as $page)
                <option value="">{{$page['name']}}</option>    
                <input type="hidden" name="page_id" value="{{$page['id']}}" />
                <input type="hidden" name="page_name" value="{{$page['name']}}" />
                <input type="hidden" name="page_token" value="{{$page['access_token']}}" />
                @endforeach
            </select>
            <input type="hidden" name="l2l_token" value="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijk0NzU5YzljZDBlMWJkODg4OTM5MzYzZTQ4NjYyNzIyZmQwYTVmNDllYjIzMjU5MGQyOTIwM2VlMDkxN2JhNjRmZGM1ZDI1MmNhNTAwOGNjIn0.eyJhdWQiOiIzIiwianRpIjoiOTQ3NTljOWNkMGUxYmQ4ODg5MzkzNjNlNDg2NjI3MjJmZDBhNWY0OWViMjMyNTkwZDI5MjAzZWUwOTE3YmE2NGZkYzVkMjUyY2E1MDA4Y2MiLCJpYXQiOjE1Njg3MzAwMjgsIm5iZiI6MTU2ODczMDAyOCwiZXhwIjoxNjAwMzUyNDI4LCJzdWIiOiIxODgxMTkiLCJzY29wZXMiOltdfQ.zjsMsy1Lyk3Dce-M1kfsW2RBP1WguUwFTlogCeGnD3W2dXdQ7zUxqG952vLSoL1cESnwBZiArQvegppzG9FA1g" />
            <input type="hidden" name="l2l_member_id" value="11" />
            <input type="hidden" name="facebook_user_id" value="{{$listPages['facebook_user_id']}}" />
        </div>
    </div>

    
    <div class="col-12 mt-5">
        <div class="col-6">
            <input type="submit" class="btn btn-dark" value="Submit" />
        </div>
    </div>

    
    </form>
</div>

</body>
</html>