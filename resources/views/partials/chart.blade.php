<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById("myChart").getContext("2d");
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, "rgba(54, 162, 235, 0.5)");
        gradient.addColorStop(0.8, "rgba(54, 162, 235, 0)");

        const salesData = @json(array_values($salesInMonth));

        // Mendapatkan tanggal saat ini
        const currentDate = new Date();
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth() + 1;

        // Mendapatkan jumlah hari dalam bulan saat ini
        const daysInMonth = new Date(year, month, 0).getDate();

        // Membuat array labels sesuai dengan jumlah hari dalam bulan saat ini
        const labels = Array.from({
            length: daysInMonth
        }, (_, i) => (i + 1).toString());
       
        const myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "Data",
                    data: salesData,
                    backgroundColor: gradient,
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1,
                    fill: true,
                    pointBackgroundColor: "rgba(54, 162, 235, 1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(54, 162, 235, 1)",
                }],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                        max: 100,
                        ticks: {
                            stepSize: 20,
                            callback: function(value) {
                                return value;
                            },
                        },
                        grid: {
                            drawBorder: false,
                        },
                    },
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || "";
                                if (label) {
                                    label += ": ";
                                }
                                label += parseFloat(context.raw).toFixed(0);
                                return label;
                            },
                        },
                    },
                },
                responsive: true,
                maintainAspectRatio: false,
            },
        });
    });
</script>
