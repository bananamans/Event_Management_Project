<?php
$hasAudioVisualService = in_array('audio visual rental', array_column($services, 'service_name'));

if ($hasAudioVisualService) {

    echo '<p class="service-title">- Audio Visual (A/V) Rental</p>';

    foreach ($services as $service) {
        if ($service['service_name'] == 'audio visual rental') {

            $serviceType = $service['service_type'];
            $servicePrice = $service['service_price'];

            echo '<div class="service-item">';
            echo '<input type="checkbox" id="' . $serviceType . '" name="audio-visual[]" value="' . $serviceType . '" />';
            echo '<label for="' . $serviceType . '">' . ucwords($serviceType) . '</label>';
            echo '<span>' . ' (RM' . $servicePrice . ')' . '</span><br />';
            echo '</div>';
        }
    }


}
?>