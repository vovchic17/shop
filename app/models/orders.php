<?php

class OrdersModel extends Model
{
    public function getOrders(int $userId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT order.order_id, order.quantity, car.id AS car_id, car.title, car.price 
        FROM `order`
        JOIN `car` ON order.product_id = car.id 
        WHERE order.user_id = :user_id"
        );
        $stmt->execute(['user_id' => $userId]);

        // Получаем все заказы
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Массив для хранения итоговых заказов
        $result = [];

        foreach ($orders as $order) {
            $orderId = $order['order_id'];

            // Если заказ с таким order_id еще не добавлен, создаем его
            if (!isset($result[$orderId])) {
                $result[$orderId] = [
                    'order_id' => $orderId,
                    'products' => [],
                    'total_price' => 0 // Инициализация суммы заказа
                ];
            }

            // Вычисляем стоимость текущего продукта в заказе
            $productTotalPrice = $order['price'] * $order['quantity'];

            // Добавляем продукт в список продуктов заказа
            $result[$orderId]['products'][] = [
                'car_id' => $order['car_id'],
                'title' => $order['title'],
                'price' => $order['price'],
                'quantity' => $order['quantity'],
            ];

            // Добавляем стоимость текущего продукта к общей сумме заказа
            $result[$orderId]['total_price'] += $productTotalPrice;
        }

        // Преобразуем массив в обычный массив (убираем ключи order_id)
        return array_values($result);
    }
}