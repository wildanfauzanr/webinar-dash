<?php

class Product {
    public $product_id;
    public $product_name;
    public $price;
    public $stock;

    public function __construct($product_id, $product_name, $price, $stock) {
        $this->product_id = $product_id;
        $this->product_name = $product_name;
        $this->price = $price;
        $this->stock = $stock;
    }
}


class ProductController {
    private $products = [];

    public function addProduct($product) {
        $this->products[] = $product;
    }

    public function getProducts() {
        return $this->products;
    }
}


