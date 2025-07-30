<?php

return [
    'title' => 'Sütiket használunk',
    'intro' => 'Ez a weboldal sütiket használ az általános felhasználói élmény javítása érdekében.',
    'link' => 'További információkért tekintse meg <a href=":url">Sütikre vonatkozó szabályzatunkat</a>.',

    'essentials' => 'Csak a legszükségesebbek',
    'all' => 'Mindent elfogadok',
    'customize' => 'Testreszabás',
    'manage' => 'Sütik kezelése',
    'details' => [
        'more' => 'További részletek',
        'less' => 'Kevesebb részlet',
    ],
    'save' => 'Beállítások mentése',

    'categories' => [
        'essentials' => [
            'title' => 'Lényeges sütik',
            'description' => 'Vannak olyan sütik, amelyeket bizonyos weboldalak működéséhez be kell építenünk. Ezért ezekhez nem szükséges az Ön hozzájárulása.',
        ],
        'analytics' => [
            'title' => 'Analitikai sütik',
            'description' => 'Ezeket belső kutatásra használjuk, hogy hogyan tudjuk javítani a szolgáltatásunkat, amelyet minden felhasználó számára nyújtunk. Ezek a sütik azt értékelik, hogy Ön hogyan lép interakcióba a weboldalunkkal.',
        ],
        'optional' => [
            'title' => 'Választható sütik',
            'description' => 'Ezek a sütik olyan funkciókat tesznek lehetővé, amelyek javíthatják a felhasználói élményt, de hiányuk nem befolyásolja a weboldalunk böngészésének lehetőségét.',
        ],
    ],

    'defaults' => [
        'consent' => 'A felhasználó sütikre vonatkozó hozzájárulási preferenciáinak tárolására szolgál.',
        'session' => 'A felhasználó böngészési munkamenetének azonosítására szolgál.',
        'csrf' => 'A felhasználó és a weboldalunk védelmére szolgál a cross-site request forgery támadások ellen.',
        '_ga' => 'A Google Analytics által használt fő cookie, amely lehetővé teszi a szolgáltatás számára, hogy megkülönböztesse az egyik látogatót a másiktól.',
        '_ga_ID' => 'A Google Analytics használja a munkamenet állapotának megőrzésére.',
        '_gid' => 'A Google Analytics használja a felhasználó azonosítására.',
        '_gat' => 'A Google Analytics használja a lekérdezési arány korlátozására.',
    ],
];
