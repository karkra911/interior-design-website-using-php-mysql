<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "includes/db.php";

$title = $code = $description = $tags = "";
$title_err = $code_err = "";
$snippet_id = null;

// Process GET request for existing snippet data
if(isset($_GET["id"]) && !empty(trim($_GET["id"])) ){
    $snippet_id = trim($_GET["id"]);
    
    $sql = "SELECT s.id, s.title, s.code, s.description, GROUP_CONCAT(t.name SEPARATOR ', ') AS tags FROM snippets s LEFT JOIN snippet_tags st ON s.id = st.snippet_id LEFT JOIN tags t ON st.tag_id = t.id WHERE s.id = ? AND s.user_id = ? GROUP BY s.id";

    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "ii", $param_id, $param_user_id);
        
        $param_id = $snippet_id;
        $param_user_id = $_SESSION["id"];
        
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                $title = $row['title'];
                $code = $row['code'];
                $description = $row['description'];
                $tags = $row['tags'];
            } else{
                header("location: error.php");
                exit();
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
} else if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process POST request for updating snippet
    $snippet_id = $_POST["id"];

    if(empty(trim($_POST["title"]))){
        $title_err = "Please enter a title for the snippet.";
    } else{
        $title = trim($_POST["title"]);
    }
    
    if(empty(trim($_POST["code"]))){
        $code_err = "Please enter the code snippet.";
    } else{
        $code = trim($_POST["code"]);
    }
    
    $description = trim($_POST["description"]);
    $tags = trim($_POST["tags"]);

    if(empty($title_err) && empty($code_err)){
        // Update snippet details
        $sql = "UPDATE snippets SET title = ?, code = ?, description = ? WHERE id = ? AND user_id = ?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sssii", $param_title, $param_code, $param_description, $param_id, $param_user_id);
            
            $param_title = $title;
            $param_code = $code;
            $param_description = $description;
            $param_id = $snippet_id;
            $param_user_id = $_SESSION["id"];
            
            if(mysqli_stmt_execute($stmt)){
                // Update tags
                // First, remove existing tags for this snippet
                $sql_delete_tags = "DELETE FROM snippet_tags WHERE snippet_id = ?";
                if($stmt_delete_tags = mysqli_prepare($link, $sql_delete_tags)){
                    mysqli_stmt_bind_param($stmt_delete_tags, "i", $snippet_id);
                    mysqli_stmt_execute($stmt_delete_tags);
                    mysqli_stmt_close($stmt_delete_tags);
                }

                // Then, add new tags
                if(!empty($tags)){
                    $tag_array = explode(',', $tags);
                    foreach($tag_array as $tag_name){
                        $tag_name = trim($tag_name);
                        if(!empty($tag_name)){
                            // Check if tag exists, if not, insert it
                            $sql_tag = "SELECT id FROM tags WHERE name = ?";
                            if($stmt_tag = mysqli_prepare($link, $sql_tag)){
                                mysqli_stmt_bind_param($stmt_tag, "s", $param_tag_name);
                                $param_tag_name = $tag_name;
                                mysqli_stmt_execute($stmt_tag);
                                mysqli_stmt_store_result($stmt_tag);
                                
                                if(mysqli_stmt_num_rows($stmt_tag) == 0){
                                    // Tag does not exist, insert new tag
                                    $sql_insert_tag = "INSERT INTO tags (name) VALUES (?)";
                                    if($stmt_insert_tag = mysqli_prepare($link, $sql_insert_tag)){
                                        mysqli_stmt_bind_param($stmt_insert_tag, "s", $param_tag_name);
                                        mysqli_stmt_execute($stmt_insert_tag);
                                        $tag_id = mysqli_insert_id($link);
                                        mysqli_stmt_close($stmt_insert_tag);
                                    }
                                } else {
                                    // Tag exists, get its ID
                                    mysqli_stmt_bind_result($stmt_tag, $tag_id);
                                    mysqli_stmt_fetch($stmt_tag);
                                }
                                mysqli_stmt_close($stmt_tag);

                                // Link snippet to tag
                                $sql_snippet_tag = "INSERT INTO snippet_tags (snippet_id, tag_id) VALUES (?, ?)";
                                if($stmt_snippet_tag = mysqli_prepare($link, $sql_snippet_tag)){
                                    mysqli_stmt_bind_param($stmt_snippet_tag, "ii", $snippet_id, $tag_id);
                                    mysqli_stmt_execute($stmt_snippet_tag);
                                    mysqli_stmt_close($stmt_snippet_tag);
                                }
                            }
                        }
                    }
                }

                header("location: view_snippet.php?id=" . $snippet_id);
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
} else {
    header("location: error.php");
    exit();
}
mysqli_close($link);
?>

<?php include 'includes/header.php'; ?>

<h2>Edit Snippet</h2>
<p>Please edit the details of your code snippet.</p>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $snippet_id; ?>">
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($title); ?>">
        <span class="invalid-feedback"><?php echo $title_err; ?></span>
    </div>    
    <div class="form-group">
        <label>Code</label>
        <textarea name="code" class="form-control <?php echo (!empty($code_err)) ? 'is-invalid' : ''; ?>" rows="10"><?php echo htmlspecialchars($code); ?></textarea>
        <span class="invalid-feedback"><?php echo $code_err; ?></span>
    </div>
    <div class="form-group">
        <label>Description (Optional)</label>
        <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($description); ?></textarea>
    </div>
    <div class="form-group">
        <label>Tags (comma-separated, e.g., php, mysql, javascript)</label>
        <input type="text" name="tags" class="form-control" value="<?php echo htmlspecialchars($tags); ?>">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Save Changes">
        <a href="view_snippet.php?id=<?php echo $snippet_id; ?>" class="btn btn-secondary ml-2">Cancel</a>
    </div>
</form>

<?php include 'includes/footer.php'; ?>