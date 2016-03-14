<?php

use app\v1\models\User;

class UserCest
{
    public $token;

    /**
     * @param ApiTester $I
     * @return bool
     */
    public function signup(ApiTester $I)
    {
        $I->wantTo('Signup and take my token');

        $I->sendPOST('/signup');

        $I->seeResponseCodeIs(200);
        $I->canSeeResponseIsJson();

        $response = json_decode($I->grabResponse(), true);
        $I->assertTrue(isset($response['token']));
    }
}