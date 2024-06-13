class FeedControl {
    constructor(maxCapacity) {
        this.message = null;
        this.topic = '/p/food';
        this.isFeeding = false;
        this.currentDistance = null;
        this.isReady = false;
        this.maxCapacity = maxCapacity;
        this.mqttClient = new MQTTClient('broker.hivemq.com', 8000, this.handleMessage.bind(this));
        this.mqttClient.connect(this.onConnect.bind(this), this.onConnectFailure.bind(this));
    }

    handleMessage(message) {
        // this.message = JSON.parse(message);
        // let str = message.split(", ");
        // console.log(this.str);

        if(!this.ready) {
            this.ready = true;
            $('#feed-btn').prop("disabled", false);
        }

        if(message != "activate_food") {
            console.log('Feed have been given');
            var persentage = (this.maxCapacity - parseFloat(message)) * 100 / this.maxCapacity;
            this.isFeeding = false;
            $('#feed-btn').html("Berikan Pakan");
            $('#feed-btn').prop("disabled",false);

        } else {
            console.log('Feeding');
            this.isFeeding = false;
            $('#feed-btn').prop("disabled",true);
            $('#feed-btn').html("Diproses...");
        }
        
        $('#persentase_pekan').html(persentage);
        $('.mount').css('height', 100 - persentage + "%");

        if(persentage == 20) {
            alert("Pakan sudah habis, berikan pakan");
        }
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
        var message = "activate_food";
        this.mqttClient.publish(this.topic, message);
    }

    init() {
        $(document).ready(() => {
            $('#feed-btn').on('click', () => this.feed());

            // setInterval(feed, 5000);
        });
    }
}

const feedController = new FeedControl(100);
