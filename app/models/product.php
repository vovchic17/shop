<?php

class ProductModel extends Model
{
    public function getProducts(
        ?string $brand = null,
        ?string $scale = null,
        ?string $category = null,
        ?string $car_brand = null,
        ?int $year = null,
        ?string $country = null,
        ?int $min_price = null,
        ?int $max_price = null,
        ?string $search = null,
        int $limit = 20,
        int $page = 1
    ) {
        $query = "SELECT * FROM `car` WHERE 1=1";
        $params = [];

        // подстановка значений в запрос,
        // если они были переданы
        if ($brand !== null) {
            $query .= " AND brand = :brand";
            $params['brand'] = $brand;
        }
        if ($scale !== null) {
            $query .= " AND scale = :scale";
            $params['scale'] = $scale;
        }
        if ($category !== null) {
            $query .= " AND category = :category";
            $params['category'] = $category;
        }
        if ($car_brand !== null) {
            $query .= " AND car_brand = :car_brand";
            $params['car_brand'] = $car_brand;
        }
        if ($year !== null) {
            $query .= " AND year = :year";
            $params['year'] = $year;
        }
        if ($country !== null) {
            $query .= " AND country = :country";
            $params['country'] = $country;
        }
        if ($min_price !== null) {
            $query .= " AND price >= :min_price";
            $params['min_price'] = $min_price;
        }
        if ($max_price !== null) {
            $query .= " AND price <= :max_price";
            $params['max_price'] = $max_price;
        }
        if ($search !== null) {
            $search = "%$search%";
            $query .= " AND title LIKE :search";
            $params['search'] = $search;
        }

        // подсчет общего количества товаров по запросу
        $times = 1;
        $countQuery = str_replace("*", "COUNT(*)", $query, $times);
        $countStmt = $this->pdo->prepare($countQuery);
        $countStmt->execute($params);

        $offset = ($page - 1) * $limit;
        $query .= " LIMIT $limit OFFSET $offset";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return [
            "result" => $stmt->fetchAll(PDO::FETCH_ASSOC),
            "count" => $countStmt->fetchColumn()
        ];
    }

    public function getCategories()
    {
        $stmt = $this->pdo->prepare("
        SELECT DISTINCT brand, scale, category, car_brand, year, country FROM `car`");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categories = [
            'brand' => [],
            'scale' => [],
            'category' => [],
            'car_brand' => [],
            'year' => [],
            'country' => [],
        ];

        foreach ($result as $row) {
            foreach ($categories as $key => &$values) {
                if (!in_array($row[$key], $values)) {
                    $values[] = $row[$key];
                }
            }
        }

        // Сортировка значений в категориях
        foreach ($categories as &$values)
            sort($values);

        return $categories;
    }

    public function getProductById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM `car` WHERE id = :id");
        $stmt->execute(["id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}