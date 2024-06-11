function createChart(title, labels, data, canvasId) {
    let ctx = document.getElementById(canvasId).getContext('2d');
    let chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: title,
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', (event) => {
    createChart('Water Temperature (°C)', ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        [4, 5, 8, 12, 16, 20, 22], 'waterTempChart');
    createChart('Food Amount (kg)', ['January', 'February', 'March', 'April', 'May', 'June', 'July'], [10,
        12, 15, 18, 20, 22, 25
    ], 'foodAmountChart');
});