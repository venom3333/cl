<?php

namespace app\models;

use core\base\Model;

class Mail extends Model {

    public function sendArrayToDefaultMail(string $subject, array $data) {
        $date = new \DateTime();
        $message = $date->format("D, d M Y H:i:s O");
        foreach ($data as $key => $value) {
            $message .= "\r\n\r\n$key: $value";
        }
        $message = wordwrap($message, 70, "\r\n");

        //$to = ADMIN_EMAIL;
        $to = DEFAULT_EMAIL . "," . ADMIN_EMAIL;

        // Заголовки
        $headers = [];
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/plain; charset=utf-8";
        $headers[] = "From: customlight.ru";
        $headers = implode("\r\n", $headers);

        return mail($to, $subject, $message, $headers) ? true : false;
    }

}
