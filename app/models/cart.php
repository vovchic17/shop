<?php

class CartModel extends Model
{
    public function add(int $userId, int $productId, int $quantity)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO `cart`(user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)
            ON DUPLICATE KEY UPDATE quantity = :quantity"
        );
        $stmt->execute(
            [
                "user_id" => $userId,
                "product_id" => $productId,
                "quantity" => $quantity
            ]
        );
    }

    public function delete(int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM `cart` WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute([
            "user_id" => $userId,
            "product_id" => $productId
        ]);
    }

    public function getProduct(int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT quantity FROM `cart` WHERE user_id = :user_id AND product_id = :product_id"
        );
        $stmt->execute([
            "user_id" => $userId,
            "product_id" => $productId
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCart(int $userId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT car.id, car.title, car.price, cart.quantity FROM `cart`
            JOIN `car` ON cart.product_id = car.id WHERE cart.user_id = :user_id"
        );
        $stmt->execute(["user_id" => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function order(int $userId)
    {
        $orderId = $this->pdo->query("SELECT IFNULL(MAX(order_id), 0) + 1 FROM `order`")->fetchColumn();
        $this->pdo->prepare("
            INSERT INTO `order` (order_id, user_id, product_id, quantity) (
            SELECT :order_id, :user_id, product_id, quantity
            FROM `cart`
            WHERE user_id = :user_id)
        ")->execute(["order_id" => $orderId, "user_id" => $userId]);
        $this->pdo->prepare(
            "DELETE FROM `cart` WHERE user_id = :user_id"
        )->execute(["user_id" => $userId]);
    }
}