<?php
require_once(realpath(dirname(__FILE__) . "/../Configuration.php"));

function __autoload($class_name)
{
    include  LIBRARY_PATH . "/" . $class_name . '.php';
}

function renderLayoutWithContentFile($contentFile, $variables = array())
{
    $contentFileFullPath = TEMPLATES_PATH . "/" . $contentFile;

    if (count($variables) > 0) {
        foreach ($variables as $key => $value) {
            if (strlen($key) > 0) {
                ${$key} = $value;
            }
        }
    }

    require_once(TEMPLATES_PATH . "/header.php");

    if (file_exists($contentFileFullPath)) {
        require_once($contentFileFullPath);
    }
}

?>