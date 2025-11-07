<?php
return [
    'appName'=>'MVCアプリケーション2025',
    'appId' => 'spl2025mvc',
    'appVerion' => '1.00',

    'routing_table' => [    
        //method, regex pattern, [controller(c), action(a)], [parameters]  
        //正規表現 \w+: 文字列, \d+: 整数　(): パラメータpの要素を（複数ある場合は、左から順に）定義する
        ['GET', '/', ['c'=>'User', 'a'=>'list']],
        ['GET', '/[a-z]+/error/(\w+)', ['c'=>'User', 'a'=>'error'], ['msg'] ],
        ['GET', '/u/create', ['c'=>'User','a'=>'create'] ],
        ['GET', '/u/list', ['c'=>'User','a'=>'list'] ],
        ['GET', '/u/detail/(\w+)', ['c'=>'User','a'=>'detail'], ['uid'] ],
        ['GET', '/u/update/(\w+)', ['c'=>'User','a'=>'update'], ['uid'] ],
        ['GET', '/u/delete/(\w+)', ['c'=>'User','a'=>'delete'], ['uid'] ],
        ['GET', '/u/login', ['c'=>'User', 'a'=>'login'] ],
        ['GET', '/u/logout', ['c'=>'User', 'a'=>'logout'] ],
        ['POST', '/u/save', ['c'=>'User','a'=>'save'] ],
        ['POST', '/u/auth', ['c'=>'User','a'=>'auth'] ],
    ],
    
    'codes' => [
        'urole' => [1=>'学生', 2=>'教員', 9=>'管理者'],
        'sex' => [0=>'未指定', 1=>'男', 2=>'女', ],
        'apl_status'=> [1=>'申請中',2=>'承認済み',3=>'却下済み',9=>'取り下げ'],
        'ins_status'=> [1=>'貸出可',2=>'貸出中', 3=>'修理中',9=>'除却・廃棄済み'],
        'dept'=>['RS'=>'情報科学科', 'RM'=>'機械工学科', 'RE'=>'電気工学科', ],
    ],
];