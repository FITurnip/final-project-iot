class TemperatureController {
    constructor() {
        this.currentTemperature = null;
        this.controlTemperatureShow = false;
        this.topic = '/p/temp';
        this.mqttClient = new MQTTClient('broker.hivemq.com', 8000, this.handleMessage.bind(this));
        this.firstInput = false;
    }

    handleMessage(message) {
        // if(message != "activate_fan" ||)
        // console.log(this.controlTemperatureShow);
        if (!this.controlTemperatureShow) {
            this.controlTemperatureShow = true;
        }

        let changeTemp = false;

        $('#kontrol-suhu').show();
        if(message == "activate_fan" || message == "activate_heater") {
            $('#change_temp').show();
        } else {
            $('#current-temp').html(message);
            $('#temperature_input').val(message);
            $('#change_temp').hide();
            changeTemp = true;
        }

        $.ajax({
            url: 'api/temperature', // URL to send the request to
            type: 'POST', // Request type
            data: {
                temp: $('#current-temp').html(),
                change_temp: changeTemp
            }, // Data to be sent to the server
            success: function(response) {
                // Code to handle a successful response
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Code to handle an error response
                console.error('Error:', status, error);
            }
        });
        
    }

    onConnect() {
        $('#change_temp').hide();
        $('#kontrol-suhu').hide();
        console.log('Connected to broker 1');
        this.mqttClient.subscribe(this.topic);
    }

    changeTemperature(message, newTemperatureVal) {
        $('#temperature_input').val(newTemperatureVal);

        // var message = newTemperatureVal + "," + "true";
        this.firstInput = true;
        this.mqttClient.publish(this.topic, message);
    }

    init() {
        $(document).ready(() => {
            var temperature = parseInt($('#temperature_input').val());
            $('#turun-suhu').on('click', () => this.changeTemperature( "activate_fan", temperature - 1));
            $('#naik-suhu').on('click', () => this.changeTemperature("activate_heater", +temperature + 1));
            // $('#temperature_input').on('change', () => this.changeTemperature(this.currentTemperature, +$('#temperature_input').val()));
            
            if(temperature > 30) alert("turunkan suhu! Jangan lupa berikan makanan!");
            else if(temperature < 26) alert("naikan suhu! Jangan lupa berikan makanan!");
            this.mqttClient.connect(this.onConnect.bind(this));


        });
    }
}

// Instantiate the TemperatureController and initialize it
const tempController = new TemperatureController();
tempController.init();