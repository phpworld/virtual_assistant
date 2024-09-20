<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
</head>
<body>
    <h1>Simple Chatbot</h1>
    <form action="<?= site_url('chatbot/getResponse') ?>" method="post">
        <label for="question">Ask me anything:</label>
        <input type="text" id="question" name="question" required>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
