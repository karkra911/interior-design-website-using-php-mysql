<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "includes/db.php";

$snippet = null;

if(isset($_GET["id"]) && !empty(trim($_GET["id"])) ){
    $id = trim($_GET["id"]);
    
    $sql = "SELECT s.id, s.title, s.code, s.description, s.created_at, GROUP_CONCAT(t.name SEPARATOR ', ') AS tags FROM snippets s LEFT JOIN snippet_tags st ON s.id = st.snippet_id LEFT JOIN tags t ON st.tag_id = t.id WHERE s.id = ? AND s.user_id = ? GROUP BY s.id";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "ii", $param_id, $param_user_id);
        
        $param_id = $id;
        $param_user_id = $_SESSION["id"];
        
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            if(mysqli_num_rows($result) == 1){
                $snippet = mysqli_fetch_assoc($result);
            } else{
                header("location: error.php");
                exit();
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
} else{
    header("location: error.php");
    exit();
}
mysqli_close($link);
?>

<?php include 'includes/header.php'; ?>

<?php if($snippet): ?>
    <h2><?php echo htmlspecialchars($snippet['title']); ?></h2>
    <p class="text-muted">Created: <?php echo date('F j, Y, g:i a', strtotime($snippet['created_at'])); ?></p>
    <?php if(!empty($snippet['tags'])): ?>
        <p class="text-muted">Tags: <?php echo htmlspecialchars($snippet['tags']); ?></p>
    <?php endif; ?>
    <?php if(!empty($snippet['description'])): ?>
        <h4>Description:</h4>
        <p><?php echo nl2br(htmlspecialchars($snippet['description'])); ?></p>
    <?php endif; ?>
    
    <h4>Code:</h4>
    <pre><code class="language-php"><?php 
        // Basic syntax highlighting for PHP. For other languages, it will just be HTML escaped.
        if (strpos($snippet['tags'], 'php') !== false) {
            highlight_string($snippet['code']);
        } else {
            echo htmlspecialchars($snippet['code']);
        }
    ?></code></pre>

    <p>
        <a href="edit_snippet.php?id=<?php echo $snippet['id']; ?>" class="btn btn-primary">Edit</a>
        <a href="delete_snippet.php?id=<?php echo $snippet['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this snippet?');">Delete</a>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </p>
<?php else: ?>
    <div class="alert alert-danger">Snippet not found or you do not have permission to view it.</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>