<?php
include_once "error_log.php";
require_once "app/inc.php";

$card = '4149 4993 8086 2431';
$bot = new Bot('5559490398:AAEqGo_5HPI5DiHyRZYCrHONP6fxRanYsK4');
$bot->startLog();

$user = db_getById('users', $bot->chatId);
function start($edit = false)
{
    global $bot;
    global $user;
    if ($edit) $bot->Edit();

    $all = db_getAll('videos');
    $my = db_query("select * from `inventory` where `uid`='{$bot->chatId}'");
    $bot->Message("Привет {$user['name']}\nИнвентарь: " . count($my) . "\nВидео в базе: " . count($all))
        ->replyMarkup(Msg::Inline(
            Msg::Row(Msg::dataBtn('Мои видео', 'inventory')),
            Msg::Row(Msg::dataBtn('Все темы', 'allvideos'))
        ))
        ->Send();

}

$bot->text('/start', function (Bot $b) use ($user) {
    if (!isset($user['id'])) {
        db_insert('users', [
            "id" => $b->chatId,
            "username" => $b->username,
            "state" => 'name'
        ]);
        $b->Message("Введи пожалуйста своё имя")->Send();
    } else
        start();
});

$bot->data('start', function () {
    start(true);
});

//именования
if ($user['state'] === 'name' && $bot->inputMessage) {
    $bot->Message("Теперь ты записан в базе как $bot->inputMessage \nДля начала напиши /start")
        ->replyMarkup(Msg::Inline(
            Msg::Row(Msg::dataBtn("Сменить имя", 'change_name'))
        ))
        ->Send();
    db_update('users', $bot->chatId, [
        "name" => $bot->inputMessage,
        "state" => 'none'
    ]);
}

$bot->data('change_name', function (Bot $b) {
    $b->Edit()->Message('Введи новое имя')->Send();
    db_update('users', $b->chatId, [
        "state" => "name"
    ]);
});

$bot->data('inventory', function (Bot $b) {
    $ivents = db_query("select * from `inventory` where `uid` = '{$b->chatId}'");
    $inline = [];
    foreach ($ivents as $ivent) {
        $v = db_getById('videos', $ivent['vid']);

        $inline[] = [Msg::dataBtn($v['name'], "send{$ivent['vid']}")];
    }

    $inline[] = [Msg::dataBtn('Назад', "start")];
    $b->Edit()->Message('Ваши видео')
        ->replyMarkup(Msg::Inline($inline))
        ->Send();
});
$bot->data('allvideos', function (Bot $b) {
    $ivents = db_query("select * from `inventory` where `uid` = '{$b->chatId}'");
    $videos = db_getAll('videos');

    $inline = [];

    foreach ($videos as $v) {
        $checker = false;
        foreach ($ivents as $ivent) {
            if ($v['id'] !== $ivent['vid'])
                continue;
            else
                $checker = true;
        }

        if ($checker)
            $inline[] = [Msg::dataBtn($v['name'] . " ✅", "send{$v['id']}")];
        else
            $inline[] = [Msg::dataBtn($v['name'], "buy{$v['id']}")];

    }

    $inline[] = [Msg::dataBtn('Назад', "start")];
    $b->Edit()->Message('Ваши видео')
        ->replyMarkup(Msg::Inline($inline))
        ->Send();
});

$bot->data('*', function (Bot $b, $data) use ($user) {
    if (preg_match('/(send)(\d+)/', $data, $id)) {
        $v = db_getById('videos', $id[2]);
        $b->Video($v['path'])
            ->Message("Название: {$v['name']}\n\nОписание: {$v['descr']}")
            ->Send();
    } else if (preg_match('/(buy)(\d+)/', $data, $id)) {
        $v = db_getById('videos', $id[2]);
        $b->Edit()->Message("Название: {$v['name']}\n\nОписание: {$v['descr']}\n\nЦена: {$v['price']}грн")
            ->replyMarkup(Msg::Inline(
                Msg::Row(Msg::dataBtn('Купить', "pay{$id[2]}")),
                Msg::Row(Msg::dataBtn('Назад', "allvideos"))
            ))
            ->Send();
    } else if (preg_match('/(pay)(\d+)/', $data, $id)) {
        $v = db_getById('videos', $id[2]);
        $b->Message("Покупка видео: {$v['name']}\nЦена: {$v['price']}грн\n\n Реквизиты\n `{$GLOBALS['card']}`\n\nПосле оплаты видео появиться в инвентаре", 'MarkdownV2')
            ->replyMarkup(Msg::Inline(
                Msg::Row(Msg::dataBtn('Купить', "confirm{$id[2]}"))
            ))
            ->Send();
    } else if (preg_match('/(confirm)(\d+)/', $data, $id)) {
        $v = db_getById('videos', $id[2]);
        $b->Edit()->Message("Покупка видео: {$v['name']}\nЦена: {$v['price']}грн\n\n Реквизиты\n `{$GLOBALS['card']}`\n\nЗаявка добавлена, ожидается оплата", 'MarkdownV2')
            ->Send();

        $admin = db_getById('users', '1', 'admin');
        $b->toChat($admin['id'])
            ->Message("Заявка на покупку\n\nПокупатель: {$user['name']}\n\nВидео: {$v['name']}\n\nЦена: {$v['price']}грн")
            ->replyMarkup(Msg::Inline(
                Msg::Row(Msg::dataBtn('Оплатил', "confirm-{$id[2]}-user-{$user['id']}"))
            ))
            ->Send();

    }
});

