<!DOCTYPE html>
<html>
<head>
    <title>АПИ</title>
    <link rel="stylesheet" href="style.css">
    <script src="handler.js"></script>
</head>
<body>
<form action="handler.php" class="air" method="POST" id="form_address" name="form_address">
    <div class="form-inner" id="test">
        <div class="stripes-block"></div>
        <div class="form-row">
            <label for="address">Адрес</label>
            <input type="text" rows="3" id="address" required name="address">
            <button type="submit" class="form-row">Узнать</button>
        </div>
    </div>
</form>
</body>
</html>

