<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

# [START import]
use google\appengine\api\users\UserService;
# [END import]
# [START import_user]
use google\appengine\api\users\User;# [END import_user]

use Silex\Application;

// create the Silex application
$app = new Application();

$app->get('/login', function () use ($app) {
    # [START get_current_user]
    $user = UserService::getCurrentUser();
echo 'toto';
    if (isset($user)) {
        return sprintf('Welcome, %s! (<a href="%s">sign out</a>)',
            $user->getNickname(),
            UserService::createLogoutUrl('/'));
    } else {
        return sprintf('<a href="%s">Sign in or register</a>',
            UserService::createLoginUrl('/'));
    }
    # [END get_current_user]
});



$projectId = "upjv-ccm-etu-013";
$topicName = "userOnLine";
$user = UserService::getCurrentUser();
$message = $user->getNickname();
pubUserInTopic($projectId,$topicName,$message);

function pubUserInTopic($projectId, $topicName, $message)
{

    $pubsub = new PubSubClient([
        'projectId' => $projectId,
    ]);
    $topic = $pubsub->topic($topicName);
    $topic->publish(['data' => $message]);
}

return $app;
