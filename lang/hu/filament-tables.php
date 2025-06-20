<?php

declare(strict_types=1);

return [
    'column' => [
        'boolean' => [
            'false' => 'Nem',
            'true' => 'Igen',
        ],
    ],

    'pagination' => [
        'label' => 'Lapozás navigáció',
        'overview' => ':first-:last megjelenítése a :total összesből',
        'fields' => [
            'records_per_page' => [
                'label' => 'oldalanként',
                'options' => [
                    'all' => 'Összes',
                ],
            ],
        ],
        'actions' => [
            'first' => [
                'label' => 'Első',
            ],
            'go_to_page' => [
                'label' => 'Ugrás a :page oldalra',
            ],
            'last' => [
                'label' => 'Utolsó',
            ],
            'next' => [
                'label' => 'Következő',
            ],
            'previous' => [
                'label' => 'Előző',
            ],
        ],
    ],

    'actions' => [
        'attach' => [
            'single' => [
                'label' => 'Csatolás',
            ],
            'multiple' => [
                'label' => 'Csatolás',
            ],
        ],
        'bulk_actions' => [
            'label' => 'Tömeges műveletek',
        ],
        'create' => [
            'label' => 'Új :label',
        ],
        'delete' => [
            'single' => [
                'label' => 'Törlés',
                'modal' => [
                    'heading' => ':label törlése',
                    'actions' => [
                        'delete' => [
                            'label' => 'Törlés',
                        ],
                    ],
                ],
            ],
            'multiple' => [
                'label' => 'Kijelöltek törlése',
                'modal' => [
                    'heading' => 'Kijelölt :label törlése',
                    'actions' => [
                        'delete' => [
                            'label' => 'Törlés',
                        ],
                    ],
                ],
            ],
        ],
        'detach' => [
            'single' => [
                'label' => 'Leválasztás',
                'modal' => [
                    'heading' => ':label leválasztása',
                    'actions' => [
                        'detach' => [
                            'label' => 'Leválasztás',
                        ],
                    ],
                ],
            ],
            'multiple' => [
                'label' => 'Kijelöltek leválasztása',
                'modal' => [
                    'heading' => 'Kijelölt :label leválasztása',
                    'actions' => [
                        'detach' => [
                            'label' => 'Leválasztás',
                        ],
                    ],
                ],
            ],
        ],
        'dissociate' => [
            'single' => [
                'label' => 'Társítás megszüntetése',
                'modal' => [
                    'heading' => ':label társítás megszüntetése',
                    'actions' => [
                        'dissociate' => [
                            'label' => 'Társítás megszüntetése',
                        ],
                    ],
                ],
            ],
            'multiple' => [
                'label' => 'Kijelöltek társítás megszüntetése',
                'modal' => [
                    'heading' => 'Kijelölt :label társítás megszüntetése',
                    'actions' => [
                        'dissociate' => [
                            'label' => 'Társítás megszüntetése',
                        ],
                    ],
                ],
            ],
        ],
        'edit' => [
            'label' => 'Szerkesztés',
        ],
        'export' => [
            'label' => 'Exportálás',
            'modal' => [
                'heading' => 'Exportálás :label',
                'form' => [
                    'type' => [
                        'label' => 'Típus',
                    ],
                ],
                'actions' => [
                    'export' => [
                        'label' => 'Exportálás',
                    ],
                ],
            ],
        ],
        'filter' => [
            'label' => 'Szűrés',
        ],
        'group' => [
            'label' => 'Csoportosítás',
        ],
        'import' => [
            'label' => 'Importálás',
            'modal' => [
                'heading' => 'Importálás :label',
                'form' => [
                    'file' => [
                        'label' => 'Fájl',
                        'placeholder' => 'Töltsön fel egy CSV fájlt',
                    ],
                    'columns' => [
                        'label' => 'Oszlopok',
                        'placeholder' => 'Válasszon egy oszlopot',
                    ],
                ],
                'actions' => [
                    'download_example' => [
                        'label' => 'Példa CSV letöltése',
                    ],
                    'import' => [
                        'label' => 'Importálás',
                    ],
                ],
            ],
        ],
        'open_bulk_actions' => [
            'label' => 'Műveletek megnyitása',
        ],
        'replicate' => [
            'label' => 'Másolás',
        ],
        'toggle_columns' => [
            'label' => 'Oszlopok váltása',
        ],
        'view' => [
            'label' => 'Megtekintés',
        ],
    ],

    'bulk_actions' => [
        'delete' => [
            'label' => 'Kijelöltek törlése',
            'modal' => [
                'heading' => 'Kijelölt :label törlése',
                'actions' => [
                    'delete' => [
                        'label' => 'Törlés',
                    ],
                ],
            ],
        ],
        'detach' => [
            'label' => 'Kijelöltek leválasztása',
            'modal' => [
                'heading' => 'Kijelölt :label leválasztása',
                'actions' => [
                    'detach' => [
                        'label' => 'Leválasztás',
                    ],
                ],
            ],
        ],
        'dissociate' => [
            'label' => 'Kijelöltek társítás megszüntetése',
            'modal' => [
                'heading' => 'Kijelölt :label társítás megszüntetése',
                'actions' => [
                    'dissociate' => [
                        'label' => 'Társítás megszüntetése',
                    ],
                ],
            ],
        ],
        'edit' => [
            'label' => 'Szerkesztés',
            'modal' => [
                'heading' => 'Kijelölt :label szerkesztése',
                'actions' => [
                    'save' => [
                        'label' => 'Változtatások mentése',
                    ],
                ],
            ],
        ],
        'export' => [
            'label' => 'Exportálás',
        ],
    ],

    'columns' => [
        'toggle' => [
            'more' => 'Még :count',
        ],
    ],

    'empty' => [
        'heading' => 'Nincs :model',
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
                'label' => 'Szűrők visszaállítása',
            ],
        ],
        'heading' => 'Szűrők',
        'indicator' => 'Aktív szűrők',
        'multi_select' => [
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

    'reorder_indicator' => 'Húzza a rekordokat sorrendbe.',

    'selection_indicator' => [
        'selected_count' => '1 rekord kijelölve|:count rekord kijelölve',
        'actions' => [
            'select_all' => [
                'label' => 'Összes :count kijelölése',
            ],
            'deselect_all' => [
                'label' => 'Összes kijelölés megszüntetése',
            ],
        ],
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
];
