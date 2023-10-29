-- Truy van de tinh doanh thu moi thang
SELECT
    EXTRACT(MONTH FROM order_date) AS month,
    EXTRACT(YEAR FROM order_date) AS year,
    SUM(unit_price * quantity) AS monthly_revenue
FROM Orders o
JOIN OrderDetails od ON o.order_id = od.order_id
WHERE EXTRACT(YEAR FROM order_date) = EXTRACT(YEAR FROM CURRENT_DATE)
GROUP BY EXTRACT(YEAR FROM order_date), EXTRACT(MONTH FROM order_date)
ORDER BY EXTRACT(YEAR FROM order_date), EXTRACT(MONTH FROM order_date);


-- Truy vấn lấy thương hiệu bán chạy nhất của mỗi tháng của năm hiện tại
WITH MonthlySales AS (
    SELECT
        EXTRACT(YEAR FROM o.order_date) AS year,
        EXTRACT(MONTH FROM o.order_date) AS month,
        p.maker_id,
        SUM(od.quantity) AS sales_count,
        RANK() OVER (PARTITION BY EXTRACT(YEAR FROM o.order_date), EXTRACT(MONTH FROM o.order_date) ORDER BY COUNT(*) DESC) AS rnk
    FROM Orders o
    JOIN OrderDetails od ON o.order_id = od.order_id
    JOIN Products p ON od.product_id = p.product_id
    WHERE EXTRACT(YEAR FROM o.order_date) = EXTRACT(YEAR FROM CURRENT_DATE)
    GROUP BY EXTRACT(YEAR FROM o.order_date), EXTRACT(MONTH FROM o.order_date), p.maker_id
)
SELECT
    YEAR,
    month,
    maker_id,
    (SELECT maker_name FROM Makers m WHERE m.maker_id = ms.maker_id) AS best_selling_maker,
    sales_count
FROM MonthlySales ms
WHERE rnk = 1;


