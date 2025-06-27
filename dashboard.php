<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "includes/db.php";

$user_id = $_SESSION["id"];
$snippets = [];

$search_query = "";
$tag_filter = "";

if(isset($_GET["search"]) && !empty(trim($_GET["search"])) ){
    $search_query = trim($_GET["search"]);
}

if(isset($_GET["tag"]) && !empty(trim($_GET["tag"])) ){
    $tag_filter = trim($_GET["tag"]);
}

$sql = "SELECT s.id, s.title, s.description, s.created_at, GROUP_CONCAT(t.name SEPARATOR ', ') AS tags FROM snippets s LEFT JOIN snippet_tags st ON s.id = st.snippet_id LEFT JOIN tags t ON st.tag_id = t.id WHERE s.user_id = ?";

$params = ["i", $user_id];

if(!empty($search_query)){
    $sql .= " AND (s.title LIKE ? OR s.description LIKE ?)";
    $params[0] .= "ss";
    $params[] = "%" . $search_query . "%";
    $params[] = "%" . $search_query . "%";
}

if(!empty($tag_filter)){
    $sql .= " AND s.id IN (SELECT snippet_id FROM snippet_tags WHERE tag_id = (SELECT id FROM tags WHERE name = ?))";
    $params[0] .= "s";
    $params[] = $tag_filter;
}

$sql .= " GROUP BY s.id ORDER BY s.created_at DESC";

if($stmt = mysqli_prepare($link, $sql)){
    // Dynamically bind parameters
    $types = array_shift($params);
    mysqli_stmt_bind_param($stmt, $types, ...$params);

    if(mysqli_stmt_execute($stmt)){
        $result = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_assoc($result)){
            $snippets[] = $row;
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
?>

<?php include 'includes/header.php'; ?>

<h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to CodeVault.</h1>
<p>
    <a href="create_snippet.php" class="btn btn-success">Add New Snippet</a>
    <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
</p>

<h2>Your Snippets</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get" class="form-inline mb-4">
    <input type="text" name="search" class="form-control mr-2" placeholder="Search by title or description" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <input type="text" name="tag" class="form-control mr-2" placeholder="Filter by tag" value="<?php echo isset($_GET['tag']) ? htmlspecialchars($_GET['tag']) : ''; ?>">
    <button type="submit" class="btn btn-info">Search/Filter</button>
    <a href="dashboard.php" class="btn btn-secondary ml-2">Clear</a>
</form>

<?php if(empty($snippets)): ?>
    <div class="alert alert-info">No snippets found.</div>
<?php else: ?>
    <div class="row">
        <?php foreach($snippets as $snippet): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($snippet['title']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Created: <?php echo date('F j, Y, g:i a', strtotime($snippet['created_at'])); ?></h6>
                        <?php if(!empty($snippet['description'])): ?>
                            <p class="card-text"><?php echo htmlspecialchars(substr($snippet['description'], 0, 100)); ?>...</p>
                        <?php endif; ?>
                        <?php if(!empty($snippet['tags'])): ?>
                            <p class="card-text"><small class="text-muted">Tags: <?php echo htmlspecialchars($snippet['tags']); ?></small></p>
                        <?php endif; ?>
                        <a href="view_snippet.php?id=<?php echo $snippet['id']; ?>" class="btn btn-info btn-sm">View</a>
                        <a href="edit_snippet.php?id=<?php echo $snippet['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                        <a href="delete_snippet.php?id=<?php echo $snippet['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this snippet?');">Delete</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>