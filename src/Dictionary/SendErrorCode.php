<?php

namespace Ognistyi\AtomPark\Dictionary;


class SendErrorCode
{
    protected $code;
    protected $text;

    const AUTH_FAILED = -1;
    const XML_ERROR = -2;
    const NOT_ENOUGH_CREDITS = -3;
    const NO_RECIPIENTS = -4;
    const INVALID_TEXT = -5;
    const BAD_SENDER_NAME = -7;

    protected static $all = [
        self::AUTH_FAILED => 'Неправильный логин и/или пароль',
        self::XML_ERROR => 'Неправильный формат XML',
        self::NOT_ENOUGH_CREDITS => 'Недостаточно кредитов на аккаунте пользователя',
        self::NO_RECIPIENTS => 'Нет верных номеров получателей',
        self::INVALID_TEXT => 'Неверний текст',
        self::BAD_SENDER_NAME => 'Ошибка в имени отправителя',
    ];

    public function __construct($code)
    {
        $this->code = $code;

        if (array_key_exists($code, static::$all)) {
            $this->text = static::$all[$code];
        }
    }

    public function getErrorCode()
    {
        return $this->code;
    }

    public function getErrorText()
    {
        return $this->text;
    }

    static public function make ($code) {
        return new static($code);
    }
}