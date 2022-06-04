<?php

    declare(strict_types=1);

    enum Gender: int
    {
        case MAN = 1;
        case WOMAN = 2;
        case UNKNOWN = 3;

        /**
         * @return string
         */
        public function description(): string
        {
            return match($this) {
                self::MAN => '男性',
                self::WOMAN => '女性',
                self::UNKNOWN => '未回答',
            };
        }
    }
