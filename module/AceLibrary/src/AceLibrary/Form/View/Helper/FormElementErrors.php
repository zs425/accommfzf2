<?php
namespace AceLibrary\Form\View\Helper;

use Zend\Form\View\Helper\FormElementErrors as OriginalFormElementErrors;

class FormElementErrors extends OriginalFormElementErrors  
{
    protected $messageCloseString     = '</div>';
    protected $messageOpenFormat      = '<div class="note note-error">';
    protected $messageSeparatorString = '</div><div>';
}