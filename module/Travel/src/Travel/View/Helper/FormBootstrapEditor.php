<?php
namespace Travel\View\Helper;

use AceLibrary\View\Helper\AbstractViewHelper;
use Zend\Json\Json;

class FormBootstrapEditor extends AbstractViewHelper
{

    public function __invoke($element, $options = null)
    {
        $attributes = $element->getAttributes();
        $output     = '<textarea name="' . $attributes['name'] . '" id="' . $attributes['id'] . '">' . $element->getValue() . '</textarea>';

        $defaultOptions = array(
            'groups' => array(
                array('group1', '', array('Bold', 'Italic', 'Underline', 'ForeColor', 'RemoveFormat')),
                array('group2', '', array('Bullets', 'Numbering', 'Indent', 'Outdent')),
                array('group3', '', array('Paragraph', 'FontSize', 'FontDialog', 'TextDialog')),
                array('group4', '', array('LinkDialog', 'ImageDialog', 'TableDialog', 'Emoticons', 'Snippets')),
                array('group5', '', array('Undo', 'Redo', 'FullScreen', 'SourceDialog')),
            ),
        );
        if ($options) {
            $options = array_merge($defaultOptions, $options);
        }
        else {
            $options = $defaultOptions;
        }
        $options = Json::encode($options);

        $output .= '<script type="text/javascript">
		$(document).ready(function () {
			$("#' . $attributes['id'] . '").liveEdit(
                ' . $options . '
			);
			$("#' . $attributes['id'] . '").data("liveEdit").startedit();
		})
		</script>';
        return $output;
    }
}
