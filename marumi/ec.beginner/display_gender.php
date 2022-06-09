<?php

    declare(strict_types=1);

    enum Gender: int
    {
        case MAN = 0;
        case WOMAN = 1;
        case UNKNOWN = 2;

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
