<?php

return [
    'collections' => [
        'SVG' => [
            'label' => 'SVG',
            'constraints' => [
                'mimetypes' => [
                    'image/svg+xml',
                    'image/svg'
                ]
            ]
        ],
        'Pictures' => [
            'label' => 'Pictures',
            'constraints' => [
                'mimetypes' => [
                    'image/jpeg'
                ]
            ]
        ]
    ],
];
