<?php 
$connect = mysqli_connect('localhost','root','password','todo');

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert new task
if(isset($_POST['submit'])){
    $task = $_POST['task'];
    $sql = "INSERT INTO todo (title) VALUES (?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $task);
    $stmt->execute();
    $stmt->close();
}

// Delete task
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $sql = "DELETE FROM todo WHERE id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <style>
        h1 {
            text-align: center;
            align-items: center;
        }
        .container {
            align-items: center;
        }
        input {
            border: 2px solid black;
            border-radius: 6px;
            padding: 6px;
        }
        form {
            align-items: center;
            display: flex;
            justify-content: center;
            gap: 4px;
        }
        .table {
            gap: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px 4px;
            text-align: center;
        }
        td {
            border-right: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>To Do List</h1>
        <form action="index.php" method="post">
            <input class="input" type="text" name="task" placeholder="Enter your task">
            <input type="submit" name="submit" value="Add Task">
        </form>
        <div class="table">
            <table style="width:600px; height:auto; border:1px solid black; border-radius:6px;">
                <tr>
                    <th>Task</th>
                    <th>Remove</th>
                </tr>
                <?php 
                $sql = "SELECT * FROM todo ORDER BY id DESC";
                $res = mysqli_query($connect, $sql);
                while($row = mysqli_fetch_assoc($res)){
                ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><a href="index.php?delete=<?php echo $row['id']; ?>">Delete</a></td>
                    </tr>
                <?php 
                }
                mysqli_close($connect);
                ?>
            </table>
        </div>
    </div>
</body>
</html>
