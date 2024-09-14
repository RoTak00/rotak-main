<?php
// Get the requested URI path
$trimmedPath = isset($_GET['path']) ? trim($_GET['path'], '/') : '';

// Split the path into components
$pathComponents = explode('/', $trimmedPath);



$parentId = 0; // Start with no parent
$foundPost = null;
$foundCategory = null;
$contentLoaded = false;

$page_title = null;
$page_alias = null;

foreach ($pathComponents as $component) {

    if (!$foundCategory) {
        // First, try to find it as a category
        $stmt = $conn->prepare("SELECT * FROM post_categories WHERE alias = ? AND parent = ? AND active = 1 ORDER BY ordering asc");
        $stmt->bind_param("si", $component, $parentId);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();

        if ($category) {
            // If found as category, update parentId for the next iteration
            $parentId = $category['category_id'];
            $foundCategory = $category;
            $stmt->close();

            continue; // Move to the next component
        }

        $stmt->close();
    }




    // If not found as category, try finding it as a post within the last found category

    $stmt = $conn->prepare("SELECT * FROM posts WHERE alias = ? AND category = ? ORDER BY ordering asc");
    $stmt->bind_param("si", $component, $parentId);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();



    if ($post) {
        $foundPost = $post;
        $stmt->close();

        // Load HTML content from the file specified in the 'page' column
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/posts/' . $foundPost['page'];

        if (file_exists($filePath)) {
            $postContent = file_get_contents($filePath);
            $page_title = $post['title'];
            $page_alias = $post['alias'];
            $contentLoaded = true;

        } else {
            // Handle error if file does not exist
            ob_start();
            include __DIR__ . '/post-not-found-html.php';
            $postContent = ob_get_clean();
            ob_end_clean();
            $page_title = 'Page Not Found';
            $page_alias = '404';
        }
        break; // Stop the loop if a post is found
    }
    $stmt->close();

    break;
}

if (!$contentLoaded && $foundCategory) {

    $postContent = "";
    // Check if the category has a valid "page"

    if (!empty($foundCategory['page'])) {
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/posts/' . $foundCategory['page'];

        if (file_exists($filePath)) {
            $categoryContent = file_get_contents($filePath);
            $postContent = $categoryContent;
            $contentLoaded = true;
        }
    }

    if ($foundCategory['show_list'] || !$contentLoaded) {
        // Fetch child categories
        $stmt = $conn->prepare("SELECT * FROM post_categories WHERE parent = ? AND active = 1 ORDER BY ordering asc");
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        $categoriesResult = $stmt->get_result();


        // Fetch posts in the category
        $stmt = $conn->prepare("SELECT * FROM posts WHERE category = ? and active = 1 ORDER BY ordering asc");
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        $postsResult = $stmt->get_result();



        if ($categoriesResult->num_rows > 0) {
            $postContent .= "<h3>Subcategories in '{$foundCategory['title']}'</h3>";
            while ($childCategory = $categoriesResult->fetch_assoc()) {
                $postContent .= "<a href='{$foundCategory['alias']}/{$childCategory['alias']}'>{$childCategory['title']}</a><br>";
            }
        }

        if ($postsResult->num_rows > 0) {
            $postContent .= "<h3>Posts in '{$foundCategory['title']}'</h3>";
            while ($post = $postsResult->fetch_assoc()) {
                $postContent .= "<a href='/{$foundCategory['alias']}/{$post['alias']}'>{$post['title']}</a><br>";
            }
        }

        if (!$postsResult->num_rows && !$categoriesResult->num_rows) {
            $postContent .= "<h3>No posts or subcategories in '{$foundCategory['title']}'</h3>";
        }

        $contentLoaded = true;
    }


    $page_title = $foundCategory['title'];
    $page_alias = $foundCategory['alias'];
}


$page_category = $foundCategory ? $foundCategory['alias'] : '';
// Use $foundCategory and $foundPost as needed
if (!$contentLoaded) {

    ob_start();
    include __DIR__ . '/post-not-found-html.php';
    $postContent = ob_get_clean();
    ob_end_clean();
    $page_title = 'Page Not Found';
    $page_alias = '404';
}




// gets all categories for menu

// Assuming $conn is your MySQLi database connection

// Fetch all main categories
$mainCategoriesStmt = $conn->prepare("SELECT category_id, title, alias FROM post_categories WHERE parent = 0 AND active = 1 ORDER BY ordering ASC");
$mainCategoriesStmt->execute();
$mainCategoriesResult = $mainCategoriesStmt->get_result();

$categories = [];

while ($mainCategory = $mainCategoriesResult->fetch_assoc()) {
    // For each main category, fetch its active children
    $childrenStmt = $conn->prepare("SELECT category_id, title, alias FROM post_categories WHERE parent = ? AND active = 1 ORDER BY ordering ASC");
    $childrenStmt->bind_param("i", $mainCategory['category_id']);
    $childrenStmt->execute();
    $childrenResult = $childrenStmt->get_result();

    $children = [];
    while ($child = $childrenResult->fetch_assoc()) {
        // Add each child to the children array
        $children[] = [
            'title' => $child['title'],
            'alias' => $child['alias']
        ];
    }

    // Add the main category and its children to the categories array
    $categories[$mainCategory['title']] = [
        'title' => $mainCategory['title'],
        'alias' => $mainCategory['alias'],
        'children' => $children
    ];
}


