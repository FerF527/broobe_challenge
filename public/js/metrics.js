$(function() {
    $('#metrics-form').on('submit', function(e) {
        e.preventDefault(); // Evita el envío tradicional del formulario

        const formData = $(this).serialize();

                // Verifica los datos antes de enviarlos
                console.log(formData);

        $.ajax({
            url: "/metrics/run",
            method: 'POST',
            data: formData,
            timeout: 60000,
            beforeSend: function() {
                Swal.fire({
                    title: 'Fetching metrics...',
                    text: 'Please wait while we retrieve the metrics.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                Swal.close(); // Cierra la alerta de carga

                if (response.html) {
                    $('#metrics-results').html(response.html).show();
                    $('#save-metric').show();

                    Swal.fire({
                        icon: 'success',
                        title: 'Metrics retrieved!',
                        text: 'The metrics have been successfully fetched.',
                    });
                }
            },
            error: function(err) {
                Swal.close(); // Cierra la alerta de carga

                Swal.fire({
                    icon: 'error',
                    title: 'Error fetching metrics',
                    text: 'There was an error fetching the metrics. Please try again later.',
                });
            }
        });
    });
});