class TemperatureController {
    constructor() {
        this.currentTemperature = null;
        this.controlTemperatureShow = false;
        this.topic = '/p/temp';
        this.mqttClient = new MQTTClient('broker.hivemq.com', 8000, this.handleMessage.bind(this));
        this.firstInput = false;
    }

    handleMessage(message) {
        this.messageParsed = JSON.parse(message);
        console.log(this.messageParsed.temp);
        console.log(this.controlTemperatureShow);
        if (!this.controlTemperatureShow) {
            this.controlTemperatureShow = true;
        }
            
        $('#kontrol-suhu').show();
        if(this.messageParsed.change_temp) {
            if(this.firstInput) this.firstInput = false;
            else $('#current-temp').html(parseInt(this.messageParsed.temp, 10));
            $('#change_temp').show();
        } else {
            $('#current-temp').html(parseInt(this.messageParsed.temp, 10));
            $('#temperature_input').val(parseInt(this.messageParsed.temp, 10));
            $('#change_temp').hide();
        }
    }

    onConnect() {
        $('#change_temp').hide();
        $('#kontrol-suhu').hide();
        console.log('Connected to broker 1');
        this.mqttClient.subscribe(this.topic);
    }

    changeTemperature(newTemperatureVal) {
        $('#temperature_input').val(newTemperatureVal);
        var message = JSON.stringify({"temp": newTemperatureVal, "change_temp": true});
        this.firstInput = true;
        this.mqttClient.publish(this.topic, message);
    }

    init() {
        $(document).ready(() => {
            $('#turun-suhu').on('click', () => this.changeTemperature($('#temperature_input').val() - 1));
            $('#naik-suhu').on('click', () => this.changeTemperature(+$('#temperature_input').val() + 1));
            $('#temperature_input').on('change', () => this.changeTemperature(+$('#temperature_input').val()));

            this.mqttClient.connect(this.onConnect.bind(this));
        });
    }
}

// Instantiate the TemperatureController and initialize it
const tempController = new TemperatureController();
tempController.init();