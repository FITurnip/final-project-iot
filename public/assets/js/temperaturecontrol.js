class TemperatureController {
    constructor() {
        this.currentTemperature = null;
        this.controlTemperatureShow = false;
        this.temperatureChanged = false;
        this.topic = '/p/temp';
        this.mqttClient = new MQTTClient('broker.hivemq.com', 8000, this.handleMessage.bind(this));
    }

    handleMessage(message) {
        this.currentTemperature = JSON.parse(message);
        console.log(this.currentTemperature.temp);
        console.log(this.controlTemperatureShow);
        if (!this.controlTemperatureShow) {
            $('#kontrol-suhu').show();
            this.controlTemperatureShow = true;
        }

        if (!this.temperatureChanged) {
            $('#temperature_input').val(parseInt(this.currentTemperature.temp, 10));
            $('#current-temp').html(parseInt(this.currentTemperature.temp, 10));
        } else {
            this.temperatureChanged = false;
        }
    }

    onConnect() {
        $('#kontrol-suhu').hide();
        console.log('Connected to broker 1');
        this.mqttClient.subscribe(this.topic);
    }

    changeTemperature(newTemperatureVal) {
        $('#temperature_input').val(newTemperatureVal);
        var message = JSON.stringify({"temp": newTemperatureVal});
        this.mqttClient.publish(this.topic, message);
        this.temperatureChanged = true;
    }

    init() {
        $(document).ready(() => {
            $('#turun-suhu').on('click', () => this.changeTemperature($('#temperature_input').val() - 1));
            $('#naik-suhu').on('click', () => this.changeTemperature(+$('#temperature_input').val() + 1));
            $('#temperature_input').on('change', () => console.log("berhasil"));

            this.mqttClient.connect(this.onConnect.bind(this));
        });
    }
}

// Instantiate the TemperatureController and initialize it
const tempController = new TemperatureController();
tempController.init();