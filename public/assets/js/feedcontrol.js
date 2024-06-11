class FeedControl {
    constructor() {
        this.message = null;
        this.topic = '/p/dist';
        this.isFeeding = false;
        this.mqttClient = new MQTTClient('broker.hivemq.com', 8000, this.handleMessage.bind(this));
        this.mqttClient.connect(this.onConnect.bind(this), this.onConnectFailure.bind(this));
    }

    handleMessage(message) {
        this.message = JSON.parse(message); // Fixed: Changed to message
        console.log(this.message);

        if(this.isFeeding) {
            console.log('Feed have been given');
            this.isFeeding = false;
            $('#feed-btn').html("Berikan Pakan");
            $('#feed-btn').prop("disabled",false);
        }
    }

    onConnect() {
        console.log('Connected to broker 2');
        this.mqttClient.subscribe(this.topic);
        this.init(); // Initialize after successful connection
    }

    onConnectFailure() {
        console.log('Failed to connect to broker, retrying...');
        this.mqttClient.disconnect(); // Disconnect the client if connection fails
        this.mqttClient.connect(this.onConnect.bind(this), this.onConnectFailure.bind(this)); // Retry connection
    }

    feed() {
        console.log('Feed is given');
        $('#feed-btn').prop("disabled",true);
        $('#feed-btn').html("Diproses...");
        this.isFeeding = true;
    }

    init() {
        $(document).ready(() => {
            $('#feed-btn').on('click', () => this.feed());
        });
    }
}

const feedController = new FeedControl();
