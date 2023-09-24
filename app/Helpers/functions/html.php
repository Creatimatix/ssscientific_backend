<?php

if (!function_exists('table_drop_down')) {
    function table_drop_down($controls) {
        $html = '';
        $ddlId = 'ddl_' . time();
        $buttons = button_list();
        if ($controls && !empty($controls)) {
            foreach ($controls as $key => $item) {
                if (is_array($item) && array_key_exists('display', $item) && $item['display'] = false) {
                    continue;
                }
                if (is_array($item)) {
                    $label = array_key_exists('label', $item) ? $item['label'] : ucfirst($key);
                    $href = array_key_exists('href', $item) ? $item['href'] : '#!';
                    $attributes = array_key_exists('attributes', $item) ? $item['attributes'] : [];
                    $attribute = urldecode(str_replace('=', '="', http_build_query($attributes, 'null', '" ')) . '"');
                } else {
                    $label = ucfirst($item);
                    $href = '#!';
                    $attributes = [];
                    $attribute = urldecode(str_replace('=', '="', http_build_query($attributes, 'null', '" ')) . '"');
                }
                $html .= '<a class="dropdown-item waves-light waves-effect" href="' . $href . '" ' . $attribute . '>' . $label . '</a>';
            }
        }

        if ($html !== '') {
            if ($html !== '') {
                $defaultButton = '<button class="btn btn-mini btn btn-info dropdown-toggle waves-effect waves-light" type="button" id="' . $ddlId . '" data-toggle="dropdown" data-tooltip="yes" title="Show more" aria-haspopup="true" aria-expanded="false"></button>';
                return '<div class="dropdown-primary dropdown table_action">' . $defaultButton . '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="' . $ddlId . '" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">' . $html . '</div>';
            }

        }
        return null;
    }
}

if (!function_exists('table_buttons')) {
    function table_buttons($items, $displayLabel = false) {
        $html = '';
        $i = 0;
        $created = [];
        $newArray = $items;
        foreach ($items as $key => $item) {
            if (is_array($item) && array_key_exists('display', $item) && $item['display'] == false) {
                unset($newArray[$key]);
                continue;
            }
            if ($i > 2) {
                break;
            }
            unset($newArray[$key]);
            $created[$key] = $item;
            if (is_array($item)) {
                $label = array_key_exists('label', $item) ? $item['label'] : '';
                $attributes = array_key_exists('attributes', $item) ? $item['attributes'] : [];
            } else {
                $key = $item;
                $label = '';
                $attributes = [];
            }
            $tag = 'a';
            if (array_key_exists('tag', $item)) {
                $tag = $item['tag'];
            }

            $html .= table_button($key, $label, $attributes, $tag, $displayLabel);
            $i++;
        }
        if (count($newArray)) {
            $html .= table_drop_down($newArray);
        }

        if ($html != '') {
            return '<div class="btn-group" role="group"><nobr>' . $html . '</div>';
        }
        return $html;

    }
}

