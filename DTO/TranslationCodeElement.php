<?php
/**
 * Created by Extellient.
 * User: afe}
 * Date: 17/09/2015
 * Time: 11:01
 */

namespace Afe\TranslationToolBundle\DTO;


class TranslationCodeElement
{
    public $translationCode;
    public $fileName;

    public static function buildUI($translationCode, $fileName)
    {
        $ui = new TranslationCodeElement();
        $ui->fileName = $fileName;
        $ui->translationCode = $translationCode;
        return $ui;
    }
}
