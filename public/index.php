<?php

require_once '../RandomString.php';
require_once 'HTML/QuickForm.php';

// Instantiate the HTML_QuickForm object
$form = new HTML_QuickForm('random');

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


// Output
echo "<html><body><center>\n";
$form->display();

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
