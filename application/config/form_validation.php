<?php

$config = [
    'add_article_rule' => [
        [
            'field' => 'title',
            'lable' => 'Article Title',
            'rules' => 'required'
        ],
        [
            'field' => 'body',
            'lable' => 'Article Body',
            'rules' => 'required'
        ]
    ],
    'admin_login' => [
        [
            'field' => 'username',
            'lable' => 'Username',
            'rules' => 'required|alpha|trim'
        ],
        [
            'field' => 'password',
            'lable' => 'Password',
            'rules' => 'required'
        ]
    ],
    'spidey_form_rule' => [
        [
            'field' => 'title',
            'lable' => 'Spidey Title',
            'rules' => 'required|trim'
        ],
        [
            'field' => 'headline',
            'lable' => 'Short Description',
            'rules' => 'required'
        ],
        [
            'field' => 'pickDesc',
            'lable' => 'Full Description',
            'rules' => 'required'
        ],
        [
            'field' => 'spideyImage',
            'lable' => 'Spidey Large Image',
            'rules' => 'required'
        ],
        [
            'field' => 'spideyImageSmall',
            'lable' => 'Spidey Small Image',
            'rules' => 'required'
        ],
        [
            'field' => 'photocredit',
            'lable' => 'Photo Credit',
            'rules' => 'required'
        ],
        [
            'field' => 'photocaption',
            'lable' => 'Photo Caption',
            'rules' => 'required'
        ],
        [
            'field' => 'subHeadLine',
            'lable' => 'Source / By/ Line',
            'rules' => 'required'
        ],
        [
            'field' => 'category_id',
            'lable' => 'Category',
            'rules' => 'required'
        ]
    ]
];
