<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MQTT with jQuery</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>
    
</head>
<body>

<script>
    // Connect to MQTT broker
    var client = new Paho.MQTT.Client('broker.hivemq.com', 8000, 'clientId_' + Math.random().toString(16).substr(2, 8));

    // Set callback handlers
    client.onConnectionLost = onConnectionLost;
    client.onMessageArrived = onMessageArrived;

    // Connect the client
    client.connect({ onSuccess: onConnect });

    // Called when the client connects
    function onConnect() {
        console.log('Connected to MQTT broker');
        
        // Subscribe to a topic
        client.subscribe('test/topic');
    }

    // Called when the client loses its connection
    function onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log('Connection lost:', responseObject.errorMessage);
        }
    }

    // Called when a message arrives
    function onMessageArrived(message) {
        console.log('Received message:', message.payloadString);
    }

    // Publish a message to a topic
    function publishMessage() {
        var message = $('#messageInput').val();
        var topic = $('#topicInput').val();
        var messageObject = new Paho.MQTT.Message(message);
        messageObject.destinationName = topic;
        client.send(messageObject);
    }
</script>

<h2>Publisher</h2>
<label for="topicInput">Topic:</label>
<input type="text" id="topicInput" value="test/topic">
<br>
<label for="messageInput">Message:</label>
<input type="text" id="messageInput" value="Hello MQTT">
<br>
<button onclick="publishMessage()">Publish</button>

</body>
</html>
