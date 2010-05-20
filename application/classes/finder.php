<?php defined('SYSPATH') or die('No direct script access');

class Finder {
    
    private $model;
    private $pagination;

    public function   __construct(ORM $model) {
        $this->model = $model;
        $this->pagination = new Pagination;
    }

    public function find_all($limit = 10, $order_by = 'id', $asc = TRUE) {
        $count = $this->model->reset(FALSE)->count_all();
        $this->pagination->items_per_page = $limit;
        return $this->get_result($count, $order_by, $asc);
    }

    public function find_by_value($field, $value, $limit = NULL) {
        $value = '%'.$value.'%';
        if (! is_null($limit)) {
            $this->pagination->items_per_page = $limit;
        }
        $count = $this->model->where($field, 'LIKE', $value)->reset(FALSE)->count_all();
        return $this->get_result($count);
    }

    public function get_pagination_links() {
        return $this->pagination->render();
    }

    private function get_result($count, $order_by = 'id', $asc = TRUE) {
        $this->pagination->total_items = $count;
        return $this->model
                    ->order_by($order_by, ($asc) ? 'ASC' : 'DESC')
                    ->limit($this->pagination->items_per_page)
                    ->offset($this->pagination->offset)
                    ->find_all();
    }
}
?>
