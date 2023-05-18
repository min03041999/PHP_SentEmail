<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart | Email</title>

    <style>
    body {
        background-color: #F3F3F9;
        color: #000;
    }

    .container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 1000px;
    }

    .card {
        background-color: #fff;
        border: 0px;
        border-radius: 0.625rem;
        box-shadow: 6px 11px 41px -28px #a99de7;
        padding: 1.88rem 1.81rem;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <canvas id="myChart"></canvas>
        </div>
        <img id="test" />
    </div>

    <script src="assets/jquery.js"></script>
    <script src="assets/chart.js"></script>

    <script>
    $(function() {
        const canvas = document.getElementById('myChart');

        var myLine = new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                        label: '# of Votes',
                        data: [12, 19, 3, 5, 2, 3],
                        borderWidth: 1
                    },
                    {
                        label: '# of Votes',
                        data: [1, 6, 3, 7, 10, 1],
                        borderWidth: 1
                    }
                ],

            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Chart.js Line Chart',
                        position: 'bottom',
                    },
                    customCanvasBackgroundColor: {
                        color: 'lightGreen',
                    }
                },
                bezierCurve: false,
                animation: {
                    onComplete: sentEmail
                },
            }
        });

        function sentEmail() {
            var url = myLine.toBase64Image();
            // console.log(url);
            const urlParams = new URLSearchParams(window.location.search);
            const email = urlParams.get('email');

            $.ajax({
                type: "POST",
                url: "sent_email.php",
                data: {
                    email: email,
                    chart: url
                },
                success: function(response) {
                    console.log(response);
                    // $("#test").attr("src", response);
                }
            });
        }
    })
    </script>
</body>

</html>