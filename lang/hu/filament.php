<?php

declare(strict_types=1);

return [
    'actions' => [
        'associate' => [
            'single' => [
                'label' => 'Hozzárendelés',
            ],
            'multiple' => [
                'label' => 'Hozzárendelés',
            ],
        ],
        'attach' => [
            'single' => [
                'label' => 'Csatolás',
            ],
            'multiple' => [
                'label' => 'Csatolás',
            ],
        ],
        'create' => [
            'label' => 'Létrehozás',
        ],
        'delete' => [
            'single' => [
                'label' => 'Törlés',
            ],
            'multiple' => [
                'label' => 'Törlés',
            ],
        ],
        'detach' => [
            'single' => [
                'label' => 'Leválasztás',
            ],
            'multiple' => [
                'label' => 'Leválasztás',
            ],
        ],
        'dissociate' => [
            'single' => [
                'label' => 'Társítás megszüntetése',
            ],
            'multiple' => [
                'label' => 'Társítás megszüntetése',
            ],
        ],
        'edit' => [
            'label' => 'Szerkesztés',
        ],
        'export' => [
            'label' => 'Exportálás',
        ],
        'import' => [
            'label' => 'Importálás',
        ],
        'replicate' => [
            'label' => 'Másolás',
        ],
        'view' => [
            'label' => 'Megtekintés',
        ],
    ],

    'components' => [
        'pagination' => [
            'buttons' => [
                'next' => [
                    'label' => 'Következő',
                ],
                'previous' => [
                    'label' => 'Előző',
                ],
            ],
        ],
        'section' => [
            'collapse' => [
                'label' => 'Összecsukás',
            ],
            'expand' => [
                'label' => 'Kibontás',
            ],
        ],
    ],

    'filters' => [
        'buttons' => [
            'remove' => [
                'label' => 'Szűrő eltávolítása',
            ],
            'remove_all' => [
                'label' => 'Összes szűrő eltávolítása',
            ],
            'reset' => [
                'label' => 'Visszaállítás',
            ],
        ],
        'multiselect' => [
            'placeholder' => 'Összes',
        ],
        'select' => [
            'placeholder' => 'Összes',
        ],
        'trashed' => [
            'label' => 'Törölt rekordok',
            'only_trashed' => 'Csak törölt',
            'with_trashed' => 'Töröltekkel együtt',
            'without_trashed' => 'Törölt nélkül',
        ],
    ],

    'form' => [
        'are_you_sure' => 'Biztos benne?',
    ],

    'table' => [
        'actions' => [
            'bulk_actions' => [
                'label' => 'Tömeges műveletek',
            ],
            'filter' => [
                'label' => 'Szűrés',
            ],
            'group' => [
                'label' => 'Csoportosítás',
            ],
            'open_bulk_actions' => [
                'label' => 'Műveletek',
            ],
            'toggle_columns' => [
                'label' => 'Oszlopok váltása',
            ],
        ],
        'bulk_actions' => [
            'delete' => [
                'label' => 'Kijelöltek törlése',
            ],
        ],
        'columns' => [
            'toggle' => [
                'more' => 'Még :count',
            ],
        ],
        'empty' => [
            'heading' => 'Nincs rekord',
            'description' => 'Kezdjen el egy :model létrehozásával.',
        ],
        'filters' => [
            'actions' => [
                'remove' => [
                    'label' => 'Szűrő eltávolítása',
                ],
                'remove_all' => [
                    'label' => 'Összes szűrő eltávolítása',
                ],
                'reset' => [
                    'label' => 'Visszaállítás',
                ],
            ],
            'heading' => 'Szűrők',
            'indicator' => 'Aktív szűrők',
        ],
        'grouping' => [
            'fields' => [
                'group' => [
                    'label' => 'Csoportosítás',
                    'placeholder' => 'Csoportosítás',
                ],
                'direction' => [
                    'label' => 'Csoportosítás iránya',
                    'options' => [
                        'asc' => 'Növekvő',
                        'desc' => 'Csökkenő',
                    ],
                ],
            ],
        ],
        'pagination' => [
            'label' => 'Lapozás navigáció',
            'overview' => ':first és :last közötti rekordok a :total összesből',
            'fields' => [
                'records_per_page' => [
                    'label' => 'oldalanként',
                    'options' => [
                        'all' => 'Összes',
                    ],
                ],
            ],
        ],
        'search' => [
            'label' => 'Keresés',
            'placeholder' => 'Keresés',
            'indicator' => 'Keresés',
        ],
        'sorting' => [
            'fields' => [
                'column' => [
                    'label' => 'Rendezés',
                ],
                'direction' => [
                    'label' => 'Rendezés iránya',
                    'options' => [
                        'asc' => 'Növekvő',
                        'desc' => 'Csökkenő',
                    ],
                ],
            ],
        ],
    ],
];
