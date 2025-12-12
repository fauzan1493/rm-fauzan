<?php
// filepath: c:\xampp\htdocs\apkkasir\src\cetak_nota.php

include '../config/database.php';

// Start session to access session variables
session_start();

// Check if there is a transaction to print
if (!isset($_SESSION['transaction'])) {
    echo "No transaction found.";
    exit;
}

// Get transaction details from session
$transaction = $_SESSION['transaction'];

// Clear the transaction from session
unset($_SESSION['transaction']);

// Function to format currency
function formatCurrency($amount) {
    return "Rp " . number_format($amount, 2, ',', '.');
}

// Print the receipt
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <link rel="stylesheet" href="../public/assets/style.css">
</head>
<body>
    <div class="receipt">
        <h1>Nota Transaksi</h1>
        <p>Tanggal: <?php echo date('Y-m-d H:i:s'); ?></p>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaction['items'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><?php echo formatCurrency($item['price']); ?></td>
                        <td><?php echo formatCurrency($item['total']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <hr>
        <h2>Total Pembayaran: <?php echo formatCurrency($transaction['total']); ?></h2>
        <button onclick="window.print()">Print Nota</button>
    </div>
</body>
</html>