<?php

class MerchandiseCest
{

    public function _before(ApiTester $I)
    {
    }

    public function tryToTest(ApiTester $I)
    {
        $I->amBearerAuthenticated('623e3265138f5a2a6cdace25e3b1e160');
        $I->sendGET('/merchandises/api-wares');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }
}