if (!function_exists('button_list')) {
    function button_list() {
        return [
            'messages' => [
                'icon' => 'fa fa-envelope-open',
                'label' => 'Messages',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-primary btn-mini waves-effect waves-light',
                    'title' => 'Messages',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'edit' => [
                'icon' => 'fa fa-edit',
                'label' => 'Edit',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-warning btn-mini waves-effect waves-light',
                    'title' => 'Edit',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'add' => [
                'icon' => 'fa fa-plus',
                'label' => 'Add',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-success btn-mini waves-effect waves-light',
                    'title' => 'Add',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'refresh' => [
                'icon' => 'fa fa-refresh',
                'label' => 'Refresh',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-info btn-mini waves-effect waves-light',
                    'title' => 'Refresh',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'configure' => [
                'icon' => 'fa fa-gear',
                'label' => 'Configure',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-primary btn-mini waves-effect waves-light',
                    'title' => 'Configure',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'external-link' => [
                'icon' => 'fa fa-external-link',
                'label' => 'Open',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-primary btn-mini waves-effect waves-light',
                    'title' => 'Open in new window',
                    'target' => '_blank',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'link' => [
                'icon' => 'fa fa-link-alt',
                'label' => 'Open',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-primary btn-mini waves-effect waves-light',
                    'title' => 'Open link',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'login' => [
                'icon' => 'fa fa-login',
                'label' => 'Login',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-primary btn-mini waves-effect waves-light',
                    'title' => 'Login',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'delete' => [
                'icon' => 'fa fa-ui-delete',
                'label' => 'Delete',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-danger btn-mini waves-effect waves-light',
                    'title' => 'Delete',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'trash' => [
                'icon' => 'fa fa-trash',
                'label' => 'Trash',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-danger btn-mini waves-effect waves-light',
                    'title' => 'Trash',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'filter' => [
                'icon' => 'fa fa-filter',
                'label' => 'Filter',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-primary btn-mini waves-effect waves-light',
                    'title' => 'Filter',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'view' => [
                'icon' => 'fa fa-eye',
                'label' => 'View',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-info btn-mini waves-effect waves-light',
                    'title' => 'View',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'pickup' => [
                'icon' => 'fa fa-truck',
                'label' => 'Schedule Pickup',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-primary btn-mini waves-effect waves-light',
                    'title' => 'Schedule Pickup',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'picked' => [
                'icon' => 'fa fa-truck-loaded',
                'label' => 'Mark as Picked',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-success btn-mini waves-effect waves-light',
                    'title' => 'Mark as Picked',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'mail' => [
                'icon' => 'fa fa-ui-email',
                'label' => 'Send Reminder',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-info btn-mini waves-effect waves-light',
                    'title' => 'Send Reminder',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'back' => [
                'icon' => 'fa fa-arrow-left',
                'label' => 'Back',
                'attributes' => [
                    'href' => 'javascript:history.go(-1)',
                    'class' => 'btn btn-info btn-mini waves-effect waves-light',
                    'title' => 'Back',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'accept' => [
                'icon' => 'fa fa-verification-check',
                'label' => 'Accept',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-success btn-mini waves-effect waves-light',
                    'title' => 'Accept',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'reject' => [
                'icon' => 'fa fa-close',
                'label' => 'Reject',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-danger btn-mini waves-effect waves-light',
                    'title' => 'Reject',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'return' => [
                'icon' => 'fa fa-reply',
                'label' => 'Reject',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-danger btn-mini waves-effect waves-light',
                    'title' => 'Return',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'print' => [
                'icon' => 'fa fa-print',
                'label' => 'Print',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-success btn-mini waves-effect waves-light',
                    'title' => 'Print',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'export' => [
                'icon' => 'fa fa-download',
                'label' => 'Export',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-primary btn-mini waves-effect waves-light',
                    'title' => 'Download',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'import' => [
                'icon' => 'fa fa-upload',
                'label' => 'Import',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-danger btn-mini waves-effect waves-light',
                    'title' => 'Upload',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'pdf' => [
                'icon' => 'fa fa-file-pdf-o',
                'label' => 'PDF',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-danger btn-mini waves-effect waves-light',
                    'title' => 'PDF',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'calendar' => [
                'icon' => 'fa fa-calendar-o',
                'label' => 'Designer Availability',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-danger btn-mini waves-effect waves-light',
                    'title' => 'Designer Availability',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ],
            'download' => [
                'icon' => 'fa fa-download',
                'label' => 'Download',
                'attributes' => [
                    'href' => '#!',
                    'class' => 'btn btn-danger btn-mini waves-effect waves-light',
                    'title' => 'Download',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top'
                ]
            ]
        ];
    }
}

if (!function_exists('quick_buttons')) {
    function quick_buttons($items) {
    $buttons = button_list();
    $html = '';
    if ($items && !empty($items)) {
        foreach ($items as $key => $btn) {
            $attributes = [];
            if (is_string($key)) {
                $_button = $key;
                $attributes = $btn;
            } else {
                $_button = $btn;
            }
            if (array_key_exists($_button, $buttons)) {

                $style = $buttons[$_button];

                if (array_key_exists('attributes', $style)) {
                    $attributes = array_merge($style['attributes'], $attributes);
                }
                $attribute = urldecode(str_replace('=', '="', http_build_query($attributes, 'null', '" ')) . 'html.php');
                $html .= '<a ' . $attribute . '><i class="' . $style['icon'] . '"></i></a>';
            }
        }

    }
    if ($html !== '') {
        return '<div class="f-right btn-group ">' . $html . '</div>';
    }
    return null;
}
}

if (!function_exists('table_button')) {
    function table_button($button, $label, $attributes = [], $tag = 'a', $displayLabel = false) {
        $buttons = button_list();
        $labelText = $displayLabel ? '<span class="m-l-10">' . $label . '</span>' : '';
        if (array_key_exists($button, $buttons)) {
            if (array_key_exists('icon', $attributes)) {
                $buttons[$button]['icon'] = $attributes['icon'];
                unset($attributes['icon']);
            }
            $style = $buttons[$button];
            if (array_key_exists('attributes', $style)) {
                $attributes = array_merge($style['attributes'], $attributes);
                if ($tag != 'a') {
                    $attributes = array_merge(['type' => 'button'], $attributes);
                }
            }
            $attribute = urldecode(str_replace('=', '="', http_build_query($attributes, 'null', '" ')) . '"');
            return '<' . $tag . ' ' . $attribute . ' style="margin-left:5px;">
                                    <i class="' . $style['icon'] . '"></i>' . $labelText . '
                                </' . $tag . '>';
        } else {

            if (!array_key_exists('title', $attributes)) {
                $attributes['title'] = $label;
            }

            $attributes['data-toggle'] = 'tooltip';
            $attributes['data-placement'] = 'top';

            $attribute = urldecode(str_replace('=', '="', http_build_query($attributes, 'null', '" ')) . '"');

            $icon = array_key_exists('icon', $attributes) ? '<i class="' . $attributes['icon'] . '"></i>' : '';

            return '<' . $tag . ' ' . $attribute . ' style="margin-left:5px;">' . $icon . $labelText . '</' . $tag . '>';
        }
    }
}
