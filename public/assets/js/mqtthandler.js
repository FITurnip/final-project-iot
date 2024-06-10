class MQTTClient {
    constructor(brokerAddress, port) {
        this.client = new Paho.MQTT.Client(brokerAddress, port, 'clientId_' + Math.random().toString(16).substr(2, 8));
        this.client.onConnectionLost = this.onConnectionLost.bind(this);
        this.client.onMessageArrived = this.onMessageArrived.bind(this);
    }

    connect(onSuccess) {
        this.client.connect({ onSuccess: onSuccess });
    }

    subscribe(topic) {
        this.client.subscribe(topic);
    }

    publish(topic, message) {
        var messageObject = new Paho.MQTT.Message(message);
        messageObject.destinationName = topic;
        this.client.send(messageObject);
    }

    onConnectionLost(responseObject) {
        if (responseObject.errorCode !== 0) {
            console.log('Connection lost:', responseObject.errorMessage);
        }
    }

    onMessageArrived(message) {
        console.log('Received message:', message.payloadString);
        this.payload = message.payloadString;
    }
}
