<?php

namespace spec\Spatie\Navigation\Displayers;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;

abstract class DisplayerBehavior extends ObjectBehavior
{
    public function getMatchers() : array
    {
        return [
            'returnHtml' => function (string $subject, string $html) {

                $subject = $this->sanitizeHtmlWhitespace($subject);
                $html = $this->sanitizeHtmlWhitespace($html);

                if ($subject !== $html) {
                    throw new FailureException("expected {$html} but got {$subject}");
                }

                return true;
            },
        ];
    }

    public function sanitizeHtmlWhitespace(string $subject) : string
    {
        $find = ['/>\s+</', '/(^\s+)|(\s+$)/'];
        $replace = ['><', ''];

        return preg_replace($find, $replace, $subject);
    }
}
