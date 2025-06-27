<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "includes/db.php";

$title = $code = $description = $tags = "";
$title_err = $code_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

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
        $sql = "INSERT INTO snippets (user_id, title, code, description) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "isss", $param_user_id, $param_title, $param_code, $param_description);
            
            $param_user_id = $_SESSION["id"];
            $param_title = $title;
            $param_code = $code;
            $param_description = $description;
            
            if(mysqli_stmt_execute($stmt)){
                $snippet_id = mysqli_insert_id($link);

                // Handle tags
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

                header("location: dashboard.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($link);
}
?>

<?php include 'includes/header.php'; ?>

<h2>Create New Snippet</h2>
<p>Please fill this form to add a new code snippet.</p>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
        <span class="invalid-feedback"><?php echo $title_err; ?></span>
    </div>    
    <div class="form-group">
        <label>Code</label>
        <textarea name="code" class="form-control <?php echo (!empty($code_err)) ? 'is-invalid' : ''; ?>" rows="10"><?php echo $code; ?></textarea>
        <span class="invalid-feedback"><?php echo $code_err; ?></span>
    </div>
    <div class="form-group">
        <label>Description (Optional)</label>
        <textarea name="description" class="form-control" rows="3"><?php echo $description; ?></textarea>
    </div>
    <div class="form-group">
        <label>Tags (comma-separated, e.g., php, mysql, javascript)</label>
        <input type="text" name="tags" class="form-control" value="<?php echo $tags; ?>">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="Submit">
        <a href="dashboard.php" class="btn btn-secondary ml-2">Cancel</a>
    </div>
</form>

<?php include 'includes/footer.php'; ?>