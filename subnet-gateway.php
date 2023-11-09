<?php
// Retrieve the user's WAN IP from the form
$wan_ip = $_POST['wan_ip'];

// Define the zone/region information
$zoneData = array(
    'SWAAZ/SARBET' => array(
        'VBUI100' => array('10.129.0.1', '10.129.47.255', '255.255.192.0', '10.129.48.1'),
        'VBUI101' => array('10.83.0.2', '10.83.127.255', '255.255.0.0', '10.83.0.1'),
        'VBUI300' => array('10.129.96.1', '10.129.127.254', '255.255.224.0', '10.129.96.1'),
        'VBUI1700' => array('196.188.128.1', '196.188.159.254', '255.255.224.0', '196.188.128.1')
    ),
    // Add more zone and interface data here...
);

function calculateSubnetAndGateway($ipAddress, $zoneData)
{
    foreach ($zoneData as $zone => $interfaces) {
        foreach ($interfaces as $interface => $data) {
            $startIp = ip2long($data[0]);
            $endIp = ip2long($data[1]);
            $subnetMask = $data[2];
            $defaultGateway = $data[3];

            $ip = ip2long($ipAddress);

            if ($ip >= $startIp && $ip <= $endIp) {
                return array(
                    'zone' => $zone,
                    'interface' => $interface,
                    'subnetMask' => $subnetMask,
                    'defaultGateway' => $defaultGateway
                );
            }
        }
    }

    return null;
}

// Check if the WAN IP exists in the zone data
$subnetAndGateway = calculateSubnetAndGateway($wan_ip, $zoneData);

if ($subnetAndGateway) {
    $subnet_mask = $subnetAndGateway['subnetMask'];
    $default_gateway = $subnetAndGateway['defaultGateway'];

    $response = array(
        'subnetMask' => $subnet_mask,
        'gateway' => $default_gateway
    );

    // Set the response content type to JSON
    header('Content-Type: application/json');

    // Return the response as JSON
    echo json_encode($response);
} else {
    echo "No subnet mask and default gateway found for WAN IP " . $wan_ip;
}
?>