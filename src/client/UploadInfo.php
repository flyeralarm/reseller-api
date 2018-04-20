<?php

namespace flyeralarm\ResellerApi\client;

class UploadInfo
{
    const TYPE_UPLOAD = 'upload';

    const TYPE_CD = 'cd';

    private $type;

    private $datum;

    private $text;


    public function __construct()
    {
        $this->type = self::TYPE_UPLOAD;
    }

    public function setDateToNow()
    {
        date_default_timezone_set('Europe/Berlin');
        $this->datum = date('d.m.Y H:i:s');
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getArray()
    {
        return [
            'dataTransferType' => (string) $this->type,
            'dataTransferTime' => (string) $this->datum,
            'dataTransferText' => (string) $this->text,
            'referenceText' => (string) $this->text,
        ];
    }
}
