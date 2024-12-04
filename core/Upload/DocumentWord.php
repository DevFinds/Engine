<?php


namespace Core\Upload;

use ZipArchive;

class DocumentWord extends ZipArchive
{
    // Файлы для включения в архив
    private $files;

    // Путь к шаблону
    public $path;

    public function __construct($filename, $template_path = '/template/')
    {

        // Путь к шаблону
        $this->path = dirname(__FILE__) . $template_path;

        // Если не получилось открыть файл, то жизнь бессмысленна.
        if ($this->open($filename, ZIPARCHIVE::CREATE) !== TRUE) {
            die("Unable to open <$filename>\n");
        }


        // Структура документа
        $this->files = array(
            "word/_rels/document.xml.rels",
            "word/theme/theme1.xml",
            "word/fontTable.xml",
            "word/settings.xml",
            "word/styles.xml",
            "word/document.xml",
            "word/stylesWithEffects.xml",
            "word/webSettings.xml",
            "_rels/.rels",
            "docProps/app.xml",
            "docProps/core.xml",
            "[Content_Types].xml"
        );

        // Добавляем каждый файл в цикле
        foreach ($this->files as $f)
            $this->addFile($this->path . $f, $f);
    }

    // Упаковываем архив
    public function create()
    {

        $this->close();
    }
}
