var currentTemperature;
kontrolSuhuShow = false;
suhuDiubah = false;


// Define the action to trigger when a message is received
function handleMessage(message) {
    currentTemperature = JSON.parse(message);
    console.log(currentTemperature.temp);
    console.log(kontrolSuhuShow);
    if(kontrolSuhuShow == false) {
        $('#kontrol-suhu').show();
        kontrolSuhuShow = true;
    }

    if(suhuDiubah == false) {
        $('#temperature_input').val(parseInt(currentTemperature.temp, 10));
        $('#current-temp').html(parseInt(currentTemperature.temp, 10));
    } else {
        suhuDiubah = false;
    }
}

// Create an instance of MQTTClient and connect to the broker
var mqttClient = new MQTTClient('broker.hivemq.com', 8000, handleMessage);

// Define the onSuccess callback function
function onConnect() {
    $('#kontrol-suhu').hide();
    console.log('Connected to broker');
    mqttClient.subscribe('/p/temp');
}

function changeTemperature(new_temperature_val) {
    $('#temperature_input').val(new_temperature_val);
    var message = JSON.stringify({"temp": new_temperature_val});
    mqttClient.publish('/p/temp', message);
    suhuDiubah = true;
}

$(document).ready(function() {
    $('#turun-suhu').on('click', function() {changeTemperature($('#temperature_input').val() - 1)});
    $('#naik-suhu').on('click', function() {changeTemperature(+$('#temperature_input').val() + 1)});
    $('#temperature_input').on('change', function() {console.log("berhasil")});
});

// Connect to the broker and set up subscription and publishing
mqttClient.connect(onConnect);
