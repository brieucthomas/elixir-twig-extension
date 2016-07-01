<?php

/*
 * (c) Brieuc Thomas <tbrieuc@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrieucThomas\Twig\Extension\tests;

use BrieucThomas\Twig\Extension\ElixirExtension;

/**
 * @author Brieuc Thomas <tbrieuc@gmail.com>
 */
class ElixirExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider fixtureProvider
     */
    public function testCompile($source, $expected)
    {
        $twig = new \Twig_Environment($this->getMockBuilder('Twig_LoaderInterface')->getMock(), ['cache' => false, 'autoescape' => false, 'optimizations' => 0]);
        $twig->addExtension(new ElixirExtension('public', 'build'));
        $nodes = $twig->parse($twig->tokenize($source));

        $this->assertEquals($expected, $nodes->getNode('body')->getNode(0));
    }

    public function fixtureProvider()
    {
        return array(
            array(
                '{{ elixir("css/all.css") }}',
                new \Twig_Node_Print(
                    new \Twig_Node_Expression_Function(
                        'elixir',
                        new \Twig_Node([
                            new \Twig_Node_Expression_Constant('css/all.css', 1),
                        ]),
                        1
                    ),
                    1
                ),
            ),
        );
    }

    public function testGetVersionedFilePath()
    {
        $elixir = new ElixirExtension(__DIR__, 'fixtures');

        $this->assertSame('fixtures/css/all-294af823e6.css', $elixir->getVersionedFilePath('css/all.css'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage File css/any.css not defined in asset manifest.
     */
    public function testDoNotAllowUnversionedFile()
    {
        $elixir = new ElixirExtension(__DIR__, 'fixtures');

        $elixir->getVersionedFilePath('css/any.css');
    }
}
