<?php


declare(strict_types=1);

function show_error_while_logging_out(): void {

    if(!isset($_SESSION['error_logout'])) {
        return;
    }

    echo '
    <div class="error-message" style="padding-top: 20px;">
            <h3 style="text-align: start">Something is wrong</h3>
            <p style="padding-top: 5px;">Something is now working. Cannot logout now, PLease try again later</p>
    </div>
    
    ';
}
