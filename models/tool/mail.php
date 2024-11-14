<?php

class ToolMailModel extends BaseModel
{
    public function sendMail($to, $subject, $message, $optional_from = null)
    {
        global $MAIL_FROM;

        $from = $MAIL_FROM;
        if ($optional_from)
            $from = $optional_from;

        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: " . $from . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        return mail($to, $subject, $message, $headers);

    }
}