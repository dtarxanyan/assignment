<?php

namespace App\Features;


use App\Managers\FBGraphManager;
use App\Managers\UserManager;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetFacebookUserFeature
{
    /**
     * @param int $id
     * @return \Facebook\GraphNodes\GraphUser
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function run(int $id)
    {
        $user = UserManager::findUser(['id' => $id]);

        if (!$user instanceof User) {
            throw new NotFoundHttpException('User not found');
        }

        $client = FBGraphManager::getClient();
        $fields = ['id', 'name', 'email', 'first_name', 'picture', 'languages'];

        return FBGraphManager::getUser($client, $user->facebook_token, $fields);
    }
}
