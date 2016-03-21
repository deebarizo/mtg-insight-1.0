<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Illuminate\Http\Request;

class ScrapersControllerTest extends TestCase {

	use DatabaseTransactions;

	/** @test */
    public function submits_url() {

       	$this->visit('scrapers/sites');
       	# $this->select('DTK', 'starting-set-code');
       	# $this->select('OGW', 'ending-set-code');
       	$this->type('http://www.mtggoldfish.com/', 'url');
       	$this->press('Submit');
    }

    /** @test */
    public function fetches_rares_and_mythic_rares_from_current_standard_sets() {


    }

}