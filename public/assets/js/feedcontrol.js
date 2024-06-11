class FeedControl {
    constructor(maxCapacity) {
        this.message = null;
        this.topic = '/p/feed';
        this.isFeeding = false;
        this.currentDistance = null;
        this.isReady = false;
        this.maxCapacity = maxCapacity;
        this.mqttClient = new MQTTClient('broker.hivemq.com', 8000, this.handleMessage.bind(this));
        this.mqttClient.connect(this.onConnect.bind(this), this.onConnectFailure.bind(this));
    }

    handleMessage(message) {
        this.message = JSON.parse(message); // Fixed: Changed to message
        console.log(this.message);

        var persentage = (this.maxCapacity - this.message.distance) * 100 / this.maxCapacity;

        if(!this.ready) {
            this.ready = true;
            $('#feed-btn').prop("disabled", false);
        }

        if(this.message.bottle_cap == "close") {
            console.log('Feed have been given');
            this.isFeeding = false;
            $('#feed-btn').html("Berikan Pakan");
            $('#feed-btn').prop("disabled",false);
        } else if(this.message.bottle_cap == "open") {
            console.log('Feeding');
            this.isFeeding = false;
            $('#feed-btn').prop("disabled",true);
            $('#feed-btn').html("Diproses...");
        }
        
        $('#persentase_pekan').html(persentage);
    }

    onConnect() {
        $('#feed-btn').prop("disabled", true);
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
        this.isFeeding = true;

        var message = JSON.stringify({"distance": this.currentDistance, "bottle_cap": "open"});

        this.mqttClient.publish(this.topic, message);
    }

    init() {
        $(document).ready(() => {
            $('#feed-btn').on('click', () => this.feed());
        });
    }
}

const feedController = new FeedControl(100);
