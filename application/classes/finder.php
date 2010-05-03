<?php 

class Finder {
    
    private $model;
    private $pagination;

    public function   __construct(ORM $model) {
        $this->model = $model;
        $this->pagination = new Pagination(array(
            'items_per_page' => 10
        ));
   
    }

    public function find_w_limit($limit, $order_by = 'id', $asc = TRUE) {
        $count = $this->model->count_all();
        $this->pagination->items_per_page = $limit;
        return $this->get_result($count, $order_by, $asc);
    }

    public function find_by_value($field, $value) {
        $value = '%'.$value.'%';
        $count = $this->model->where($field, 'LIKE', $value)->count_all();
       // $this->model->where($field, 'LIKE', $value);
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
