<?php

require_once "Database.php";
require_once "Bot.php";


////////////massage
//{
//    "update_id":207882735,
//    "message":
//    {
//        "message_id":4778,
//        "from":
//        {
//            "id":1005024016,
//            "is_bot":false,
//            "first_name":"\u1d053\ua730\u1d00\u1d1c\u029f\u1d1b",
//            "last_name":"\u1d18\u0280\u1d0f\u0262\u0280\u1d00\u1d0d\u1d0d\u1d07\u0280",
//            "username":"defProger",
//            "language_code":"ru"
//        },
//        "chat":
//        {
//            "id":1005024016,
//            "first_name":"\u1d053\ua730\u1d00\u1d1c\u029f\u1d1b",
//            "last_name":"\u1d18\u0280\u1d0f\u0262\u0280\u1d00\u1d0d\u1d0d\u1d07\u0280",
//            "username":"defProger",
//            "type":"private"
//        },
//        "date":1635501947,
//        "text":"asdasd"
//    }
//}


////////callback_data
//{
//    "update_id":207882762,
//    "callback_query":
//    {
//        "id":"4316545281924898172",
//        "from":
//        {
//            "id":1005024016,
//            "is_bot":false,
//            "first_name":"\u1d053\ua730\u1d00\u1d1c\u029f\u1d1b",
//            "last_name":"\u1d18\u0280\u1d0f\u0262\u0280\u1d00\u1d0d\u1d0d\u1d07\u0280",
//            "username":"defProger",
//            "language_code":"ru"
//        },
//        "message":
//        {
//            "message_id":4820,
//            "from":
//            {
//                "id":1286080556,
//                "is_bot":true,
//                "first_name":"leva loh",
//                "username":"levalohbot"
//            },
//            "chat":
//            {
//                "id":1005024016,
//                "first_name":"\u1d053\ua730\u1d00\u1d1c\u029f\u1d1b",
//                "last_name":"\u1d18\u0280\u1d0f\u0262\u0280\u1d00\u1d0d\u1d0d\u1d07\u0280",
//                "username":"defProger",
//                "type":"private"
//            },
//            "date":1635503517,
//            "text":"\u0412\u044b\u0431\u0435\u0440\u0435\u0442\u0435 \u0442\u0438\u043f \u043f\u043e\u0438\u0441\u043a\u0430",
//            "reply_markup":
//            {
//                "inline_keyboard":
//                [
//                    [
//                        {
//                            "text":"\u041f\u043e \u0443\u043b\u0438\u0446\u0435",
//                            "callback_data":"street"
//                        },
//                        {
//                            "text":"\u041f\u043e mac:",
//                            "callback_data":"mac"
//                        }
//                    ]
//                ]
//            }
//        },
//        "chat_instance":"-6390827724532247218",
//        "data":"street"
//    }
//}


////////contact
//{
//    "update_id":207883434,
//    "message":
//    {
//        "message_id":5925,
//        "from":
//        {
//            "id":1005024016,
//            "is_bot":false,
//            "first_name":"\u1d053\ua730\u1d00\u1d1c\u029f\u1d1b",
//            "last_name":"\u1d18\u0280\u1d0f\u0262\u0280\u1d00\u1d0d\u1d0d\u1d07\u0280",
//            "username":"defProger",
//            "language_code":"ru"
//        },
//        "chat":
//        {
//            "id":1005024016,
//            "first_name":"\u1d053\ua730\u1d00\u1d1c\u029f\u1d1b",
//            "last_name":"\u1d18\u0280\u1d0f\u0262\u0280\u1d00\u1d0d\u1d0d\u1d07\u0280",
//            "username":"defProger",
//            "type":"private"
//        },
//        "date":1636394964,
//        "reply_to_message":
//        {
//            "message_id":5922,
//            "from":
//            {
//                "id":1286080556,
//                "is_bot":true,
//                "first_name":"leva loh",
//                "username":"levalohbot"
//            },
//            "chat":
//            {
//                "id":1005024016,
//                "first_name":"\u1d053\ua730\u1d00\u1d1c\u029f\u1d1b",
//                "last_name":"\u1d18\u0280\u1d0f\u0262\u0280\u1d00\u1d0d\u1d0d\u1d07\u0280",
//                "username":"defProger",
//                "type":"private"
//            },
//            "date":1636394807,
//            "text":"\u0412\u044b\u0431\u0435\u0440\u0438\u0442\u0435 \u043d\u0443\u0436\u043d\u0443\u044e \u0444\u0443\u043d\u043a\u0446\u0438\u044e"
//        },
//        "contact":
//        {
//            "phone_number":"+380931819902",
//            "first_name":"\u1d053\ua730\u1d00\u1d1c\u029f\u1d1b",
//            "last_name":"\u1d18\u0280\u1d0f\u0262\u0280\u1d00\u1d0d\u1d0d\u1d07\u0280",
//            "user_id":1005024016
//        }
//    }
//}


