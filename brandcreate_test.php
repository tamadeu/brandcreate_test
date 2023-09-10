<!DOCTYPE html>
<html>
<head>
    <title>Car Table</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 16px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        form {
            margin-top: 20px;
        }

        select, input[type="submit"], button {
            padding: 10px 20px;
            margin: 0 5px;
            cursor: pointer;
        }

        select {
            width: 200px;
        }

        input[type="submit"], button {
            background-color: #007BFF;
            border: none;
            color: white;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('table');
            const rows = Array.from(table.querySelectorAll('tr')).slice(1);
            const sortBtn = document.getElementById('sortColor');

            sortBtn.addEventListener('click', () => {
                rows.sort((a, b) => {
                    const aColor = a.cells[5].textContent;
                    const bColor = b.cells[5].textContent;
                    return aColor.localeCompare(bColor);
                });

                rows.forEach(row => table.appendChild(row));
            });
        });
    </script>
</head>
<body>

<?php
$json = '[
    {"car_name": "Tesla Model S", "price": 79999, "discount": 5000, "hand": 4, "availability": "In Stock", "color": "Red"},
    {"car_name": "Toyota Prius", "price": 24999, "discount": 2000, "hand": 2, "availability": "Out of Stock", "color": "Blue"},
    {"car_name": "Ford Mustang", "price": 55999, "discount": 3000, "hand": 3, "availability": "In Stock", "color": "Black"},
    {"car_name": "Audi A4", "price": 39999, "discount": 4500, "hand": 1, "availability": "In Stock", "color": "White"},
    {"car_name": "BMW 3 Series", "price": 41999, "discount": 4000, "hand": 1, "availability": "Out of Stock", "color": "Silver"}
]';

$data = json_decode($json, true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sortOrder = $_POST['sortOrder'];
    if ($sortOrder == 'asc') {
        usort($data, fn($a, $b) => $a['price'] <=> $b['price']);
    } elseif ($sortOrder == 'desc') {
        usort($data, fn($a, $b) => $b['price'] <=> $a['price']);
    }
}
?>

<form method="post">
    <select name="sortOrder">
        <option value="asc">Low to High</option>
        <option value="desc">High to Low</option>
    </select>
    <input type="submit" value="Sort by Price">
</form>

<button id="sortColor">Sort by Color</button>

<table border="1">
    <tr>
        <th>Car Name</th>
        <th>Price</th>
        <th>Discount</th>
        <th>Hand</th>
        <th>Availability</th>
        <th>Color</th>
    </tr>
    <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo $row['car_name']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['discount']; ?></td>
                <td><?php echo $row['hand']; ?></td>
                <td><?php echo $row['availability']; ?></td>
                <td><?php echo $row['color']; ?></td>
            </tr>
    <?php endforeach; ?>
</table>

<h2>Here's another go using DataTables</h2>
<h4>Click on any column name to sort the column</h4>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Car Name</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Hand</th>
                <th>Availability</th>
                <th>Color</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Car Name</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Hand</th>
                <th>Availability</th>
                <th>Color</th>
            </tr>
        </tfoot>
    </table>
    <script>
    const data = [
        {"car_name": "Tesla Model S", "price": 79999, "discount": 5000, "hand": 4, "availability": "In Stock", "color": "Red"},
        {"car_name": "Toyota Prius", "price": 24999, "discount": 2000, "hand": 2, "availability": "Out of Stock", "color": "Blue"},
        {"car_name": "Ford Mustang", "price": 55999, "discount": 3000, "hand": 3, "availability": "In Stock", "color": "Black"},
        {"car_name": "Audi A4", "price": 39999, "discount": 4500, "hand": 1, "availability": "In Stock", "color": "White"},
        {"car_name": "BMW 3 Series", "price": 41999, "discount": 4000, "hand": 1, "availability": "Out of Stock", "color": "Silver"}
    ];

    $(document).ready(function () {
        $('#example').DataTable({
            data: data,
            columns: [
                { data: 'car_name' },
                { 
                    data: 'price',
                    render: function (data, type, row) {
                        return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(data);
                    }
                },
                { 
                    data: 'discount',
                    render: function (data, type, row) {
                        return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(data);
                    }
                },
                { data: 'hand' },
                { data: 'availability' },
                { data: 'color' }
            ]
        });
    });


    </script>
</body>
</html>
