<?php

require_once '../RandomString.php';
require_once 'HTML/QuickForm.php';



// Instantiate the HTML_QuickForm object
$form = new HTML_QuickForm('random');

/// Illustration of customizing required notes for n00b973
require_once 'HTML/QuickForm/Renderer/Default.php';
class MyCustomRenderer extends HTML_QuickForm_Renderer_Default
{
    var $_elementTemplate = 
        "\n\t<tr>\n\t\t<td align=\"right\" valign=\"top\"><!-- BEGIN required --><span style=\"color: #ffff00\">@</span><!-- END required --><b>{label}</b></td>\n\t\t<td valign=\"top\" align=\"left\"><!-- BEGIN error --><span style=\"color: #ff0000\">{error}</span><br /><!-- END error -->\t{element}</td>\n\t</tr>";
}

// Update required note on form object
$form->setRequiredNote('<span style="font-size:80%; color:#ffff00;">@</span><span style="font-size:80%;"> denotes required field</span>');

// Add renderer
$renderer = new MyCustomRenderer();
// End custom renderer creation, but don't accept it until the end of the form

// Set defaults for the form elements
$form->setDefaults(array(
    'lines'      => 1,
    'length'     => 8,
    'useLower'   => 'checked',
    'useUpper'   => 'checked',
    'useNumbers' => 'checked',
    'useChars'   => '',
));

// Add some elements to the form
$form->addElement('header', null, 'Bill\'s Random String Generator');
$form->addElement('text', 'length', 'String length:', array('size' => 2, 'maxlength' => 2));
$form->addElement('text', 'lines', 'Number of strings:', array('size' => 2, 'maxlength' => 2));
$form->addElement('checkbox', 'useLower', 'Use lower case (a-z):');
$form->addElement('checkbox', 'useUpper', 'Use upper case (A-Z):');
$form->addElement('checkbox', 'useNumbers', 'Use integers(0-9):');
$form->addElement('checkbox', 'useChars', 'Use symbols (!$%^...):');
$form->addElement('submit', null, 'Generate!');

// Rules
$form->addRule('length', 'Length is required', 'required', '', 'client');
$form->addRule('lines', 'Number of strings required', 'required', '', 'client');

// Output
echo "<html><body><center>\n";

// Accept renderer and display
$form->accept($renderer);
echo $renderer->toHtml();

// Try to validate, and generate strings if valid
if ($form->validate()) {
    try {
        $r = new RandomString();

        $r->setOption('useChars', (bool) $form->exportValue('useChars'));
        $r->setOption('useLower', (bool) $form->exportValue('useLower'));
        $r->setOption('useUpper', (bool) $form->exportValue('useUpper'));
        $r->setOption('useNumbers', (bool) $form->exportValue('useNumbers'));
        $r->setOption('lines', $form->exportValue('lines'));
        $r->setOption('length', $form->exportValue('length'));

        foreach ($r->getStrings() as $string) {
            echo "<h2>$string</h2>";
        }
    } catch (Exception $e) {
        echo "<h2>Error: " . $e->getMessage() . "</h2>\n";
    }
}

echo "<a href='http://github.com/shupp/RandomString'>Code</a>\n";
echo "</center></body></html>";

?> 