//returns
//{
//    "ok": true,
//    "result": {
//        "message_id": 8926,
//        "from": {
//            "id": 1286080556,
//            "is_bot": true,
//            "first_name": "leva loh",
//            "username": "levalohbot"
//        },
//        "chat": {
//            "id": 1005024016,
//            "first_name": "\u1d053\ua730\u1d00\u1d1c\u029f\u1d1b",
//            "last_name": "\u1d18\u0280\u1d0f\u0262\u0280\u1d00\u1d0d\u1d0d\u1d07\u0280",
//            "username": "defProger",
//            "type": "private"
//        },
//        "date": 1640221299,
//        "text": "\u041d\u0435\u0442
//    }
//}


////////getUpdates
//{"ok":true,"result":[
//{"update_id":254732031,
//"message":{"message_id":2,"from":{"id":1005024016,"is_bot":false,"first_name":"\ud835\uddd7\ud835\udfef\ud835\uddf3\ud835\uddee\ud835\ude02\ud835\uddf9\ud835\ude01","last_name":"\ud835\udde3\ud835\uddff\ud835\uddfc\ud835\uddf4\ud835\uddff\ud835\uddee\ud835\uddfa\ud835\uddfa\ud835\uddf2\ud835\uddff","username":"defProger","language_code":"ru"},"chat":{"id":1005024016,"first_name":"\ud835\uddd7\ud835\udfef\ud835\uddf3\ud835\uddee\ud835\ude02\ud835\uddf9\ud835\ude01","last_name":"\ud835\udde3\ud835\uddff\ud835\uddfc\ud835\uddf4\ud835\uddff\ud835\uddee\ud835\uddfa\ud835\uddfa\ud835\uddf2\ud835\uddff","username":"defProger","type":"private"},"date":1661528802,"text":"sadasd"}},
//{"update_id":254732032,
//"message":{"message_id":3,"from":{"id":1005024016,"is_bot":false,"first_name":"\ud835\uddd7\ud835\udfef\ud835\uddf3\ud835\uddee\ud835\ude02\ud835\uddf9\ud835\ude01","last_name":"\ud835\udde3\ud835\uddff\ud835\uddfc\ud835\uddf4\ud835\uddff\ud835\uddee\ud835\uddfa\ud835\uddfa\ud835\uddf2\ud835\uddff","username":"defProger","language_code":"ru"},"chat":{"id":1005024016,"first_name":"\ud835\uddd7\ud835\udfef\ud835\uddf3\ud835\uddee\ud835\ude02\ud835\uddf9\ud835\ude01","last_name":"\ud835\udde3\ud835\uddff\ud835\uddfc\ud835\uddf4\ud835\uddff\ud835\uddee\ud835\uddfa\ud835\uddfa\ud835\uddf2\ud835\uddff","username":"defProger","type":"private"},"date":1661528805,"text":"a"}}]
//}
