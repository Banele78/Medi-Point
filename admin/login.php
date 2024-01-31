<?php include('serverlogin.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="Time.php" method="get">
    <label for="institution">Choose an institution:</label>
    <select name="institution" id="institution">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            ?>
            <option value="<?php echo $id; ?>"><?php echo $row['instituition']; ?></option>
            <?php
        }
        ?>
    </select>
    <label for="otherField">Other Field:</label>
    <input type="text" name="otherField" id="otherField">

    <button type="submit">Next</button>
</form>

</body>
</html>
