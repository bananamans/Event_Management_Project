<?php

$hasDecorationService = in_array('decoration', array_column($services, 'service_name'));

if ($hasDecorationService) {
    echo ' <p class="service-title">- Decorations</p>';
    foreach ($services as $service) {
        if ($service['service_name'] == 'decoration') {

            $serviceType = $service['service_type'];
            $servicePrice = $service['service_price'];

            // Generate checkboxes
            echo '<div class="service-item">';
            echo '<input type="checkbox" id="' . $serviceType . '" name="decorations[]" value="' . $serviceType . '" />';
            echo '<label for="' . $serviceType . '">' . ucwords($serviceType) . '</label>';
            echo '<span>' . ' (RM' . $servicePrice . ')' . '</span><br />';
            echo '</div>';


        }
    }
}

?>