<?php


class TableColumnData {
    private $column_name;
    private $data;

    public function __construct($column_name, $data) {
        $this->column_name = $column_name;
        $this->data = $data;
    }

}