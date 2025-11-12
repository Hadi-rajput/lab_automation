<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Configuration file must be in the parent directory
include '../config/db_connect.php';

// Check if a product ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // 1. Security Enhancement: Use Prepared Statement to prevent SQL Injection
    $stmt = $conn->prepare("
        SELECT p.*, c.categories_name 
        FROM products p
        JOIN categories c ON p.product_category = c.categories_id
        WHERE p.product_id = ?
    ");
    
    // Bind the integer ID parameter
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $query_result = $stmt->get_result();
    $product = $query_result->fetch_assoc();
    $stmt->close(); // Close the statement after execution

    if ($product) {
        // --- Document Generation Setup ---
        
        // Sanitize and define the output filename
        $filename = "Product_Report_" . $product['product_id'] . ".docx";

        // Set headers for DOCX download
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // --- DOCX XML Structure (WordprocessingML) ---

        // Helper function for consistent paragraph styling (bold label)
        function create_word_paragraph($label, $value, $is_bold = false) {
            $xml = '<w:p><w:r>';
            
            // Bold label
            $xml .= '<w:rPr><w:b/></w:rPr>';
            $xml .= '<w:t>' . htmlspecialchars($label) . ': </w:t>';
            
            // Normal value
            $xml .= '</w:r><w:r>';
            $xml .= '<w:t>' . htmlspecialchars($value) . '</w:t>';
            $xml .= '</w:r></w:p>';
            return $xml;
        }

        // Define the XML structure
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<w:document xmlns:w="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
  <w:body>';
        
        // --- Report Header ---
        $xml .= '<w:p><w:r><w:rPr><w:b/></w:rPr><w:t>PRODUCT DETAILS REPORT</w:t></w:r></w:p>';
        $xml .= '<w:p><w:r><w:t></w:t></w:r></w:p>'; // Blank line

        // --- Data Fields ---
        $xml .= create_word_paragraph('Report ID', $product['product_id']);
        $xml .= create_word_paragraph('Product Name', $product['product_name']);
        $xml .= create_word_paragraph('Category', $product['categories_name']);
        $xml .= create_word_paragraph('Initial Complaint', $product['product_description']);
        $xml .= create_word_paragraph('Submission Status', $product['product_status']);
        $xml .= create_word_paragraph('Final Review/Remarks', $product['review']);
        
        $xml .= '<w:p><w:r><w:t></w:t></w:r></w:p>'; // Blank line

        // --- Image Information ---
        $imagePath = "../admin/products/" . $product['product_image'];
        if (!empty($product['product_image']) && file_exists($imagePath)) {
            // Note: Embedding images requires complex binary encoding and relationship XML,
            // so we just confirm the image file exists here.
            $xml .= create_word_paragraph('Image File', basename($imagePath) . ' (Not embedded in this basic report)');
        } else {
            $xml .= create_word_paragraph('Image File', 'No Image Found');
        }

        // --- Footer ---
        $xml .= '<w:p><w:r><w:t></w:t></w:r></w:p>'; // Blank line
        $xml .= '<w:p><w:r><w:t>--- Report Generated on: ' . date('d M Y h:i A') . ' ---</w:t></w:r></w:p>';

        $xml .= '
  </w:body>
</w:document>';

        // Output the XML as a Word document
        echo $xml;
        exit;
    } else {
        // Product not found error handling
        echo "<script>alert('⚠️ Product not found!'); window.location='complete.php';</script>";
        exit(); // Ensure script stops
    }
} else {
    // Invalid request error handling
    echo "<script>alert('⚠️ Invalid request!'); window.location='complete.php';</script>";
    exit(); // Ensure script stops
}
?>