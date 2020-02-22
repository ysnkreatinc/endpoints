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
    <form action="/bot/facebook/bots/14/intents/5/" method="post">

    <div class="col-12">
        <div class="col-6">
            <label>Listing</label>
            <input type="checkbox" name="intent[listing]">
        </div>
    </div>

    <div class="col-12">
        <div class="col-6">
            <label>Home Valuation</label>
            <input type="checkbox" name="intent[valuation]">
        </div>
    </div>

    <div class="col-12">
        <div class="col-6">
            <label>Seller</label>
            <input type="checkbox" name="intent[seller]">
        </div>
    </div>

    <div class="col-12">
        <div class="col-6">
            <label>Buyer</label>
            <input type="checkbox" name="intent[buyer]">
        </div>
    </div>

    <div class="col-12 mt-5">
        <div class="col-6">
            <input type="submit" class="btn btn-dark" value="Submit" />
        </div>
    </div>

    <input type="hidden" name="label" value="IntentOfTestBot">
    <input type="hidden" name="in_menu" value="1">
    <input type="hidden" name="listing_id" value="1">

    
    </form>
</div>

</body>
</html>