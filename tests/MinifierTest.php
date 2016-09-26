<?php


namespace Nckg\Minify\Test;


use Nckg\Minify\Minifier;

class MinifierTest extends TestCase
{
    /** @test */
    public function it_shortens_multiple_white_spaces()
    {
        $string = '<a href="/foo" class="bar  moo        ">Hello World</a>';
        $expected = '<a href="/foo" class="bar moo ">Hello World</a>';
        $this->assertMinifiedString($expected, $string);
    }

    /** @test */
    public function it_removes_comments_except_ie_conditions()
    {
        $string = [
            '<!-- Hello World -->',
            '<!--[if lt IE 9]>',
            'Hello IE',
            '<![endif]-->',
        ];
        $expected = '<!--[if lt IE 9]>Hello IE<![endif]-->';
        $this->assertMinifiedString($expected, implode('', $string));
    }

    /** @test */
    public function it_collapses_new_lines()
    {
        $string = 'Hello
        World';
        $expected = 'Hello World';
        $this->assertMinifiedString($expected, $string);
    }

    /** @test */
    public function it_removes_comments()
    {
        $string = '// Hello World
        Batman';
        $expected = ' Batman';
        $this->assertMinifiedString($expected, $string);
    }

    /** @test */
    public function it_minifies_an_entire_page_correct()
    {
        $string = file_get_contents(__DIR__ . '/_data/page.html');
        $expected = file_get_contents(__DIR__ . '/_data/page-minified.html');
        $this->assertMinifiedString($expected, $string);
    }

    /**
     * @param $expected
     * @param $string
     */
    protected function assertMinifiedString($expected, $string)
    {
        $minifier = new Minifier();
        $this->assertSame($expected, $minifier->html($string));
    }
}