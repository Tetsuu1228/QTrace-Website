<?php
include 'database/connection/connection.php';

echo "=== Testing Articles Data ===\n\n";

// Check total articles
$result = $conn->query('SELECT COUNT(*) as total FROM articles_table');
$row = $result->fetch_assoc();
echo "Total articles: " . $row['total'] . "\n\n";

// Check article statuses
$result = $conn->query('SELECT article_ID, article_status FROM articles_table LIMIT 10');
echo "Article statuses:\n";
while($row = $result->fetch_assoc()) {
    echo "ID: {$row['article_ID']} - Status: {$row['article_status']}\n";
}

echo "\n=== Testing Published Articles ===\n\n";

// Check published articles
$result = $conn->query("SELECT COUNT(*) as total FROM articles_table WHERE article_status = 'Published'");
$row = $result->fetch_assoc();
echo "Published articles: " . $row['total'] . "\n\n";

// Test the featured query
$featured_query = "
    SELECT 
        a.article_ID,
        a.article_status,
        pd.ProjectDetails_Title
    FROM articles_table a
    INNER JOIN projects_table pt ON a.Project_ID = pt.Project_ID
    INNER JOIN projectdetails_table pd ON pt.Project_ID = pd.Project_ID
    WHERE a.article_status = 'Published'
    ORDER BY a.article_created_at DESC
    LIMIT 1
";

$result = $conn->query($featured_query);
if ($result && $result->num_rows > 0) {
    $article = $result->fetch_assoc();
    echo "Featured article found:\n";
    echo "ID: {$article['article_ID']}\n";
    echo "Title: {$article['ProjectDetails_Title']}\n";
} else {
    echo "No featured article found\n";
    if (!$result) {
        echo "Query error: " . $conn->error . "\n";
    }
}
?>
