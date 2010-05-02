<?php defined('SYSPATH') or die('No direct script access');
/**
 * Description of searchhelper
 * @author Marek
 */
class Finder {

    private $model;
    private $pagination;


    public function   __construct(ORM $model, $items_per_page = 15) {
        $this->model = $model;
        $this->pagination = Pagination::factory(
            array('items_per_page' => $items_per_page)
        );
    }

    public function find_w_limit($order_by = 'id', $asc = 1) {
        $count = $this->model->count_all();
        return $this->get_result($count, $order_by, $asc);
    }

    public function find_by_value($field, $value) {
        $value = '%'.$value.'%';
        $count = $this->model->where($field, 'LIKE', $value)->count_all();
        $this->model->where($field, 'LIKE', $value);
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
