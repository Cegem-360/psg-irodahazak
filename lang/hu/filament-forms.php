<?php

declare(strict_types=1);

return [
    'field' => [
        'bulk_select_page' => [
            'label' => 'Összes elem kijelölése/kijelölés megszüntetése tömeges műveletekhez.',
        ],
        'bulk_select_record' => [
            'label' => 'Elem :key kijelölése/kijelölés megszüntetése tömeges műveletekhez.',
        ],
        'checkbox_list' => [
            'search' => [
                'label' => 'Keresés',
                'placeholder' => 'Keresés',
            ],
        ],
        'file_upload' => [
            'editor' => [
                'actions' => [
                    'cancel' => [
                        'label' => 'Mégse',
                    ],
                    'drag_crop' => [
                        'label' => 'Húzás módban "vágás"',
                    ],
                    'drag_move' => [
                        'label' => 'Húzás módban "mozgatás"',
                    ],
                    'flip_horizontal' => [
                        'label' => 'Kép vízszintes tükrözése',
                    ],
                    'flip_vertical' => [
                        'label' => 'Kép függőleges tükrözése',
                    ],
                    'move_down' => [
                        'label' => 'Kép mozgatása lefelé',
                    ],
                    'move_left' => [
                        'label' => 'Kép mozgatása balra',
                    ],
                    'move_right' => [
                        'label' => 'Kép mozgatása jobbra',
                    ],
                    'move_up' => [
                        'label' => 'Kép mozgatása felfelé',
                    ],
                    'reset' => [
                        'label' => 'Visszaállítás',
                    ],
                    'rotate_left' => [
                        'label' => 'Kép forgatása balra',
                    ],
                    'rotate_right' => [
                        'label' => 'Kép forgatása jobbra',
                    ],
                    'set_aspect_ratio' => [
                        'label' => 'Oldalarány beállítása :ratio',
                    ],
                    'save' => [
                        'label' => 'Mentés',
                    ],
                    'zoom_100' => [
                        'label' => 'Kép nagyítása 100%-ra',
                    ],
                    'zoom_in' => [
                        'label' => 'Nagyítás',
                    ],
                    'zoom_out' => [
                        'label' => 'Kicsinyítés',
                    ],
                ],
            ],
        ],
        'key_value' => [
            'add' => [
                'label' => 'Sor hozzáadása',
            ],
            'delete' => [
                'label' => 'Sor törlése',
            ],
            'reorder' => [
                'label' => 'Sor átrendezése',
            ],
        ],
        'markdown_editor' => [
            'toolbar_buttons' => [
                'attach_files' => 'Fájlok csatolása',
                'blockquote' => 'Idézet',
                'bold' => 'Félkövér',
                'bullet_list' => 'Felsorolás',
                'code_block' => 'Kódblokk',
                'heading' => 'Címsor',
                'italic' => 'Dőlt',
                'link' => 'Hivatkozás',
                'ordered_list' => 'Számozott lista',
                'redo' => 'Újra',
                'strike' => 'Áthúzott',
                'table' => 'Táblázat',
                'undo' => 'Visszavonás',
            ],
        ],
        'radio' => [
            'boolean' => [
                'true' => 'Igen',
                'false' => 'Nem',
            ],
        ],
        'repeater' => [
            'add' => [
                'label' => 'Hozzáadás :label',
            ],
            'add_between' => [
                'label' => 'Beszúrás :label elemek közé',
            ],
            'delete' => [
                'label' => 'Törlés',
            ],
            'reorder' => [
                'label' => 'Áthelyezés',
            ],
            'move_down' => [
                'label' => 'Mozgatás lefelé',
            ],
            'move_up' => [
                'label' => 'Mozgatás felfelé',
            ],
            'collapse' => [
                'label' => 'Összecsukás',
            ],
            'expand' => [
                'label' => 'Kibontás',
            ],
            'collapse_all' => [
                'label' => 'Összes összecsukása',
            ],
            'expand_all' => [
                'label' => 'Összes kibontása',
            ],
        ],
        'rich_editor' => [
            'dialogs' => [
                'link' => [
                    'actions' => [
                        'link' => 'Hivatkozás',
                        'unlink' => 'Hivatkozás eltávolítása',
                    ],
                    'label' => 'URL',
                    'placeholder' => 'Adjon meg egy URL-t',
                ],
            ],
            'toolbar_buttons' => [
                'attach_files' => 'Fájlok csatolása',
                'blockquote' => 'Idézet',
                'bold' => 'Félkövér',
                'bullet_list' => 'Felsorolás',
                'code_block' => 'Kódblokk',
                'h1' => 'Cím',
                'h2' => 'Címsor',
                'h3' => 'Alcím',
                'italic' => 'Dőlt',
                'link' => 'Hivatkozás',
                'ordered_list' => 'Számozott lista',
                'redo' => 'Újra',
                'strike' => 'Áthúzott',
                'underline' => 'Aláhúzott',
                'undo' => 'Visszavonás',
            ],
        ],
        'select' => [
            'actions' => [
                'create_option' => [
                    'modal' => [
                        'heading' => 'Létrehozás',
                        'actions' => [
                            'create' => [
                                'label' => 'Létrehozás',
                            ],
                            'create_another' => [
                                'label' => 'Létrehozás és újabb hozzáadása',
                            ],
                        ],
                    ],
                ],
                'edit_option' => [
                    'modal' => [
                        'heading' => 'Szerkesztés',
                        'actions' => [
                            'save' => [
                                'label' => 'Mentés',
                            ],
                        ],
                    ],
                ],
            ],
            'boolean' => [
                'true' => 'Igen',
                'false' => 'Nem',
            ],
            'loading_message' => 'Betöltés...',
            'max_items_message' => 'Csak :count elem választható ki.',
            'no_search_results_message' => 'Nincs eredmény a keresésre.',
            'placeholder' => 'Válasszon egy opciót',
            'searching_message' => 'Keresés...',
            'search_prompt' => 'Kezdjen el gépelni a kereséshez...',
        ],
        'tags_input' => [
            'placeholder' => 'Új címke',
        ],
        'textarea' => [
            'placeholder' => 'Írjon ide...',
        ],
        'toggle' => [
            'boolean' => [
                'true' => 'Igen',
                'false' => 'Nem',
            ],
        ],
        'wizard' => [
            'actions' => [
                'previous_step' => [
                    'label' => 'Vissza',
                ],
                'next_step' => [
                    'label' => 'Tovább',
                ],
            ],
        ],
    ],
];
