<?php
require_once 'Msg.php';

class Bot
{

    //not deleted
    public $chatId = null;
    public $toChatId = null;
    public $username = null;
    public $lastSendMessage = null;
    public $inputMessage = null;
    public $contact = null;
    protected $message_id = null;
    protected $logging = false;
    //deleted
    protected $goingChecker = null;
    protected $text = null;
    protected $video = null;
    protected $parse_mode = null;
    protected $method = null;
    protected $replyMarkupBody = null;

    public function __construct($token)
    {
        $this->botApi = "https://api.telegram.org/bot{$token}/";
        $this->update = json_decode(file_get_contents('php://input'), TRUE);
        if ($this->update['message']) {
            $this->chatId = $this->update['message']['from']['id'];
            $this->username = $this->update['message']['from']['username'];
            $this->message_id = $this->update['message']['message_id'];
            $this->inputMessage = $this->update['message']['text'];

        } elseif ($this->update['callback_query']['data']) {
            $this->chatId = $this->update['callback_query']['from']['id'];
            $this->username = $this->update['callback_query']['from']['username'];
            $this->message_id = $this->update['callback_query']['message']['message_id'];
            $this->inputMessage = $this->update['callback_query']['message']['text'];
        }
        if ($this->update['message']['contact'])
            $this->contact = $this->update['message']['contact'];

    }

    //Отсыл
    public function toChat($chatId)
    {
        $this->toChatId = $chatId;
        return $this;
    }

    public function Message($text, $parse = null)
    {
        $this->text = $text;
        $this->parse_mode = $parse;
        return $this;
    }

    public function replyMarkup($inlineOrKeyboard)
    {
        self::log('replyMarkup()', print_r($inlineOrKeyboard, 1));
        $this->replyMarkupBody = "&reply_markup=" . json_encode($inlineOrKeyboard);
        return $this;
    }

    public function Video($file_id)
    {
        $this->method = 'sendVideo';
        $this->video = $file_id;

        return $this;
    }

    public function Edit($msg = null)
    {
        $this->method = 'editMessageText';
        if ($msg !== null)
            $this->message_id = $msg;

        return $this;
    }

    public function Send()
    {
        $chat_id = $this->toChatId === null ? $this->chatId : $this->toChatId;

        $headers = [
            'chat_id' => $chat_id,
            'parse_mode' => $this->parse_mode
        ];


        if ($this->method === null)
            $this->method = 'sendMessage';
        elseif ($this->method === 'editMessageText')
            $headers['message_id'] = $this->message_id;


        if ($this->video !== null) {
            $headers['video'] = $this->video;
            $headers['caption'] = $this->text;
        } else {
            if ($this->method === 'editMessageText' && $this->text === null) $this->method = 'editMessageReplyMarkup';
            else $headers['text'] = $this->text;
        }

        $sendHead = http_build_query($headers);

        if ($chat_id !== null && $this->method !== null && ($this->goingChecker || $this->goingChecker === null)) {
            $r = $this->botApi . "{$this->method}?{$sendHead}{$this->replyMarkupBody}";
            self::log('Send()', 'Запрос ' . $r);
            $this->lastSendMessage = json_decode(file_get_contents($r), 1);
            if ($this->lastSendMessage['ok']) $this->lastSendMessage = $this->lastSendMessage['result'];
            else self::log('Send() ERROR', $this->lastSendMessage);
        } else {
            self::log('Send() IF ERROR', "\nHeaders: " . print_r($headers, 1) . "\n Method: {$this->method}\n Checker: " . (print $this->goingChecker));
        }
        $this->parse_mode = null;
        $this->text = null;
        $this->video = null;
        $this->method = null;
        $this->replyMarkupBody = null;
        $this->goingChecker = null;
    }

    public function delete($id = null)
    {
        $sendHead = http_build_query([
            'chat_id' => $this->toChatId === null ? $this->chatId : $this->toChatId,
            'message_id' => $id === null ? $this->message_id : $id
        ]);

        file_get_contents($this->botApi . "deleteMessage?{$sendHead})");

    }

    //Получение

    public function data($data, $f = null)
    {
        $this->goingChecker = $data === '*' || $data === $this->update['callback_query']['data'];
        if ($f !== null && $this->goingChecker) $f($this, $this->update['callback_query']['data'], $this->inputMessage);
        else $this->goingChecker = null;
        return $this;
    }

    public function text($text, $f = null)
    {
        $this->goingChecker = $text === '*' || $text === $this->update['message']['text'];
        if ($f !== null && $this->goingChecker) $f($this, $this->inputMessage);
        else $this->goingChecker = null;
        return $this;
    }

    public function getVideo($f = null)
    {
        $this->goingChecker = isset($this->update['message']['video']);
        if ($f !== null && $this->goingChecker) $f($this, $this->update['message']['video']['file_id']);
        else $this->goingChecker = null;
        return $this;
    }

//    public function contact()
//    {
//        if ($this->update['message']['contact']) ;
//    }


    public function getUpdate($text, $callback_data, $contact = null)
    {
        $this->goingChecher = true;

        if ($this->update !== null) {
            if ($this->update['message']['text']) {
                $text($this->update['message']['text']);
            } elseif ($this->update['callback_query']['data']) {
                $callback_data($this->update['callback_query']['data']);
            }
            if ($contact !== null && $this->update['message']['contact'])
                $contact($this->update['message']['contact']);
        } else {
            self::log('getUpdate()', 'Nothing from webhooks');
        }
    }

    public function startLog($fileName = null)
    {
        $f = $fileName === null ? '.log' : $fileName;
        $this->logging = true;
        $this->logfile = fopen($f, 'a+');

        self::log('-----------------------------------', '-----------------------------------');
        self::log('getUpdate', print_r($this->update, 1));
    }

    public function log($type, $text)
    {
        if ($this->logging) {
            if (is_array($text)) {
                $text = print_r($text, 1);
            }
            fputs($this->logfile, date('Y-m-d H:i:s') . " | {$type} | {$text}" . "\n");
        }
    }
}
