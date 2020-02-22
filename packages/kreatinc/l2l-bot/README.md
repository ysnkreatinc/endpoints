## Install

There are two ways to install this package in your laravel application.

1. Install as local package: To allow for local developmanet
2. Install from private repository.

## A. Install as local package:

1. First you install your laravel application, in this example we will name the application folder:

    `/var/www/larbot`

2. Create `packages` folder in the root `larbot`, And then add the bot package in this path:

    `packages/kreatinc/l2l-bot`

    *You can either download the package and put it there, or more preferably use git to clone it*

To make sure, the final path of a file in this package will be:
`larbot/packages/kreatinc/l2l-bot/src/BotServiceProvider.php`


3. These are the changes needed for the **composer.json** of the application, `larbot`:
```
    {
        ...
        "require": {
            ...
            "kreatinc/bot": "dev-master"
        },
        "repositories": [
            {
                "type": "path",
                "url":  "packages/kreatinc/l2l-bot",
                "options": {
                    "symlink": true
                }
            }
        ],
        "autoload": {
            ...
            "psr-4": {
                "App\\": "app/",
                "Kreatinc\\Bot\\": "packages/kreatinc/l2l-bot/src"
            }
        },
        "extra": {
            "laravel": {
                "providers": [
                    "Kreatinc\\Bot\\BotServiceProvider"
                ]
            }
        },
        ...
    }
```
**Add all the parts related to the `bot` to your composer.json**

4. Update and Install:
- After you make this changes to your **composer.json** you need to run this command inside your Laravel application.
```
    composer update
```

- Then run this command to install and publish the file of the package into your Laravel application:
```
    php artisan bot:install
```

- Now you can run the migration to add new tables to your database that the bot needs:
```
    php artisan migrate
```

## B. Install from private repository:

1. First make sure that you have generated your SSH Key in the server.
2. Add key to repository keys in github
3. Create `.ssh/config` file with below content:
```
Host l2l-bot
HostName github.com
User git
IdentityFile ~/.ssh/l2l-bot
IdentitiesOnly yes
```
4. Add this to composer:
```
    "repositories": [
         {
             "type": "vcs",
             "url":  "l2l-bot:bilalararou/l2l-bot.git"
         }
    ],
    "require": {
        ...
        "kreatinc/bot": "dev-master"
    },
```


After you make this changes to your **composer.json** you need to run this command inside your Laravel application.

    composer update

Then run this command to install the service provider of the package into your Laravel application:

    php artisan bot:install

Now we install the package in our Laravel application, we need to run the migration to add new tables to our database that the bot need:

    php artisan migrate

## Add Configs

After you install the package you need to give the package the necessary information about facebook and wit platforms.
```
FACEBOOK_APP_ID=
FACEBOOK_APP_SECRET=
FACEBOOK_APP_GRAPH_VERSION=
FACEBOOK_APP_REDIRECT_URI=
FACEBOOK_APP_LOGOUT_REDIRECT_URI=

MESSENGER_VERIFY_TOKEN=

WIT_ACCESS_TOKEN=
WIT_VERSION=
WIT_API=

L2L_API=
```
### 1. Create Facebook APP:
- First, you can use **ngrok** to get an URL to your localhost, that URL will be used in Facebook app.

- We will name your application url `https://my-app.com` as an example.

- Create a Facebook application, that you can use to connect with the bot
- Add Facebook login product, and add these urls to the accepted for OAuth redirection: 
`https://my-app.com/bot/facebook/login/callback`

- Add Messenger product, and go to Messanger's settings and scroll down to **Webhooks** section:
- Click the **Setup Webhooks** button.
- In the **Callback URL** field, enter the public URL the webhook `https://my-app.com/bot/facebook/webhook`.
- In the **Verify Token** field, enter the verify token `MESSENGER_VERIFY_TOKEN`.
- Under **Subscription Fields**, select the webhook events you want delivered to you webhook `messages, messaging_postbacks, message_echoes`.
- Click the **Verify and Save** button.

    *Note: **MESSENGER_VERIFY_TOKEN**: is a token you generate and add it to the env of your laravel application, it's the same we added to the facebook app.

### 2. Add Wit.ai and l2l's config to env:
We will give you these.


### How To Use:

#### 1. First Login to facebook:

- Visit the page `https://my-app.com/bot/facebook/login?member_id=11` , you will see a link was generated.

    *Note: `member_id` is the `l2l_member_id` from the main application, but for local you can use any number.

- That's Facebook's login link, Clicking on it will direct you to facebook.
- Follow those steps, to login and select at least one page.
- Once done, Facebook will redirect you back to `https://my-app.com/bot/facebook/login/callback`, with some data which we will use to get the Facebook user token and info and store them im the database.
- Finally, you are redirected to base url with some data:

**`https://my-app.com/?agent_id=1&facebook_user_id=2222&access_token={code}&l2l_member_id=1`**


#### 2. Add the Bot to your facebook page:

- First, use this endpoint to get the list of your facebook pages:

**`https://my-app.com/bot/facebook/pages?facebook_user_id=2222`**
```
{
    "agent_id":1,
    "facebook_user_id":"2222",
    "pages": [
        {
            "access_token":"...",
            "name":"Developer Page",
            "id":"33333"
        },
    ]
}
```

*Note: The agent id and facebook id are the ones returned in the url of the last login step, you can also find them in the database.

- Add your Facebook page to the Bot:

**POST `https://my-app.com/bot/facebook/bots`**
```
{
    "title"         : "My Page Bot Assistant",
    "greeting_text" : "Hey {{user_first_name}} 👋, thanks for joining us on Messenger! \nI'm happy to answer your questions about buying or selling a home. \nClick get started to start.",
    "page_id"      : "33333",
    "page_name"    : "Developer Page",
    "page_token"   : "...",
    "l2l_token"        : "...",
    "l2l_member_id"    : 1,
    "facebook_user_id" : "2222"
}
```

*Note: Most of the input used here, are the ones you collected before.


#### 3. Chat with the Bot:

- Now everything should be set, and you can chat with the Bot.

- Open your Facebook, and message your Facebook page.

- The Bot will reply back.

- Anytime Facebook sends us a Message, we are using this endpoint to catch them:

**POST `https://my-app.com/bot/facebook/webhook`**

- So you can follow that endpoint and dig further to know how we handle the messages and replies.