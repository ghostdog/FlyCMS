<?php defined('SYSPATH') or die('No direct script access.');

class Pagination extends Kohana_Pagination {

    public function json_render() {
        $props['current_page'] = $this->current_page;
        $props['total_pages'] = $this->total_pages;
        $props['next_page'] = $this->next_page;
        $props['prev_page'] = $this->previous_page;
        $props['last_page'] = $this->last_page;
        $props['first_page'] = $this->first_page;
        $props['items_per_page'] = $this->items_per_page;

        return json_encode($output['pagination'] = $props);
    }

    public function render($view = NULL) {
        if (Request::$is_ajax) {
            return $this->json_render();
        } else return parent::render($view);
    }

}