<?php

namespace Nckg\Minify;

class Minifier
{
    public $htmlFilters = [
        // Remove HTML comments except IE conditions
        '/(?s)<(pre|textarea)[^<]*>.*?<\\/(pre|textarea)>(*SKIP)(*F)|<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s' => '',
        // Remove comments in the form /* */
        '/(?s)<(pre|textarea)[^<]*>.*?<\\/(pre|textarea)>(*SKIP)(*F)|(?<!\S)\/\/\s*[^\r\n]*/' => '',
        // Shorten multiple white spaces
        '/(?s)<(pre|textarea)[^<]*>.*?<\\/(pre|textarea)>(*SKIP)(*F)|\s{2,}/' => ' ',
        // Remove whitespaces between HTML tags
        '/(?s)<(pre|textarea)[^<]*>.*?<\\/(pre|textarea)>(*SKIP)(*F)|>\s{2,}</' => '><',
        // Collapse new lines
        '/(?s)<(pre|textarea)[^<]*>.*?<\\/(pre|textarea)>(*SKIP)(*F)|(\r?\n)/' => '',
    ];

    /**
     * @param string $html
     *
     * @return string
     */
    public function html(string $html): string
    {
        $output = preg_replace(array_keys($this->htmlFilters), array_values($this->htmlFilters), $html);

        return $output;
    }
}
