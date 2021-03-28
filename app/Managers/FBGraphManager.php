<?php

namespace App\Managers;


use Facebook\Facebook;

class FBGraphManager
{
    /**
     * @return Facebook
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public static function getClient()
    {
        return new Facebook([
            'app_id' => config('facebook_graph.app_id'),
            'app_secret' => config('facebook_graph.app_secret'),
            'default_graph_version' => config('facebook_graph.default_graph_version'),
        ]);
    }

    /**
     * @param Facebook $client
     * @param string $accessToken
     * @param array $fields
     * @return \Facebook\GraphNodes\GraphUser
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public static function getUser(Facebook $client, string $accessToken, array $fields = [])
    {
        $response = $client->get('/me?fields=' . implode(',', $fields), $accessToken);

        return $response->getGraphUser();
    }
}