// добавление видео
$bot->getVideo(function (Bot $b, $video) use ($user) {
    if ($user['admin']) {
        db_insert('videos', [
            'path' => $video
        ]);
        $v = db_query("SELECT LAST_INSERT_ID() from `videos`");
        $b->Message("Видео id: {$v[0]['LAST_INSERT_ID()']}")
            ->replyMarkup(Msg::Inline(
                Msg::Row(Msg::dataBtn('Название', "name_{$v[0]['LAST_INSERT_ID()']}")),
                Msg::Row(Msg::dataBtn('Описание', "descr_{$v[0]['LAST_INSERT_ID()']}")),
                Msg::Row(Msg::dataBtn('Отметить', "ivent_{$v[0]['LAST_INSERT_ID()']}")),
                Msg::Row(Msg::dataBtn('Цена', "price_{$v[0]['LAST_INSERT_ID()']}")),
                Msg::Row(Msg::dataBtn('Обновить', "reload_{$v[0]['LAST_INSERT_ID()']}"))
            ))
            ->Send();
    } else $b->Message('И зачем ты мне это прислал?')->Send();
});

$bot->data('*', function (Bot $b, $data) {
    if (preg_match('/(\w+)_(\d+)/', $data, $id)):
        function checkivent($b, $id)
        {
            $users = db_getAll('users');
            $ivents = db_query("select * from `inventory` where `vid` = '{$id[2]}'");


            $inline = [];
            foreach ($users as $user) {
                if (!$user['admin']):
                    $checker = false;
                    foreach ($ivents as $ivent) {
                        if ($ivent['uid'] !== $user['id']) continue;
                        else $checker = true;
                    }
                    if ($checker)
                        $inline[] = [Msg::dataBtn($user['name'] . " ✅", "none")];
                    else
                        $inline[] = [Msg::dataBtn($user['name'], "add-{$id[2]}-user-{$user['id']}")];
                endif;
            }
            $inline[] = [Msg::dataBtn('Обновить', "reloadivent_{$id[2]}")];
            $b->Edit()
                ->replyMarkup(
                    Msg::Inline(
                        $inline
                    )
                )
                ->Send();
        }

        switch ($id[1]) {
            case 'name':
                db_update('videos', $id[2], [
                    "name" => '?'
                ]);
                db_update('users', $b->chatId, [
                    "state" => "name_{$id[2]}"
                ]);
                break;
            case 'descr':
                db_update('videos', $id[2], [
                    "descr" => '?'
                ]);
                db_update('users', $b->chatId, [
                    "state" => "descr_{$id[2]}"
                ]);
                break;
            case 'price':
                db_update('videos', $id[2], [
                    "price" => '?'
                ]);
                db_update('users', $b->chatId, [
                    "state" => "price_{$id[2]}"
                ]);
                break;
            case 'ivent':
                $users = db_getAll('users');
                $inline = [];
                foreach ($users as $user) {
                    if (!$user['admin'])
                        $inline[] = [Msg::dataBtn($user['name'], "add-{$id[2]}-user-{$user['id']}")];
                }
                $inline[] = [Msg::dataBtn('Обновить', "reloadivent_{$id[2]}")];
                $b->Message('Выбери присутсвующих на занятии ')
                    ->replyMarkup(
                        Msg::Inline(
                            $inline
                        )
                    )
                    ->Send();
                break;
            case 'reloadivent':
                checkivent($b, $id);
                break;
        }

        if (($id[1] !== 'ivent' && $id[1] !== 'reloadivent')):
            $v = db_getById('videos', $id[2]);
            $b->Edit()->Message("Видео id: {$v['id']}\n Имя: {$v['name']} \n\n Описание: {$v['descr']} \n\n Цена: {$v['price']} ")
                ->replyMarkup(
                    $b->update['callback_query']['message']['reply_markup']
                )
                ->Send();
        endif;
    endif;

    if (preg_match('/(\w+)-(\d+)-(user)-(\d+)/', $data, $id)):
        $chek = db_query("select * from `inventory` where `uid`='{$id[4]}' and `vid`='{$id[2]}'");
        if (!isset($chek[0]))
            db_insert('inventory', [
                'uid' => $id[4],
                'vid' => $id[2],
            ]);
        if ($id[1] === 'add') {
            checkivent($b, $id);

        } else
            if ($id[1] === 'confirm') {
                $b->toChat($id[4])->Message('Оплата подтверждена, видео в инвентаре')->Send();
            }
    endif;

});

$bot->text('*', function (Bot $b, $text) use ($user) {
    preg_match('/(\w+)_(\d+)/', $user['state'], $id);
    switch ($id[1]) {
        case 'name':
            db_update('videos', $id[2], [
                "name" => $text
            ]);
            db_update('users', $b->chatId, [
                "state" => "none"
            ]);
            break;
        case 'descr':
            db_update('videos', $id[2], [
                "descr" => $text
            ]);
            db_update('users', $b->chatId, [
                "state" => "none"
            ]);
            break;
        case 'price':
            db_update('videos', $id[2], [
                "price" => $text
            ]);
            db_update('users', $b->chatId, [
                "state" => "none"
            ]);
            break;
    }
});
