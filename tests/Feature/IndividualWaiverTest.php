<?php

use App\Tests\BrowserKitTest;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IndividualWaiverTest extends BrowserKitTest
{
    use DatabaseTransactions;

    public function testIndividualCanFillOutWaiver()
    {
        $this->visit('/sign-waiver')
            ->click('Individual Waiver')
            ->type('John Doe', 'between_name')
            ->type('JD', 'initial_1')
            ->type('JD', 'initial_2')
            ->type('JD', 'initial_3')
            ->type('John Doe', 'name')
            ->type('1234 Nowhere St', 'address')
            ->type('123-456-7890', 'phone')
            ->type('user@domain.com', 'email')
            ->type('1980/01/24', 'birth_date')
            ->type('Contact Name', 'contact_name')
            ->type('987-654-3210', 'contact_phone')
            ->type('Signature Data', 'signature')
            ->press('Save')
            ->seeInDatabase('waivers', [
                'between_name' => 'John Doe',
                'initial_1' => 'JD',
                'name' => 'John Doe',
                'address' => '1234 Nowhere St',
                'phone' => '123-456-7890',
                'email' => 'user@domain.com',
                'birth_date' => '1980-01-24',
                'contact_name' => 'Contact Name',
                'contact_phone' => '987-654-3210',
                'signature' => 'Signature Data',
            ]);

        $this->assertResponseOk();
    }
}
