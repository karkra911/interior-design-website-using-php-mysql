<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "includes/db.php";

if(isset($_GET["id"]) && !empty(trim($_GET["id"])) ){
    $id = trim($_GET["id"]);
    $user_id = $_SESSION["id"];

    // Delete associated tags first
    $sql_delete_tags = "DELETE FROM snippet_tags WHERE snippet_id = ?";
    if($stmt_delete_tags = mysqli_prepare($link, $sql_delete_tags)){
        mysqli_stmt_bind_param($stmt_delete_tags, "i", $id);
        mysqli_stmt_execute($stmt_delete_tags);
        mysqli_stmt_close($stmt_delete_tags);
    }

    // Delete the snippet
    $sql = "DELETE FROM snippets WHERE id = ? AND user_id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "ii", $param_id, $param_user_id);
        
        $param_id = $id;
        $param_user_id = $user_id;
        
        if(mysqli_stmt_execute($stmt)){
            header("location: dashboard.php");
            exit();
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