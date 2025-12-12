<?php
// filepath: c:\xampp\htdocs\apkkasir\src\barang.php

include '../config/database.php';

$connection = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$query = "SELECT * FROM barang";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>
    <header>
        <h1>Daftar Barang</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nama_barang']; ?></td>
                            <td><?php echo number_format($row['harga'], 2); ?></td>
                            <td><?php echo $row['stok']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Tidak ada barang tersedia.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> FAUZAN APK. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$connection->close();
?>