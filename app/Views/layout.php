<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }
        .chat-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .chat-box {
            height: 500px;
            overflow-y: auto;
            border-radius: 10px;
            border: 1px solid #e3e6ea;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            display: flex;
            margin-bottom: 15px;
        }
        .message.bot, .message.user {
            align-items: flex-end;
        }
        .message.bot {
            flex-direction: row;
        }
        .message.user {
            flex-direction: row-reverse;
        }
        .message-content {
            max-width: 75%;
            padding: 10px 15px;
            border-radius: 15px;
            font-size: 16px;
            position: relative;
            white-space: pre-wrap; /* Preserve white spaces and line breaks */
        }
        .message.bot .message-content {
            background-color: #e9ecef;
            color: #333;
            border: 1px solid #dee2e6;
        }
        .message.user .message-content {
            background-color: #007bff;
            color: #ffffff;
            border: 1px solid #007bff;
        }
        .message.bot::before {
            content: 'Assistant:';
            font-weight: bold;
            color: #007bff;
            position: absolute;
            top: -20px;
            left: 0;
            font-size: 14px;
        }
        .message.user::before {
            content: 'You:';
            font-weight: bold;
            color: #007bff;
            position: absolute;
            top: -20px;
            right: 0;
            font-size: 14px;
        }
        .input-group {
            margin-top: 15px;
        }
        .input-group input {
            border-radius: 20px 0 0 20px;
            border: 1px solid #ced4da;
            padding-left: 20px;
        }
        .input-group button {
            border-radius: 0 20px 20px 0;
            border: 1px solid #ced4da;
            background-color: #007bff;
            color: #ffffff;
        }
        .input-group button:hover {
            background-color: #0056b3;
        }
        .message.user .message-content::after {
            content: '';
            position: absolute;
            right: -10px;
            top: 10px;
            border-width: 10px;
            border-style: solid;
            border-color: transparent transparent transparent #007bff;
        }
        .message.bot .message-content::after {
            content: '';
            position: absolute;
            left: -10px;
            top: 10px;
            border-width: 10px;
            border-style: solid;
            border-color: transparent #e9ecef transparent transparent;
        }
    </style>
</head>
<body>
    <div class="container chat-container mt-5">
        <h2 class="text-center mb-4">Chatbot</h2>
        <div class="chat-box" id="chat-box"></div>
        <div class="input-group mt-3">
            <input type="text" class="form-control" id="user-input" placeholder="Type your question here...">
            <button class="btn btn-primary" id="send-btn">Send</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <script>
    $(document).ready(function() {
        // Function to send a message
        function sendMessage() {
            var userInput = $('#user-input').val();
            if (userInput.trim() === '') return;

            // Append user message
            $('#chat-box').append('<div class="message user"><div class="message-content">' + userInput + '</div></div>');
            $('#user-input').val('');
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight); // Scroll to the bottom

            // Fetch and append bot response with typing effect
            $.post('/chatbot/getResponse', { question: userInput }, function(response) {
                var answer = response.answer || 'Sorry, I can’t understand.';
                var botMessageHtml = '<div class="message bot"><div class="message-content"></div></div>';
                $('#chat-box').append(botMessageHtml);
                var botMessageElement = $('#chat-box .message.bot:last-child .message-content');
                displayTypingEffect(answer, botMessageElement);
            }, 'json');
        }

        // Function to display typing effect
        function displayTypingEffect(text, element) {
            var i = 0;
            var speed = 50; // Typing speed

            function type() {
                if (i < text.length) {
                    element.append(text.charAt(i));
                    i++;
                    setTimeout(type, speed);
                } else {
                    // Scroll to the bottom once typing is complete
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                }
            }

            type();
        }

        // Function to send initial greeting message
        function sendInitialGreeting() {
            var greeting = "Namskaar ..! How can I help you ..!";
            var botMessageHtml = '<div class="message bot"><div class="message-content"></div></div>';
            $('#chat-box').append(botMessageHtml);
            var botMessageElement = $('#chat-box .message.bot:last-child .message-content');
            displayTypingEffect(greeting, botMessageElement);
        }

        // Event listeners
        $('#send-btn').click(function() {
            sendMessage();
        });

        $('#user-input').keypress(function(e) {
            if (e.which === 13) {
                sendMessage();
            }
        });

        // Call function to send initial greeting
        sendInitialGreeting();
    });
</script>

</body>
</html>
