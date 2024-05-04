<?php
require_once 'dbh.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];

    try {
        $pdo->beginTransaction(); // Start

        // product verification using id
        $check_query = "SELECT COUNT(*) FROM products WHERE product_id = :product_id";
        $check_stmt = $pdo->prepare($check_query);
        $check_stmt->bindParam(':product_id', $product_id);
        $check_stmt->execute();
        $count = $check_stmt->fetchColumn();

        if ($count > 0) {
            $query = "DELETE FROM products WHERE product_id = :product_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
            $pdo->commit(); // Commit
            header('Location: ../mainInterface.php');
        } else {
            throw new Exception("Product not found");
        }
    } catch (Exception $e) {
        $pdo->rollback(); // Rollback
        ?>
        <script>
            alert('Error: <?php echo $e->getMessage(); ?>');
            history.back();
        </script>
        <?php
    }
}
?>
