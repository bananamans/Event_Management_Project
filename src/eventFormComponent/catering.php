<?php
$hasCateringService = in_array('catering', array_column($services, 'service_name'));

if ($hasCateringService) {
    echo '<p class="service-title">- Catering service</p>';

    foreach ($services as $service) {
        if ($service['service_name'] == 'catering') {
            $serviceType = $service['service_type'];
            $servicePrice = $service['service_price'];

            echo '<div class="service-item">';
            echo '<input type="checkbox" id="' . $serviceType . '" name="catering[]" value="' . $serviceType . '" />';
            echo '<label for="' . $serviceType . '">' . ucwords($serviceType) . '</label>';
            echo '<span>' . ' (RM' . $servicePrice . ')' . '</span><br />';
            echo '</div>';
        }
    }
}

?>