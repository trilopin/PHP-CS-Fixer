<?php

/*
 * This file is part of the PHP CS utility.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Symfony\CS\Tests\Fixer\PSR2;

use Symfony\CS\Tests\Fixer\AbstractFixerTestBase;

/**
 * @author Kuanhung Chen <ericj.tw@gmail.com>
 */
class MethodArgumentSpaceFixerTest extends AbstractFixerTestBase
{
    /**
     * @dataProvider testFixProvider
     */
    public function testFix($expected, $input = null)
    {
        $this->makeTest($expected, $input);
    }

    public function testFixProvider()
    {
        return array(
            // test method arguments
            array(
                '<?php function xyz($a=10, $b=20, $c=30) {',
                '<?php function xyz($a=10,$b=20,$c=30) {',
            ),
            // test method arguments with multiple spaces
            array(
                '<?php function xyz($a=10, $b=20, $c=30) {',
                '<?php function xyz($a=10,         $b=20 , $c=30) {',
            ),
            // test method call
            array(
                '<?php xyz($a=10, $b=20, $c=30);',
                '<?php xyz($a=10 ,$b=20,$c=30);',
            ),
            // test method call with multiple spaces
            array(
                '<?php xyz($a=10, $b=20, $c=30);',
                '<?php xyz($a=10 , $b=20 ,          $c=30);',
            ),
            // test method call with tab
            array(
                '<?php xyz($a=10, $b=20, $c=30);',
                "<?php xyz(\$a=10 , \$b=20 ,\t \$c=30);"
            ),
            // test method call with \n not affected
            array(
                "<?php xyz(\$a=10, \$b=20,\n                    \$c=30);"
            ),
            // test method call with \r\n not affected
            array(
                "<?php xyz(\$a=10, \$b=20,\r\n                    \$c=30);"
            ),
            // test method call
            array(
                '<?php xyz($a=10, $b=20, $this->foo(), $c=30);',
                '<?php xyz($a=10,$b=20 ,$this->foo() ,$c=30);',
            ),
            // test method call with multiple spaces
            array(
                '<?php xyz($a=10, $b=20, $this->foo(), $c=30);',
                '<?php xyz($a=10,$b=20 ,         $this->foo() ,$c=30);',
            ),
            // test receiving data in list context with omitted values
            array(
                '<?php list($a, $b, , , $c) = foo();',
                '<?php list($a, $b,, ,$c) = foo();',
            ),
            // test receiving data in list context with omitted values and multiple spaces
            array(
                '<?php list($a, $b, , , $c) = foo();',
                '<?php list($a, $b,,    ,$c) = foo();',
            ),
            // skip array
            array(
                '<?php array(10 , 20 ,30);',
            ),
            // multi line testing method arguments
            array(
                '<?php function xyz(
                    $a=10,
                    $b=20,
                    $c=30) {
                }',
                '<?php function xyz(
                    $a=10 ,
                    $b=20,
                    $c=30) {
                }',
            ),
            // multi line testing method call
            array(
                '<?php xyz(
                    $a=10,
                    $b=20,
                    $c=30
                    )',
                '<?php xyz(
                    $a=10 ,
                    $b=20,
                    $c=30
                    )',
            ),
            // skip multi line array
            array(
                '<?php
                    array(
                        10 ,
                        20,
                        30
                    );',
            ),
            // skip short array
            array(
                '<?php
    $foo = ["a"=>"apple", "b"=>"bed" ,"c"=>"car"];
    $foo = ["a" ,"b" ,"c"];
    ',
            ),
            // don't change HEREDOC and NOWDOC
            array(
                "<?php
    \$this->foo(
        <<<EOTXTa
    heredoc
EOTXTa
        ,
        <<<'EOTXTb'
    nowdoc
EOTXTb
        ,
        'foo'
    );
",
            ),
        );
    }
}
