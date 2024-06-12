<?php

class Product {
    private $name;
    private $price;
    private $quantity;

    public function __construct($name, $price, $quantity) {
        $this->setName($name);
        $this->setPrice($price);
        $this->setQuantity($quantity);
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        if (is_string($name) && !empty($name)) {
            $this->name = $name;
        } else {
            throw new Exception("Invalid name");
        }
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        if (is_numeric($price) && $price >= 0) {
            $this->price = $price;
        } else {
            throw new Exception("Invalid price");
        }
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        if (is_int($quantity) && $quantity >= 0) {
            $this->quantity = $quantity;
        } else {
            throw new Exception("Invalid quantity");
        }
    }

    public function __toString() {
        return "Product: {$this->name}, Price: {$this->price}, Quantity: {$this->quantity}";
    }
}

class Cart {
    private $products;

    public function __construct() {
        $this->products = [];
    }

    public function addProduct(Product $product) {
        $this->products[] = $product;
    }

    public function removeProduct(Product $product) {
        foreach ($this->products as $key => $item) {
            if ($item === $product) {
                unset($this->products[$key]);
                $this->products = array_values($this->products);
                return;
            }
        }
    }

    public function getTotal() {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getPrice() * $product->getQuantity();
        }
        return $total;
    }

    public function __toString() {
        $output = "Products in cart:\n";
        foreach ($this->products as $product) {
            $output .= $product . "\n";
        }
        $output .= "Total price: " . $this->getTotal();
        return $output;
    }
}

// Przykładowe użycie
try {
    header('Content-type: text/plain');

    $product1 = new Product("Laptop", 1500, 1);
    $product2 = new Product("Mouse", 50, 2);
    $product3 = new Product("Keyboard", 100, 1);

    $cart = new Cart();
    $cart->addProduct($product1);
    $cart->addProduct($product2);
    $cart->addProduct($product3);

    echo "Koszyk po dodaniu produktów:\n\n";
    echo $cart;

    $cart->removeProduct($product2);

    echo "\n\nKoszyk po zmianach:\n\n";
    echo $cart;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
