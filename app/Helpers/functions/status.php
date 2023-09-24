<?php



if (!function_exists('quote_status')) {
    function quote_status($status, $labelOnly = false) {
        $array = quote_status_list();
        if(isset($array[(int)$status])){
            $style = $array[(int)$status];

            if ($labelOnly) {
                return $style['label'];
            }

            return '<label class="label label-md ' . $style['color'] . '" data-toggle="tooltip" data-placement="top" title="' . $style['title'] . '">' . $style['label'] . '</label>';
        }
    }
}

function quote_status_list() {
    $array = [
        0 => [
            'color' => 'quote-gray-status',
            'label' => 'Draft',
            'title' => 'Draft'
        ],
        1 => [
            'color' => 'quote-yellow-status',
            'label' => 'Requested',
            'title' => 'Requested'
        ],
        2 => [
            'color' => 'quote-orange-status',
            'label' => 'Initiated',
            'title' => 'Initiated'
        ],
        3 => [
            'color' => 'label-primary',
            'label' => 'Created',
            'title' => 'Created'
        ],
        4 => [
            'color' => 'quote-light-orange-status',
            'label' => 'Sent',
            'title' => 'Sent'
        ],
        5 => [
            'color' => 'label-success',
            'label' => 'Approved',
            'title' => 'Approved'
        ],
        8 => [
            'color' => 'label-docusign',
            'label' => 'Docusign Sent',
            'title' => 'Docusign Sent'
        ],
        9 => [
            'color' => 'quote-light-orange-status',
            'label' => 'Agreement signed',
            'title' => 'Agreement signed'
        ],
        6 => [
            'color' => 'quote-brown-status',
            'label' => 'Order Placed',
            'title' => 'Order Placed'
        ],
        7 => [
            'color' => 'quote-gray-status',
            'label' => 'Test Quote',
            'title' => 'Test Quote'
        ]
    ];
    unset($array[4]);
    unset($array[7]);
    return $array;
}
