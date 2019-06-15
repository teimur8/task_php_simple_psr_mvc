<?php

namespace Framework\Http\Template\Twig;

use Framework\Http\Template\TemplateRenderer;
use Twig\Environment;

class TwigRenderer implements TemplateRenderer
{
    private $twig;
    private $extension;

    public function __construct(Environment $twig, $extension = '.html.twig')
    {
        $this->twig = $twig;
        $this->extension = $extension;
    }

    public function render($name, array $params = []): string
    {
        return $this->twig->render($name . $this->extension, $params);
    }
}
