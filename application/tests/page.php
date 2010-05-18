<?php defined('SYSPATH') or die('No direct script access');

class UnitTest_Page extends UnitTest_Case {
	public static $disabled = FALSE;
        protected $page;
	public $setup_has_run = FALSE;
        
	public function setup()
	{
                fire::log('setup');
		$this->setup_has_run = TRUE;
                $this->page = new Model_Page();
	}

        public function test_setup() {
                $this->assert_true($this->setup_has_run);
        }

        public function test_create_link_with_noise_at_end() {
            $this->page->title = 'Jakiś tam tytuł &&&$#@@()::';
            $this->page->check();
            $this->page->create_link();
            $this->assert_equal($this->page->link, 'jakis-tam-tytul');
        }

        public function test_create_link_with_noise_at_the_middle() {
            $this->page->title = 'Co jest???? &^%#@^ &^ @ %$ Mammamija coś tam';
            $this->page->check();
            $this->page->create_link();
            $this->assert_equal($this->page->link, 'co-jest-mammamija-cos-tam');
        }

        public function test_create_link_with_noise_at_the_begin() {
            $this->page->title = '___---%^&%& &^%& *(*( toruń warszawa i coś tam.....-0-0-0-';
            $this->page->check();
            $this->page->create_link();
            $this->assert_equal($this->page->link, 'torun-warszawa-i-cos-tam-0-0-0');
        }

    

}
?>
