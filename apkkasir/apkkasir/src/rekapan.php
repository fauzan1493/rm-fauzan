<?php
// filepath: c:\xampp\htdocs\apkkasir\src\rekapan.php

include '../config/database.php';

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM transaksi ORDER BY tanggal DESC";
$result = $conn->query($sql);

include '../templates/header.php';
?>

<div class="container mx-auto mt-5">
    <h2 class="text-2xl font-semibold mb-4">Rekapan Transaksi</h2>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID Transaksi</th>
                <th class="py-2 px-4 border-b">Tanggal</th>
                <th class="py-2 px-4 border-b">Total</th>
                <th class="py-2 px-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo $row['id_transaksi']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo $row['tanggal']; ?></td>
                        <td class="py-2 px-4 border-b"><?php echo number_format($row['total'], 2); ?></td>
                        <td class="py-2 px-4 border-b">
                            <a href="cetak_nota.php?id=<?php echo $row['id_transaksi']; ?>" class="text-blue-600 hover:underline">Cetak Nota</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="py-2 px-4 border-b text-center">Tidak ada transaksi</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$conn->close();
include '../templates/footer.php';
?>