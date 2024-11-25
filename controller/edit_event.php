
<?php
include '.../../contolleradmin.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id_client = $_POST['id_client'];
    $title = $_POST['title'];
    $event_date = $_POST['event_date'];

    // Call the function to upevent_date the event
    UpdateEvent($id, $id_client, $title, $event_date);

    // Redirect back to the events table
    header("Location:  ../view/BackOffice/tables.php ");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $event = GetEventById($id); // Retrieve the event by ID
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
</head>
<body>
    <h1>Edit Event</h1>
    <form action="edit_event.php" method="POST">
        <input type="hidden" name="id" value="<?php htmlspecialchars($event['id']) ?>">
        

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php htmlspecialchars($event['title']) ?>" required><br><br>

        <label for="event_date">Date:</label>
        <input type="date" id="event_date" name="event_date" value="<?php htmlspecialchars($event['event_date']) ?>" required><br><br>

        <button type="submit">Update Event</button>
    </form>
</body>
</html>
