<?php

namespace Kreatinc\Bot;

use Illuminate\Support\Facades\Route;
use Kreatinc\Bot\Controllers\AnalyticsController;
use Kreatinc\Bot\Controllers\FacebookController;
use Kreatinc\Bot\Controllers\IntentController;
use Kreatinc\Bot\Controllers\BotController;
use Kreatinc\Bot\Controllers\AgentBotsController;
use Kreatinc\Bot\Controllers\SubscriberController;
use Kreatinc\Bot\Controllers\BotSubscriptionController;
use Kreatinc\Bot\Controllers\BotStaticsController;

Route::prefix('bot/facebook')->group(function () {
    Route::get('messenger/{agent}', [FacebookController::class, 'messenger'])->name('facebook.messenger');
    // Route::post('subscribe', [FacebookController::class, 'subscribePage'])->name('facebook.page.subscribe');
    // Route::delete('unsubscribe', [FacebookController::class, 'unsubscribePage'])->name('facebook.page.unsubscribe');

    /**
     * Facebook
     */
    // Login the user
    Route::get('login', [FacebookController::class, 'login'])->name('facebook.login');
    Route::get('login/callback', [FacebookController::class, 'handleFacebookCallback'])->name('facebook.login.callback');
    // User pages
    Route::get('pages', [FacebookController::class, 'list'])->name('facebook.pages');
    // Messenger webhook
    Route::get('webhook', [FacebookController::class, 'verifyToken']);
    Route::post('webhook', [FacebookController::class, 'receiveWebhook']);

    // TODO
    // Add admin can add messages
    Route::prefix('admin/analytics')->group(function () {
        Route::get('bots',          [AnalyticsController::class, 'leadsBots']);
        Route::get('conversations', [AnalyticsController::class, 'leadsConversations']);
        Route::get('leads',         [AnalyticsController::class, 'leadsAnalytics']);
    });

    /**
     * Bots
     */
    // Bot Intents
    Route::get('intents', [IntentController::class, 'index']);
    // Bot
    Route::post('bots', [BotController::class, 'store']);
    Route::get('bots/{bot}', [BotController::class, 'show']);
    Route::put('bots/{bot}', [BotController::class, 'update']);
    Route::delete('bots/{bot}', [BotController::class, 'destroy']);

    Route::put('bots/{bot}/settings', [BotController::class, 'updateSettings']);

    Route::get('bots/{bot}/history', [BotController::class, 'botHistory']);

    Route::post('bots/{bot}/intents/{intent}', [BotController::class, 'addIntent']);
    Route::delete('bots/{bot}/intents/{intent}', [BotController::class, 'removeIntent']);
    // Statics
    Route::get('bots/{bot}/statics', [BotStaticsController::class, 'statics']);
    // Agent bots
    Route::get('bots/agent/{member}', [AgentBotsController::class, 'bots']);
    // Agent bots by intents
    Route::get('bots/agent/{member}/intents/{intent}', [AgentBotsController::class, 'botsByIntents']);
    // Send a reply message to facebook users from UI
    Route::post('page/{page}/subscribers/{user}/messages', [FacebookController::class, 'messageSubscribers']);
    /**
     * Subscriptions
     */
    Route::post('subscription/{bot}/subscribe', [BotSubscriptionController::class, 'subscribe']);
    Route::delete('subscription/{bot}/unsubscribe', [BotSubscriptionController::class, 'unsubscribe']);
    Route::post('subscription/unsubscribe-many', [BotSubscriptionController::class, 'unsubscribeMany']);

    /**
     * Subscribers
     */
    Route::get('bots/{bot}/subscribers', [SubscriberController::class, 'index']);
    Route::put('subscribers/{id}/enable', [SubscriberController::class, 'enable']);
    Route::put('subscribers/{id}/disable', [SubscriberController::class, 'disable']);
    Route::get('subscribers/{id}/conversations', [SubscriberController::class, 'conversations']);
    Route::get('subscribers/{id}', [SubscriberController::class, 'show']);
    Route::put('subscribers/{id}', [SubscriberController::class, 'update']);
    Route::delete('subscribers/{id}', [SubscriberController::class, 'destroy']);
    // Profile
    Route::get('subscribers/{id}/profile', [SubscriberController::class, 'profile']);
});
