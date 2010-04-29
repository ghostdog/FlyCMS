<?php defined('SYSPATH') or die('No direct script access');

class UnitTest_Page extends UnitTest_Case {
	public static $disabled = FALSE;
        protected $page;
	public $setup_has_run = FALSE;
        
        public $filled_meta_data = array('keywords' => 'The best keywords I have', 'description' => 'The best description I know');
        public $empty_meta_data = array('keywords' => '    ', 'description' => '   ');
        public $set_page_meta_on = array('set_keywords' => 'on', 'set_description' => 'on');

        public $filled_template_data = array('template_id' => '34', 'header_on' => '1', 'footer_on' => '0', 'sidebar_on' => '1');
        public $global_template_data = array('template_id' => '-1', 'header_on' => '-1', 'footer_on' => '-1', 'sidebar_on' => '-1');

        public $post_witout_required_vals = array('author' => 'Jakiś tam autor');
        public $post_with_required_title = array('title' => 'sada');
        public $post_with_all_required_fill = array('title' => 'sad', 'content' => 'addddasdasd');

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

        public function test_keywords_exists() {
            $this->page->keywords = 'keyword';
            $this->assert_true($this->page->has_keywords());
        }

        public function test_description_exists() {
            $this->page->description = 'description';
            $this->assert_true($this->page->has_description());
        }

        public function test_keywords_not_exists() {
            $this->page->keywords = NULL;
            $this->assert_false($this->page->has_keywords());
        }

        public function test_description_not_exists() {
            $this->page->description = NULL;
            $this->assert_false($this->page->has_description());
        }

        public function test_global_set_header_exists() {
            $this->assert_true($this->page->has_global_header_setting());
        }

        public function test_global_set_footer_exists() {
            $this->assert_true($this->page->has_global_footer_setting());
        }

        public function test_global_set_sidebar_exists() {
            $this->assert_true($this->page->has_global_sidebar_setting());
        }

        public function test_page_header_on() {
            $this->page->header_on = 0;
            $this->assert_false($this->page->has_global_header_setting());
        }

        public function test_page_footer_on() {
            $this->page->footer_on = 0;
            $this->assert_false($this->page->has_global_footer_setting());
        }

        public function test_page_sidebar_on() {
            $this->page->sidebar_on = 0;
            $this->assert_false($this->page->has_global_sidebar_setting());
        }

        public function test_page_has_own_template_set() {
            $this->page->template_id = 34;
            $this->assert_false($this->page->has_global_template_setting());
        }

        public function test_keywords_are_set_and_required() {
           $values = arr::merge($this->filled_meta_data, $this->set_page_meta_on);
           $this->page->values($values);
           $this->assert_true($this->page->has_keywords());
        }

        public function test_description_is_set_and_required() {
           $values = arr::merge($this->filled_meta_data, $this->set_page_meta_on);
           $this->page->values($values);
           $this->assert_true($this->page->has_description());
        }

        public function test_keywords_are_not_set_but_required() {
            $this->page->values(arr::merge($this->set_page_meta_on, $this->empty_meta_data));
            $this->assert_false($this->page->has_keywords());
        }

        public function test_description_is_not_set_but_required() {
            $this->page->values(arr::merge($this->set_page_meta_on, $this->empty_meta_data));
            $this->assert_false($this->page->has_description());
        }

        public function test_keywords_are_not_set_and_not_required() {
            $this->page->values($this->filled_meta_data);
            $this->assert_false($this->page->has_keywords());
        }

        public function test_description_is_not_set_and_not_required() {
            $this->page->values($this->filled_meta_data);
            $this->assert_false($this->page->has_description());
        }

        public function test_template_is_not_global() {
            $this->page->values($this->filled_template_data);
            $this->assert_false($this->page->has_global_template_setting());
        }

        public function test_header_is_not_global() {
            $this->page->values($this->filled_template_data);
            $this->assert_false($this->page->has_global_header_setting());
        }

        public function test_footer_is_not_global() {
            $this->page->values($this->filled_template_data);
            $this->assert_false($this->page->has_global_footer_setting());
        }

        public function test_sidebar_is_not_global() {
            $this->page->values($this->filled_template_data);
            $this->assert_false($this->page->has_global_sidebar_setting());
        }

        public function test_template_is_global() {
            $this->page->values($this->global_template_data);
            $this->assert_true($this->page->has_global_template_setting());
        }

        public function test_header_is_global() {
            $this->page->values($this->global_template_data);
            $this->assert_true($this->page->has_global_header_setting());
        }

        public function test_footer_is_global() {
            $this->page->values($this->global_template_data);
            $this->assert_true($this->page->has_global_footer_setting());
        }

        public function test_sidebar_is_global() {
            $this->page->values($this->global_template_data);
            $this->assert_true($this->page->has_global_sidebar_setting());
        }


        public function test_validate_must_fail() {
            $this->page->values($this->post_witout_required_vals);
            $this->assert_false($this->page->check());
        }

        public function test_validate_with_title_filled_must_fail() {
            $this->page->values(arr::merge($this->post_witout_required_vals, $this->post_with_required_title));
            $this->assert_false($this->page->check());
        }

        public function test_validate_must_pass() {
            $this->page->values($this->post_with_all_required_fill);
            $this->assert_true($this->page->check());
        }

        public function test_has_author() {
            $this->page->values(array('author' => 'autor'));
            $this->assert_true($this->page->has_author());
        }

        public function test_has_not_author() {
            $this->page->values(array('author' => '     '));
            $this->assert_false($this->page->has_author());
        }

}
?>
