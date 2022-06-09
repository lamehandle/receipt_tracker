<?php

namespace app;

class Id
{
    private string $line_item_id;
    public static array $error = [];

    public function __construct(string $prefix) {

        $this->line_item_id = uniqid($prefix, false);
        self::get_errors($this->line_item_id);
    }

    public function id():string {
        return $this->line_item_id;
    }

    public function is_equal(string $comparator):bool{
        return $this->line_item_id === $comparator;
    }

    public static function get_errors($id):array{
    if (empty($id)) {
        $error[] = "No id exists.";
    }elseif(!is_string($id)){
        $error[] = "Must be a string.";
    }
    self::$error[] = "";
    return self::$error;
}


}