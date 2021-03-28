<?php

namespace App\Features;


use App\Managers\FBGraphManager;
use App\Managers\UserManager;
use App\Models\User;

class GetAccessWithFacebookTokenFeature
{
    /**
     * @param string $FBAccessToken
     * @return \Laravel\Passport\PersonalAccessTokenResult
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function run(string $FBAccessToken)
    {
        $fb = FBGraphManager::getClient();
        $fields = ['id'];

        $FBUser = FBGraphManager::getUser($fb, $FBAccessToken, $fields);
        $user = UserManager::findUser(['facebook_id' => $FBUser->getId()]);

        if (!$user instanceof User) {
            $user = UserManager::createUser([
                'facebook_id' => $FBUser->getId(),
                'facebook_token' => $FBAccessToken,
            ]);
        } else {
            $user->facebook_token = $FBAccessToken;
            $user->save();
        }

        return $user->createToken('personal');
    }
}
