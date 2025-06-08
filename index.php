<?php
// database connection
$conn = mysqli_connect("localhost", "root", "", "todo_db");


if (!empty($_POST['task']) &&  isset($_POST['task'])) {

    // receive form input
    $task = $_POST['task'];
    //  prepare
    $query = $conn->prepare("INSERT INTO todo(task) VALUES(?)");

    // bind parameters
    $query->bind_param("s", $task);
    // execute
    $query->execute();
    // check if query iko successfully
    if ($query->affected_rows > 0) {
        echo "<script>alert('Task added Successfully To Database')</script>";
    } else {
        echo "<script>alert('Failed to add Task')</script>";
    }
    // clean
    // $query->close();
    // $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="parent">
        <div class="title">
            <p><b>To-Do List</b></p>
            <button id="excelBtn">Export to Excel</button>
        </div>
        <form action="" method="post">
            <input type="text" name="task" placeholder="Add a new task..." autofocus id="">
            <button type="submit">Add</button>
        </form>
        <?php
        // prepare
        $stmt = $conn->prepare("SELECT id,task FROM todo ORDER BY id DESC");

        // execute
        $stmt->execute();

        // bind results
        $stmt->bind_result($id,$task);

        // fetch result
        while ($stmt->fetch()) {
        ?>
            <div class="content">
                <p><?php echo $task; ?></p>
                <button><a href="?delete_id=<?php echo $id?>" style="text-decoration: none; color:white;">Delete</a></button>
            </div>

        <?php
        }

        // $stmt->close();
        // $conn->close();
        ?>


    </div>

</body>

</html>