<?php

namespace Framework\Http\Template;

interface TemplateRenderer
{
    public function render($name, array $params = []): string;
}
